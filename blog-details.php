<?php
require_once 'user-admin/secure/db_connect.php';
require_once 'user-admin/secure/blog_helpers.php';

$post = null;

// Fetch post by slug or ID
if (isset($_GET['slug'])) {
    $slug = trim($_GET['slug']);
    $stmt = $conn->prepare("SELECT p.*, c.category_name, c.category_slug 
                            FROM posts p 
                            LEFT JOIN category c ON p.category_id = c.category_id 
                            WHERE p.post_slug = ? AND p.post_status = 'published' 
                            LIMIT 1");
    if ($stmt) {
        $stmt->bind_param("s", $slug);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res && $res->num_rows > 0) {
            $post = $res->fetch_assoc();
        }
        $stmt->close();
    }
} elseif (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT p.*, c.category_name, c.category_slug 
                            FROM posts p 
                            LEFT JOIN category c ON p.category_id = c.category_id 
                            WHERE p.post_id = ? AND p.post_status = 'published' 
                            LIMIT 1");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res && $res->num_rows > 0) {
            $post = $res->fetch_assoc();
        }
        $stmt->close();
    }
}

// Fallback if post not found
if (!$post) {
    // Redirect to blog archive
    header("Location: blog");
    exit();
}

// Fetch tags for this specific post
$post_tags = [];
$tag_stmt = $conn->prepare("SELECT t.tag_name, t.tag_slug 
                            FROM tags t 
                            JOIN post_tags pt ON t.tag_id = pt.tag_id 
                            WHERE pt.post_id = ?");
if ($tag_stmt) {
    $tag_stmt->bind_param("i", $post['post_id']);
    $tag_stmt->execute();
    $tag_res = $tag_stmt->get_result();
    while ($row = $tag_res->fetch_assoc()) {
        $post_tags[] = $row;
    }
    $tag_stmt->close();
}

// Dynamic SEO metadata
$page_title = !empty($post['meta_title']) ? $post['meta_title'] : ($post['post_title'] . " | Laika Pet Care & Veterinary Center");
$page_description = !empty($post['meta_description']) ? $post['meta_description'] : mb_strimwidth(strip_tags($post['post_content']), 0, 160, "...");
$page_keywords = !empty($post['meta_keyword']) ? $post['meta_keyword'] : "";

// Fetch Sidebar Data:
// 1. Recent posts
$recent_posts = [];
$recent_res = $conn->query("SELECT * FROM posts WHERE post_status = 'published' ORDER BY created_at DESC LIMIT 3");
if ($recent_res) {
    while ($row = $recent_res->fetch_assoc()) {
        $recent_posts[] = $row;
    }
}

// 2. Categories list with count of posts
$sidebar_categories = [];
$cat_count_sql = "SELECT c.category_name, c.category_slug, COUNT(p.post_id) AS post_count
                  FROM category c
                  LEFT JOIN posts p ON c.category_id = p.category_id AND p.post_status = 'published'
                  GROUP BY c.category_id
                  ORDER BY c.category_name ASC";
$cat_count_res = $conn->query($cat_count_sql);
if ($cat_count_res) {
    while ($row = $cat_count_res->fetch_assoc()) {
        $sidebar_categories[] = $row;
    }
}

// 3. Tags list
$sidebar_tags = [];
$tag_sql = "SELECT DISTINCT t.tag_name, t.tag_slug
            FROM tags t
            JOIN post_tags pt ON t.tag_id = pt.tag_id
            JOIN posts p ON pt.post_id = p.post_id
            WHERE p.post_status = 'published'
            ORDER BY t.tag_name ASC";
$tag_res = $conn->query($tag_sql);
if ($tag_res) {
    while ($row = $tag_res->fetch_assoc()) {
        $sidebar_tags[] = $row;
    }
}

include 'header.php';
?>

<!-- main-area -->
<main class="fix">

    <!-- breadcrumb-area -->
    <section class="breadcrumb__area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-8 col-lg-9">
                    <div class="breadcrumb__content">
                        <h1 class="title text-truncate" style="max-width: 100%;" title="<?php echo htmlspecialchars($post['post_title']); ?>">
                            <?php echo htmlspecialchars($post['post_title']); ?>
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./">Home</a></li>
                                <li class="breadcrumb-separator"><i class="fas fa-angle-right"></i></li>
                                <li class="breadcrumb-item"><a href="blog">Blog</a></li>
                                <li class="breadcrumb-separator"><i class="fas fa-angle-right"></i></li>
                                <li class="breadcrumb-item active" aria-current="page">Blog Details</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="breadcrumb__shape-wrap">
            <img src="assets/img/images/breadcrumb_shape01.png" alt="img">
            <!-- <img src="assets/img/images/breadcrumb_shape02.png" alt="img"> -->
        </div>
    </section>
    <!-- breadcrumb-area-end -->

    <!-- blog-details-area -->
    <section class="blog__post-area-two">
        <div class="container">
            <div class="row justify-content-center">
                
                <!-- Blog Details Content -->
                <div class="col-lg-8">
                    <div class="blog__details-wrap">
                        
                        <!-- Featured Image -->
                        <div class="blog__details-thumb">
                            <img src="<?php echo htmlspecialchars(resolve_blog_image_path($post['image_path'])); ?>" alt="<?php echo htmlspecialchars($post['post_title']); ?>" class="w-100" style="border-radius: 12px;">
                        </div>

                        <!-- Post Meta & Content -->
                        <div class="blog__details-content">
                            
                            <!-- Post Meta -->
                            <div class="blog__post-meta">
                                <ul class="list-wrap">
                                    <li><i class="flaticon-user"></i>by <a href="javascript:void(0)">Admin</a></li>
                                    <li><i class="flaticon-calendar"></i><?php echo date('d M, Y', strtotime($post['created_at'])); ?></li>
                                    <?php if (!empty($post['category_name'])): ?>
                                        <li>
                                            <i class="fas fa-folder"></i>
                                            <a href="blog?category=<?php echo htmlspecialchars($post['category_slug']); ?>">
                                                <?php echo htmlspecialchars($post['category_name']); ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>

                            <!-- Post Content -->
                            <h2 class="title"><?php echo htmlspecialchars($post['post_title']); ?></h2>
                            <div class="post-content-body mt-4">
                                <?php echo $post['post_content']; ?>
                            </div>

                            <!-- Bottom Meta (Tags & Share) -->
                            <div class="blog__details-content-bottom d-flex align-items-center justify-content-between flex-wrap gap-3">
                                
                                <!-- Tags -->
                                <div class="post-tags">
                                    <?php if (!empty($post_tags)): ?>
                                        <h5 class="title">Tags:</h5>
                                        <ul class="list-wrap">
                                            <?php foreach ($post_tags as $tag): ?>
                                                <li>
                                                    <a href="blog?tag=<?php echo htmlspecialchars($tag['tag_slug']); ?>">
                                                        <?php echo htmlspecialchars($tag['tag_name']); ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>

                                <!-- Social Share -->
                                <div class="blog-post-share">
                                    <h5 class="title">Share:</h5>
                                    <ul class="list-wrap">
                                        <?php 
                                        $current_url = urlencode((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
                                        $share_title = urlencode($post['post_title']);
                                        ?>
                                        <li>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $current_url; ?>" target="_blank" title="Share on Facebook">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://twitter.com/intent/tweet?text=<?php echo $share_title; ?>&url=<?php echo $current_url; ?>" target="_blank" title="Share on Twitter">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" style="transform: scale(0.9); margin-top:-3px;">
                                                    <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>
                                                </svg>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $current_url; ?>&title=<?php echo $share_title; ?>" target="_blank" title="Share on LinkedIn">
                                                <i class="fab fa-linkedin-in"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://pinterest.com/pin/create/button/?url=<?php echo $current_url; ?>&description=<?php echo $share_title; ?>" target="_blank" title="Share on Pinterest">
                                                <i class="fab fa-pinterest-p"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

                <!-- Sidebar Container -->
                <div class="col-lg-4">
                    <aside class="blog-sidebar">
                        
                        <!-- Search Widget -->
                        <div class="blog-widget">
                            <h4 class="widget-title">Search</h4>
                            <div class="sidebar-search-form">
                                <form action="blog" method="GET">
                                    <input type="text" name="search" placeholder="Search articles...">
                                    <button type="submit"><i class="fas fa-search"></i></button>
                                </form>
                            </div>
                        </div>

                        <!-- Categories Widget -->
                        <div class="blog-widget">
                            <h4 class="widget-title">Categories</h4>
                            <div class="sidebar-cat-list">
                                <ul class="list-wrap">
                                    <li>
                                        <a href="blog">All Categories</a>
                                    </li>
                                    <?php foreach ($sidebar_categories as $s_cat): ?>
                                        <?php if ($s_cat['post_count'] > 0): ?>
                                            <li>
                                                <a href="blog?category=<?php echo htmlspecialchars($s_cat['category_slug']); ?>">
                                                    <?php echo htmlspecialchars($s_cat['category_name']); ?> <span>(<?php echo $s_cat['post_count']; ?>)</span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>

                        <!-- Recent Posts Widget -->
                        <?php if (!empty($recent_posts)): ?>
                            <div class="blog-widget">
                                <h4 class="widget-title">Recent Posts</h4>
                                <div class="rc-post-list">
                                    <?php foreach ($recent_posts as $r_post): ?>
                                        <div class="rc-post-item">
                                            <div class="thumb">
                                                <a href="blog/<?php echo htmlspecialchars($r_post['post_slug']); ?>">
                                                    <img src="<?php echo htmlspecialchars(resolve_blog_image_path($r_post['image_path'])); ?>" alt="<?php echo htmlspecialchars($r_post['post_title']); ?>" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                                                </a>
                                            </div>
                                            <div class="content">
                                                <h6 class="title">
                                                    <a href="blog/<?php echo htmlspecialchars($r_post['post_slug']); ?>">
                                                        <?php echo htmlspecialchars($r_post['post_title']); ?>
                                                    </a>
                                                </h6>
                                                <span class="date">
                                                    <i class="far fa-calendar-alt"></i>
                                                    <?php echo date('M d, Y', strtotime($r_post['created_at'])); ?>
                                                </span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Tags Widget -->
                        <?php if (!empty($sidebar_tags)): ?>
                            <div class="blog-widget">
                                <h4 class="widget-title">Tags</h4>
                                <div class="sidebar-tag-list">
                                    <ul class="list-wrap">
                                        <?php foreach ($sidebar_tags as $s_tag): ?>
                                            <li>
                                                <a href="blog?tag=<?php echo htmlspecialchars($s_tag['tag_slug']); ?>">
                                                    <?php echo htmlspecialchars($s_tag['tag_name']); ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        <?php endif; ?>

                    </aside>
                </div>

            </div>
        </div>
    </section>
    <!-- blog-details-area-end -->

</main>
<!-- main-area-end -->

<?php include 'footer.php'; ?>
