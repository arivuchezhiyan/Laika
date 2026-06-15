<?php
require_once 'header.php';
require_once 'side-bar.php';
require_once 'secure/db_connect.php';
require_once 'secure/blog_helpers.php';

// Handle delete request
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    // Optional: Delete associated image file to save space?
    $stmt_img = $conn->prepare("SELECT image_path FROM posts WHERE post_id=?");
    $stmt_img->bind_param("i", $delete_id);
    $stmt_img->execute();
    $stmt_img->bind_result($del_img_path);
    if ($stmt_img->fetch()) {
        if ($del_img_path && file_exists("../" . $del_img_path)) {
            unlink("../" . $del_img_path);
        }
    }
    $stmt_img->close();
    
    // Delete from post_tags first (Foreign Key Fix)
    $stmt_tags = $conn->prepare("DELETE FROM post_tags WHERE post_id=?");
    $stmt_tags->bind_param("i", $delete_id);
    $stmt_tags->execute();
    $stmt_tags->close();

    $stmt = $conn->prepare("DELETE FROM posts WHERE post_id=?");
    
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        $msg = "Blog deleted successfully!";
        $msg_type = "success";
    } else {
        $msg = "Failed to delete blog.";
        $msg_type = "danger";
    }
    $stmt->close();
}

// Fetch all blogs
$blogs = [];
// Try 'posts' table first, then fallback
$sql = "SELECT p.*, c.category_name 
        FROM posts p 
        LEFT JOIN category c ON p.category_id = c.category_id 
        ORDER BY p.created_at DESC";
$res = $conn->query($sql);

if ($res) {
    while ($row = $res->fetch_assoc()) {
        $blogs[] = $row;
    }
}
?>

<main class="main-content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">My Blogs</h3>
            <a href="create-blog" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Write New Blog
            </a>
        </div>

        <?php if (isset($msg)): ?>
            <div class="alert alert-<?php echo $msg_type; ?>"><?php echo $msg; ?></div>
        <?php endif; ?>

        <?php if (empty($blogs)): ?>
            <div class="alert alert-info">No blog posts found. Start by creating one!</div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($blogs as $blog): ?>
                <div class="col-md-6 col-xl-4 mb-4">
                    <div class="card h-100">
                        <!-- Image -->
                        <div style="height: 200px; overflow: hidden; background: #f8f9fa;">
                            <?php if (!empty($blog['image_path'])): ?>
                                <!-- Check if path is full url or relative. Assume stored as 'images/blogs/...' -->
                                <img src="../<?php echo htmlspecialchars(resolve_blog_image_path($blog['image_path'])); ?>" 
                                     class="card-img-top" 
                                     style="width: 100%; height: 100%; object-fit: cover;"
                                     onerror="this.src='https://via.placeholder.com/400x200?text=No+Image'">
                            <?php else: ?>
                                <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                    <i class="fas fa-image fa-3x"></i>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold text-truncate" title="<?php echo htmlspecialchars($blog['post_title']); ?>">
                                <?php echo htmlspecialchars($blog['post_title']); ?>
                            </h5>
                            
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <span class="badge <?php echo $blog['post_status'] === 'published' ? 'bg-success' : 'bg-warning'; ?> me-1">
                                        <?php echo $blog['post_status'] === 'published' ? 'Live' : ucfirst($blog['post_status']); ?>
                                    </span>
                                    <?php if ($blog['category_name']): ?>
                                    <span class="badge bg-secondary">
                                        <?php echo htmlspecialchars($blog['category_name']); ?>
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="text-muted small mb-2">
                                <?php echo date('M d, Y', strtotime($blog['created_at'])); ?>
                            </div>

                            <p class="card-text text-muted small flex-grow-1">
                                <?php 
                                    $desc = strip_tags($blog['post_content']);
                                    echo mb_strimwidth($desc, 0, 100, "..."); 
                                ?>
                            </p>
                            
                            <div class="mt-3 d-flex justify-content-between">
                                <a href="edit-blog?id=<?php echo $blog['post_id']; ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>
                                <a href="my-blogs?delete=<?php echo $blog['post_id']; ?>" 
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Are you sure you want to delete this post? This action cannot be undone.');">
                                    <i class="fas fa-trash-alt me-1"></i> Delete
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>
</body>
</html>
