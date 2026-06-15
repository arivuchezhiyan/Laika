<?php
require_once 'secure/auth.php';
require_login();
require_once 'secure/db_connect.php';
require_once 'secure/blog_helpers.php';

// Handle new blog post submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'], $_POST['content'])) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid request.';
    } else {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $meta_title = trim($_POST['meta_title'] ?? $title);
    $meta_description = trim($_POST['meta_description'] ?? substr(strip_tags($content),0,160));
    $meta_keyword = trim($_POST['meta_keyword'] ?? '');
    $category_id = normalize_category_id($conn, $_POST['category_id'] ?? null);
    $post_status = in_array($_POST['post_status'] ?? 'draft', ['draft', 'published'], true) ? $_POST['post_status'] : 'draft';
    $slug = build_slug($conn, $title, 'posts', 'post_slug');

    // Handle Publish Date
    $published_at = null;
    if (!empty($_POST['published_at'])) {
        $published_at = date('Y-m-d H:i:s', strtotime($_POST['published_at']));
    } elseif ($post_status === 'published') {
        $published_at = date('Y-m-d H:i:s');
    }

    if ($title === '' || $content === '') {
        $error = 'Title and content are required.';
    }

    $image_path = '';
    if (!isset($error)) {
        [$image_path, $upload_error] = handle_blog_image_upload($_FILES['image'] ?? []);
        if ($upload_error !== null) {
            $error = $upload_error;
        }
    }

    if (!isset($error)) {
    $stmt = $conn->prepare("INSERT INTO posts 
        (post_title, post_content, post_slug, category_id, meta_title, meta_description, meta_keyword, image_path, post_status, created_at, updated_at, published_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), ?)");
    
    $stmt->bind_param("sssissssss", 
        $title, $content, $slug, $category_id, $meta_title, $meta_description, $meta_keyword, $image_path, $post_status, $published_at
    );

    if ($stmt->execute()) {
        $post_id = $stmt->insert_id;

        // Handle tags (comma separated)
        if (!empty($_POST['tags'])) {
            $tags = array_map('trim', explode(',', $_POST['tags']));
            foreach ($tags as $tag_name) {
                if (!$tag_name) continue;
                $tag_slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $tag_name));
                $tag_stmt = $conn->prepare("SELECT tag_id FROM tags WHERE tag_slug = ?");
                $tag_stmt->bind_param("s", $tag_slug);
                $tag_stmt->execute();
                $tag_stmt->store_result();

                if ($tag_stmt->num_rows > 0) {
                    $tag_stmt->bind_result($tag_id);
                    $tag_stmt->fetch();
                } else {
                    $insert_tag = $conn->prepare("INSERT INTO tags (tag_name, tag_slug) VALUES (?, ?)");
                    $insert_tag->bind_param("ss", $tag_name, $tag_slug);
                    $insert_tag->execute();
                    $tag_id = $insert_tag->insert_id;
                }
                $post_tag = $conn->prepare("INSERT INTO post_tags (post_id, tag_id) VALUES (?, ?)");
                $post_tag->bind_param("ii", $post_id, $tag_id);
                $post_tag->execute();
            }
        }

        echo "<script>alert('Blog posted successfully!'); window.location.href='create-blog';</script>";
        exit;
    } else {
        echo "Error: " . $stmt->error;
        exit;
    }
    }
    }
}

// Handle AJAX: Add Category
if (isset($_POST['ajax']) && $_POST['ajax'] === 'add_category') {
    header('Content-Type: application/json');
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        echo json_encode(['success'=>false, 'msg'=>'Invalid request']);
        exit;
    }
    $cat_name = trim($_POST['category_name'] ?? '');
    if ($cat_name) {
        $cat_slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $cat_name));
        $stmt = $conn->prepare("INSERT INTO category (category_name, category_slug) VALUES (?, ?)");
        $stmt->bind_param("ss", $cat_name, $cat_slug);
        if ($stmt->execute()) {
            echo json_encode(['success'=>true, 'id'=>$stmt->insert_id, 'name'=>$cat_name]);
        } else {
            echo json_encode(['success'=>false, 'msg'=>'Category exists or error']);
        }
    } else {
        echo json_encode(['success'=>false, 'msg'=>'Category name required']);
    }
    exit;
}

// Handle AJAX: Add Tag
if (isset($_POST['ajax']) && $_POST['ajax'] === 'add_tag') {
    header('Content-Type: application/json');
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        echo json_encode(['success'=>false, 'msg'=>'Invalid request']);
        exit;
    }
    $tag_name = trim($_POST['tag_name'] ?? '');
    if ($tag_name) {
        $tag_slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $tag_name));
        $stmt = $conn->prepare("INSERT INTO tags (tag_name, tag_slug) VALUES (?, ?)");
        $stmt->bind_param("ss", $tag_name, $tag_slug);
        if ($stmt->execute()) {
            echo json_encode(['success'=>true, 'id'=>$stmt->insert_id, 'name'=>$tag_name]);
        } else {
            echo json_encode(['success'=>false, 'msg'=>'Tag exists or error']);
        }
    } else {
        echo json_encode(['success'=>false, 'msg'=>'Tag name required']);
    }
    exit;
}

// Fetch categories for the dropdown
$categories = [];
$cat_res = $conn->query("SELECT * FROM category ORDER BY category_name ASC");
if ($cat_res) {
    while ($row = $cat_res->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Fetch tags for the dropdown
$tags = [];
$tag_res = $conn->query("SELECT * FROM tags ORDER BY tag_name ASC");
if ($tag_res) {
    while ($row = $tag_res->fetch_assoc()) {
        $tags[] = $row;
    }
}
?>

<?php require_once 'header.php'; ?>
<?php require_once 'side-bar.php'; ?>

<!-- Include Quill CSS/JS here -->
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery for AJAX -->
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>

<main class="main-content">
    <div class="container-fluid">
        <h3 class="mb-4 fw-bold">Create New Blog Post</h3>
        
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form method="POST" action="" enctype="multipart/form-data" id="blogForm">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Title</label>
                        <input type="text" name="title" class="form-control" required placeholder="Enter blog title">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Content</label>
                        <div id="quill-editor" style="height: 300px;"></div>
                        <input type="hidden" name="content" id="content">
                    </div>

                    <div class="row align-items-end mb-3">
                        <div class="col-md-9 mb-2 mb-md-0">
                            <label class="form-label fw-bold">Category</label>
                            <select name="category_id" class="form-select" id="categorySelect">
                                <option value="0">Select Category</option>
                                <?php foreach($categories as $cat): ?>
                                    <option value="<?= $cat['category_id'] ?>"><?= htmlspecialchars($cat['category_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                <i class="fas fa-plus me-1"></i> Add Category
                            </button>
                        </div>
                    </div>

                    <div class="row align-items-end mb-3">
                        <div class="col-md-9 mb-2 mb-md-0">
                            <label class="form-label fw-bold">Tags</label>
                            <div id="tagsCheckboxes" class="form-control" style="min-height: 50px; height: auto;">
                                <?php foreach($tags as $tag): ?>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input tag-checkbox" type="checkbox" id="tag_<?= $tag['tag_id'] ?>" value="<?= htmlspecialchars($tag['tag_name']) ?>">
                                        <label class="form-check-label" for="tag_<?= $tag['tag_id'] ?>"><?= htmlspecialchars($tag['tag_name']) ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <input type="hidden" name="tags" id="tagsInput">
                        </div>
                        <div class="col-md-3">
                             <button type="button" class="btn btn-outline-secondary w-100" data-bs-toggle="modal" data-bs-target="#addTagModal">
                                <i class="fas fa-tag me-1"></i> Add Tag
                            </button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Featured Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <div class="form-text">Recommended size: 1200x630 px.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Publish Date & Time</label>
                        <input type="datetime-local" name="published_at" class="form-control">
                        <div class="form-text">Leave blank to use current time when publishing.</div>
                    </div>

                    <hr class="my-4">
                    <h5 class="fw-bold mb-3">SEO Settings (Optional)</h5>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" placeholder="SEO Title">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Meta Keywords</label>
                            <input type="text" name="meta_keyword" class="form-control" placeholder="Keywords (comma separated)">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Meta Description</label>
                        <input type="text" name="meta_description" class="form-control" placeholder="Short description for search engines">
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="dashboard" class="btn btn-light text-muted">Cancel</a>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-secondary" name="post_status" value="draft">Save Draft</button>
                            <button type="submit" class="btn btn-primary px-4" name="post_status" value="published">Publish Post</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</main>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="addCategoryForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="text" name="category_name" class="form-control" placeholder="Category Name" required>
        <div id="catMsg" class="text-danger mt-2 small"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add Category</button>
      </div>
    </form>
  </div>
</div>

<!-- Add Tag Modal -->
<div class="modal fade" id="addTagModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="addTagForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Tag</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="text" name="tag_name" class="form-control" placeholder="Tag Name" required>
        <div id="tagMsg" class="text-danger mt-2 small"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-secondary">Add Tag</button>
      </div>
    </form>
  </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Initialize Quill
    var quill = new Quill('#quill-editor', {
        theme: 'snow',
        placeholder: 'Write your blog post here...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'image'],
                ['clean']
            ]
        }
    });

    // Sync content on submit
    document.querySelector('form#blogForm').onsubmit = function() {
        document.querySelector('#content').value = quill.root.innerHTML;
        // Also sync tags
        var selected = [];
        $('.tag-checkbox:checked').each(function() {
            selected.push($(this).val());
        });
        $('#tagsInput').val(selected.join(','));
    };

    // Add Category AJAX
    $('#addCategoryForm').submit(function(e){
        e.preventDefault();
        var catName = $(this).find('input[name="category_name"]').val();
        $.post('', {ajax:'add_category', category_name:catName, csrf_token:'<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>'}, function(resp){
            if(resp.success){
                $('#categorySelect').append('<option value="'+resp.id+'" selected>'+resp.name+'</option>');
                
                // Close modal (BS5)
                var modalEl = document.getElementById('addCategoryModal');
                var modal = bootstrap.Modal.getInstance(modalEl);
                modal.hide();

                $('#addCategoryForm')[0].reset();
                $('#catMsg').text('');
            } else {
                $('#catMsg').text(resp.msg || 'Error adding category');
            }
        },'json');
    });

    // Add Tag AJAX
    $('#addTagForm').submit(function(e){
        e.preventDefault();
        var tagName = $(this).find('input[name="tag_name"]').val();
        $.post('', {ajax:'add_tag', tag_name:tagName, csrf_token:'<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>'}, function(resp){
            if(resp.success){
                var tagId = 'tag_new_' + resp.id;
                var $newCheckbox = $('<div class="form-check form-check-inline">' +
                    '<input class="form-check-input tag-checkbox" type="checkbox" id="'+tagId+'" value="'+resp.name+'" checked>' +
                    '<label class="form-check-label" for="'+tagId+'">'+resp.name+'</label>' +
                    '</div>');
                $('#tagsCheckboxes').append($newCheckbox);
                
                // Close modal (BS5)
                var modalEl = document.getElementById('addTagModal');
                var modal = bootstrap.Modal.getInstance(modalEl);
                modal.hide();

                $('#addTagForm')[0].reset();
                $('#tagMsg').text('');
            } else {
                $('#tagMsg').text(resp.msg || 'Error adding tag');
            }
        },'json');
    });
</script>

</body>
</html>
