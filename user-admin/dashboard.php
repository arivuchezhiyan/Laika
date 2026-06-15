<?php
require_once 'header.php';
require_once 'side-bar.php';
require_once 'secure/db_connect.php';

// Fetch statistics
$total_blogs = 0;
$total_users = 0;

if (!isset($db_connection_error)) {
    // Total Blogs
    $res = $conn->query("SELECT COUNT(*) as count FROM posts");
    if ($res) $total_blogs = $res->fetch_assoc()['count'];
    
    // Total Users
    $res = $conn->query("SELECT COUNT(*) as count FROM users");
    if ($res) $total_users = $res->fetch_assoc()['count'];
}
?>

<main class="main-content">
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-0">Blog Dashboard</h3>
                <p class="text-muted small mb-0 font-secondary">Laika Pet Clinic • Content Management Center</p>
            </div>
        </div>

        <!-- Primary Stats Grid -->
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm stats-card h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="stats-icon bg-soft-success">
                                <i class="fas fa-newspaper text-success"></i>
                            </div>
                            <span class="badge bg-soft-success text-success small rounded-pill">Blogs</span>
                        </div>
                        <h3 class="fw-bold mb-1"><?php echo $total_blogs; ?></h3>
                        <p class="text-muted small mb-0 fw-medium">Published & Draft Posts</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm stats-card h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="stats-icon bg-soft-primary">
                                <i class="fas fa-users text-primary"></i>
                            </div>
                            <span class="badge bg-soft-primary text-primary small rounded-pill">Users</span>
                        </div>
                        <h3 class="fw-bold mb-1"><?php echo $total_users; ?></h3>
                        <p class="text-muted small mb-0 fw-medium">Admin & Writer Accounts</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Left: Recent Blog Posts -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100 rounded-lg overflow-hidden">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center p-4">
                        <h5 class="fw-bold mb-0">Recent Blog Posts</h5>
                        <a href="my-blogs" class="btn btn-soft-dark btn-sm rounded-pill px-3">View All Blogs</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead style="background: #fafbfc;">
                                    <tr>
                                        <th class="ps-4 py-3 border-0 small text-uppercase fw-bold text-muted">Blog Title</th>
                                        <th class="py-3 border-0 small text-uppercase fw-bold text-muted">Status</th>
                                        <th class="py-3 border-0 small text-uppercase fw-bold text-muted">Date</th>
                                        <th class="text-end pe-4 py-3 border-0 small text-uppercase fw-bold text-muted">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!isset($db_connection_error)) {
                                        $recent_res = $conn->query("SELECT * FROM posts ORDER BY created_at DESC LIMIT 5");
                                        if ($recent_res && $recent_res->num_rows > 0):
                                            while ($post = $recent_res->fetch_assoc()):
                                    ?>
                                    <tr class="hover-row">
                                        <td class="ps-4 py-3">
                                            <div>
                                                <div class="fw-bold text-dark font-primary"><?php echo htmlspecialchars($post['post_title']); ?></div>
                                                <div class="text-muted small">/<?php echo htmlspecialchars($post['post_slug']); ?></div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if ($post['post_status'] === 'published'): ?>
                                                <span class="badge bg-soft-success text-success rounded-pill">Published</span>
                                            <?php else: ?>
                                                <span class="badge bg-soft-warning text-warning rounded-pill">Draft</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><span class="small text-dark fw-medium"><?php echo date('M d, Y', strtotime($post['created_at'])); ?></span></td>
                                        <td class="text-end pe-4">
                                            <a href="edit-blog?id=<?php echo $post['post_id']; ?>" class="btn btn-icon-round"><i class="fas fa-edit"></i></a>
                                        </td>
                                    </tr>
                                    <?php 
                                            endwhile; 
                                        else: 
                                    ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <i class="fas fa-newspaper fa-3x text-muted opacity-25 mb-3 d-block mx-auto"></i>
                                            <p class="text-muted small mb-0">No blog posts found. Create your first post now!</p>
                                        </td>
                                    </tr>
                                    <?php 
                                        endif;
                                    } else {
                                    ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-danger small">
                                            <i class="fas fa-exclamation-triangle fa-2x mb-2 d-block mx-auto"></i>
                                            Database connection is required to fetch posts.
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Quick Actions -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4 promo-card" style="background: linear-gradient(135deg, #ed1f31, #3b53a4);">
                    <div class="card-body p-4">
                        <h4 class="fw-bold text-white mb-2">Publish Article</h4>
                        <p class="text-white opacity-75 small mb-4">Post a new update, insights, or announcements to your visitors.</p>
                        <a href="create-blog" class="btn btn-white btn-sm fw-bold rounded-pill px-4" style="color: #ed1f31;">New Blog Post</a>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-lg">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-dark mb-4">Quick Links</h5>
                        <div class="quick-action-list">
                            <a href="create-blog" class="action-item">
                                <div class="icon-box bg-soft-success"><i class="fas fa-plus text-success fs-6"></i></div>
                                <div class="flex-grow-1">
                                    <div class="title">Create Blog</div>
                                    <div class="subtitle">Write a new article</div>
                                </div>
                                <i class="fas fa-chevron-right text-muted opacity-25 x-small"></i>
                            </a>
                            <a href="my-blogs" class="action-item border-0">
                                <div class="icon-box bg-soft-primary"><i class="fas fa-layer-group text-primary fs-6"></i></div>
                                <div class="flex-grow-1">
                                    <div class="title">Manage Blogs</div>
                                    <div class="subtitle">Edit or remove posts</div>
                                </div>
                                <i class="fas fa-chevron-right text-muted opacity-25 x-small"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
/* Dashboard Styling Extension */
.stats-card { border-radius: 24px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
.stats-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.08) !important; }

.stats-icon { 
    width: 52px; height: 52px; border-radius: 16px; display: flex; 
    align-items: center; justify-content: center; font-size: 1.3rem;
}

.promo-card { 
    background: linear-gradient(135deg, #ed1f31, #3b53a4); 
    border-radius: 24px; 
}
.btn-white { background: #fff; color: #ed1f31; }
.btn-white:hover { background: #f8f9fa; color: #c51323; }

.action-item { 
    display: flex; align-items: center; padding: 16px 0; 
    text-decoration: none; border-bottom: 1px solid #f1f3f5; 
    transition: background 0.2s ease;
}
.action-item .icon-box { 
    width: 44px; height: 44px; border-radius: 14px; 
    margin-right: 16px; display: flex; align-items: center; 
    justify-content: center; 
}
.action-item .title { font-weight: 700; color: #2d3436; font-size: 0.95rem; margin-bottom: 2px; }
.action-item .subtitle { font-size: 0.75rem; color: #636e72; }
.action-item:hover .title { color: #ed1f31; }

.bg-soft-primary { background: rgba(13, 110, 253, 0.08); }
.bg-soft-success { background: rgba(25, 135, 84, 0.08); }
.bg-soft-danger { background: rgba(220, 53, 69, 0.08); }
.bg-soft-dark { background: rgba(33, 37, 41, 0.05); color: #212529; }
.btn-soft-dark { background: rgba(33, 37, 41, 0.05); color: #212529; font-weight: 600; border: none; }
.btn-soft-dark:hover { background: rgba(33, 37, 41, 0.1); }

.btn-icon-round { width: 32px; height: 32px; border-radius: 50%; border: 1px solid #eee; display: inline-flex; align-items: center; justify-content: center; color: #636e72; }
.btn-icon-round:hover { background: #f8f9fa; color: #ed1f31; }

.hover-row:hover { background-color: #fafbfc; }
.x-small { font-size: 0.65rem; }
</style>

</body>
</html>
