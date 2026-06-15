<?php
require_once 'secure/auth.php';
require_login();
require_once 'secure/db_connect.php';
require_once 'secure/blog_helpers.php';

// Get blog ID from query string
$post_id = intval($_GET['id'] ?? 0);
if (!$post_id) {
    require_once 'header.php'; 
    require_once 'side-bar.php';
    echo "<div class='main-content'><div class='container-fluid'><div class='alert alert-danger'>Invalid Request</div></div></div>";
    echo "</body></html>";
    exit;
}

// Ajax Handlers (Add Category, Add Tag)
if (isset($_POST['ajax'])) {
    header('Content-Type: application/json');
    $response = ['success' => false, 'msg' => 'Unknown action'];
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        echo json_encode(['success' => false, 'msg' => 'Invalid request']);
        exit;
    }
    
    if ($_POST['ajax'] === 'add_category') {
        $name = trim($_POST['category_name'] ?? '');
        if ($name) {
            $slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $name));
            $stmt = $conn->prepare("INSERT INTO category (category_name, category_slug) VALUES (?, ?)");
            $stmt->bind_param("ss", $name, $slug);
            if ($stmt->execute()) {
                $response = ['success' => true, 'id' => $stmt->insert_id, 'name' => $name];
            } else {
                $response['msg'] = 'Category may already exist.';
            }
        }
    } elseif ($_POST['ajax'] === 'add_tag') {
        $name = trim($_POST['tag_name'] ?? '');
        if ($name) {
            $slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $name));
            $stmt = $conn->prepare("INSERT INTO tags (tag_name, tag_slug) VALUES (?, ?)");
            $stmt->bind_param("ss", $name, $slug);
            if ($stmt->execute()) {
                $response = ['success' => true, 'id' => $stmt->insert_id, 'name' => $name];
            } else {
                $response['msg'] = 'Tag may already exist.';
            }
        }
    }
    echo json_encode($response);
    exit;
}

// Fetch Post
$stmt = $conn->prepare("SELECT * FROM posts WHERE post_id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$post) {
    echo "<div class='main-content'><div class='container-fluid'><div class='alert alert-danger'>Post not found</div></div></div>";
    exit;
}

// Fetch current tags
$cur_tags = [];
$ts = $conn->prepare("SELECT t.tag_name, t.tag_id FROM tags t JOIN post_tags pt ON t.tag_id = pt.tag_id WHERE pt.post_id = ?");
$ts->bind_param("i", $post_id);
$ts->execute();
$res = $ts->get_result();
while ($r = $res->fetch_assoc()) $cur_tags[] = $r['tag_name'];
$ts->close();

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['ajax'])) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = "Invalid request.";
    } else {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category_id = normalize_category_id($conn, $_POST['category_id'] ?? null);
    $post_status = in_array($_POST['post_status'] ?? 'draft', ['draft', 'published'], true) ? $_POST['post_status'] : 'draft';
    
    // Slugs & Meta
    $slug = build_slug($conn, $title, 'posts', 'post_slug', $post_id);
    $meta_title = $_POST['meta_title'] ?: $title;
    $desc_raw = strip_tags($content);
    $meta_desc = $_POST['meta_description'] ?: (strlen($desc_raw) > 157 ? substr($desc_raw, 0, 157) . '...' : $desc_raw);
    $meta_kw = $_POST['meta_keyword'] ?? '';
    
    // Image
    $image_path = $post['image_path'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        [$new_image_path, $upload_error] = handle_blog_image_upload($_FILES['image']);
        if ($upload_error !== null) {
            $error = $upload_error;
        } else {
            $image_path = $new_image_path;
        }
    }
    
    if (!isset($error) && ($title === '' || $content === '')) {
        $error = "Title and content are required.";
    }

    $now = date('Y-m-d H:i:s');
    $pub_at = $post['published_at'];
    if (!empty($_POST['published_at'])) {
        $pub_at = date('Y-m-d H:i:s', strtotime($_POST['published_at']));
    } elseif ($post_status === 'published' && empty($pub_at)) {
        $pub_at = $now;
    }
    
    $sql = "UPDATE posts SET post_title=?, post_slug=?, category_id=?, post_status=?, post_content=?, meta_title=?, meta_description=?, meta_keyword=?, updated_at=?, published_at=?, image_path=? WHERE post_id=?";
    $stmt = $conn->prepare($sql);
    
    if (!isset($error) && $stmt) {
        $stmt->bind_param("ssissssssssi", $title, $slug, $category_id, $post_status, $content, $meta_title, $meta_desc, $meta_kw, $now, $pub_at, $image_path, $post_id);
        if ($stmt->execute()) {
            
            // Update Tags
            $conn->query("DELETE FROM post_tags WHERE post_id = $post_id");
            if (!empty($_POST['tags'])) {
                 $tags_arr = explode(',', $_POST['tags']);
                 foreach ($tags_arr as $t) {
                     $t = trim($t);
                     if (!$t) continue;
                     
                     // Resolve ID
                     $ft = $conn->prepare("SELECT tag_id FROM tags WHERE tag_name = ?");
                     $ft->bind_param("s", $t);
                     $ft->execute();
                     $res = $ft->get_result();
                     if ($r = $res->fetch_assoc()) {
                         $tid = $r['tag_id'];
                     } else {
                          $tslug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $t));
                          $ins = $conn->prepare("INSERT INTO tags (tag_name, tag_slug) VALUES (?, ?)");
                          $ins->bind_param("ss", $t, $tslug);
                          $ins->execute();
                          $tid = $ins->insert_id;
                     }
                     $ft->close();
                     
                     if (isset($tid)) {
                         $pt = $conn->prepare("INSERT INTO post_tags (post_id, tag_id) VALUES (?, ?)");
                         $pt->bind_param("ii", $post_id, $tid);
                         $pt->execute();
                         $pt->close();
                     }
                 }
            }
            
            $success = "Post updated successfully.";
            // Refresh post data
            $stmt = $conn->prepare("SELECT * FROM posts WHERE post_id=?");
            $stmt->bind_param("i", $post_id);
            $stmt->execute();
            $post = $stmt->get_result()->fetch_assoc();
             
             // Refresh tags
            $cur_tags = [];
            $ts = $conn->prepare("SELECT t.tag_name FROM tags t JOIN post_tags pt ON t.tag_id = pt.tag_id WHERE pt.post_id = ?");
            $ts->bind_param("i", $post_id);
            $ts->execute();
            $res = $ts->get_result();
            while ($r = $res->fetch_assoc()) $cur_tags[] = $r['tag_name'];

        } else {
            $error = "DB Error: " . $stmt->error;
        }
        $stmt->close();
    }
    }
}

// Fetch Lists
$cats = [];
$cr = $conn->query("SELECT * FROM category ORDER BY category_name ASC");
while ($r = $cr->fetch_assoc()) $cats[] = $r;

$tags_all = [];
$tr = $conn->query("SELECT * FROM tags ORDER BY tag_name ASC");
while ($r = $tr->fetch_assoc()) $tags_all[] = $r;

?>

<?php require_once 'header.php'; ?>
<?php require_once 'side-bar.php'; ?>

<!-- Quill -->
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<style>
.blog-thumb-preview { width:100%; height:auto; max-height:200px; object-fit:cover; border-radius:10px; margin-bottom:15px; }
.modal-backdrop.show { opacity: 0.2; }
</style>

<main class="main-content">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h3 class="fw-bold mb-4">Edit Post: <?php echo htmlspecialchars($post['post_title']); ?></h3>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <form method="POST" enctype="multipart/form-data" id="blogForm">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Post Title</label>
                                <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($post['post_title']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Content</label>
                                <div id="editor" style="height: 300px;"><?php echo $post['post_content']; ?></div>
                                <input type="hidden" name="content" id="contentArea">
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">SEO Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Meta Title</label>
                                <input type="text" name="meta_title" class="form-control" value="<?php echo htmlspecialchars($post['meta_title']); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Meta Description</label>
                                <textarea name="meta_description" class="form-control" rows="3"><?php echo htmlspecialchars($post['meta_description']); ?></textarea>
                            </div>
                             <div class="mb-3">
                                <label class="form-label">Keywords</label>
                                <input type="text" name="meta_keyword" class="form-control" value="<?php echo htmlspecialchars($post['meta_keyword']); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Publish</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label>Status: <span class="badge bg-secondary"><?php echo htmlspecialchars($post['post_status']); ?></span></label>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Publish Date & Time</label>
                                <input type="datetime-local" name="published_at" class="form-control" value="<?php echo $post['published_at'] ? date('Y-m-d\TH:i', strtotime($post['published_at'])) : ''; ?>">
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" name="post_status" value="published" class="btn btn-primary">Update & Publish</button>
                                <button type="submit" name="post_status" value="draft" class="btn btn-secondary">Save as Draft</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mb-4">
                         <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Category</h5>
                            <button type="button" class="btn btn-sm btn-link" data-bs-toggle="modal" data-bs-target="#addCatModal">+ Add</button>
                        </div>
                        <div class="card-body">
                            <select name="category_id" id="catSelect" class="form-select">
                                <option value="">Select Category</option>
                                <?php foreach($cats as $c): ?>
                                    <option value="<?php echo $c['category_id']; ?>" <?php echo $c['category_id'] == $post['category_id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($c['category_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="card mb-4">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Tags</h5>
                             <button type="button" class="btn btn-sm btn-link" data-bs-toggle="modal" data-bs-target="#addTagModal">+ Add</button>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2" id="tagContainer">
                                <?php foreach($tags_all as $t): ?>
                                    <div class="form-check">
                                        <input class="form-check-input tag-chk" type="checkbox" value="<?php echo htmlspecialchars($t['tag_name']); ?>" id="tag_<?php echo $t['tag_id']; ?>" 
                                        <?php echo in_array($t['tag_name'], $cur_tags) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="tag_<?php echo $t['tag_id']; ?>">
                                            <?php echo htmlspecialchars($t['tag_name']); ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <input type="hidden" name="tags" id="finalTags">
                        </div>
                    </div>
                    
                    <div class="card mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Featured Image</h5>
                        </div>
                        <div class="card-body">
                            <?php if ($post['image_path']): ?>
                                <img src="../<?php echo htmlspecialchars(resolve_blog_image_path($post['image_path'])); ?>" class="blog-thumb-preview" alt="Current Image">
                            <?php endif; ?>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
</main>

<!-- Modals -->
<div class="modal fade" id="addCatModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="addCatForm" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" name="category_name" class="form-control" placeholder="Name" required>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="addTagModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="addTagForm" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Tag</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" name="tag_name" class="form-control" placeholder="Name" required>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var quill = new Quill('#editor', {theme: 'snow'});
    
    document.getElementById('blogForm').onsubmit = function() {
        document.getElementById('contentArea').value = quill.root.innerHTML;
        var tags = [];
        $('.tag-chk:checked').each(function(){ tags.push($(this).val()); });
        $('#finalTags').val(tags.join(','));
    };
    
    $('#addCatForm').on('submit', function(e){
        e.preventDefault();
        $.post('', $(this).serialize() + '&ajax=add_category&csrf_token=<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>', function(res){
            if(res.success) {
                $('#catSelect').append(new Option(res.name, res.id, true, true));
                $('#addCatModal').modal('hide');
                $('#addCatForm')[0].reset();
            } else { alert(res.msg); }
        });
    });
    
    $('#addTagForm').on('submit', function(e){
        e.preventDefault();
        $.post('', $(this).serialize() + '&ajax=add_tag&csrf_token=<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>', function(res){
            if(res.success) {
                var html = '<div class="form-check"><input class="form-check-input tag-chk" type="checkbox" value="'+res.name+'" checked id="tag_new_'+res.id+'"><label class="form-check-label" for="tag_new_'+res.id+'">'+res.name+'</label></div>';
                $('#tagContainer').append(html);
                $('#addTagModal').modal('hide');
                $('#addTagForm')[0].reset();
            } else { alert(res.msg); }
        });
    });
</script>
</body>
</html>
