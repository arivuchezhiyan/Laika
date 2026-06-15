<?php
// Define SEO metadata before header
$page_title = "Latest Pet Care Blogs & Articles | Laika Pet Care & Veterinary Center";
$page_description = "Read our latest articles on dog grooming, cat health care tips, puppy and kitten vaccinations, and emergency pet care advice from veterinary experts.";

require_once 'user-admin/secure/db_connect.php';
require_once 'user-admin/secure/blog_helpers.php';

// Get request parameters
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$cat_slug = isset($_GET['category']) ? trim($_GET['category']) : '';
$tag_slug = isset($_GET['tag']) ? trim($_GET['tag']) : '';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;

$limit = 4; // 4 posts per page to show pagination since we have 5 seeded
$offset = ($page - 1) * $limit;

// Base queries for counting and selecting posts
$where_clauses = ["p.post_status = 'published'"];
$bind_types = "";
$bind_params = [];

if (!empty($search)) {
    $where_clauses[] = "(p.post_title LIKE ? OR p.post_content LIKE ?)";
    $bind_types .= "ss";
    $search_term = "%" . $search . "%";
    $bind_params[] = $search_term;
    $bind_params[] = $search_term;
}

if (!empty($cat_slug)) {
    $where_clauses[] = "c.category_slug = ?";
    $bind_types .= "s";
    $bind_params[] = $cat_slug;
}

if (!empty($tag_slug)) {
    $where_clauses[] = "p.post_id IN (
        SELECT pt.post_id 
        FROM post_tags pt 
        JOIN tags t ON pt.tag_id = t.tag_id 
        WHERE t.tag_slug = ?
    )";
    $bind_types .= "s";
    $bind_params[] = $tag_slug;
}

$where_sql = implode(" AND ", $where_clauses);

// Count total posts for pagination
$count_sql = "SELECT COUNT(*) FROM posts p LEFT JOIN category c ON p.category_id = c.category_id WHERE $where_sql";
$count_stmt = $conn->prepare($count_sql);
if ($count_stmt === false) {
    die("Database prepare error: " . $conn->error);
}

if (!empty($bind_types)) {
    $count_stmt->bind_param($bind_types, ...$bind_params);
}
$count_stmt->execute();
$count_stmt->bind_result($total_posts);
$count_stmt->fetch();
$count_stmt->close();

$total_pages = ceil($total_posts / $limit);
if ($total_pages < 1) $total_pages = 1;
if ($page > $total_pages) $page = $total_pages;

// Fetch posts
$select_sql = "SELECT p.*, c.category_name, c.category_slug 
               FROM posts p 
               LEFT JOIN category c ON p.category_id = c.category_id 
               WHERE $where_sql 
               ORDER BY p.created_at DESC 
               LIMIT ? OFFSET ?";
$select_stmt = $conn->prepare($select_sql);
if ($select_stmt === false) {
    die("Database prepare error: " . $conn->error);
}

// Append limit/offset params to bind array
$stmt_bind_types = $bind_types . "ii";
$stmt_bind_params = array_merge($bind_params, [$limit, $offset]);

$select_stmt->bind_param($stmt_bind_types, ...$stmt_bind_params);
$select_stmt->execute();
$posts_res = $select_stmt->get_result();
$posts = [];
while ($row = $posts_res->fetch_assoc()) {
    $posts[] = $row;
}
$select_stmt->close();

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

// Get filter title for breadcrumbs and SEO override
$active_filter_text = "";
if (!empty($search)) {
    $active_filter_text = "Search: " . htmlspecialchars($search);
    $page_title = "Search results for '" . htmlspecialchars($search) . "' | Laika Pet Care";
} elseif (!empty($cat_slug)) {
    $cat_name_res = $conn->query("SELECT category_name FROM category WHERE category_slug = '" . $conn->real_escape_string($cat_slug) . "' LIMIT 1");
    if ($cat_name_res && $cat_name_res->num_rows > 0) {
        $cat_row = $cat_name_res->fetch_assoc();
        $active_filter_text = "Category: " . $cat_row['category_name'];
        $page_title = $cat_row['category_name'] . " Articles | Laika Pet Care";
        $page_description = "Browse all articles under the " . $cat_row['category_name'] . " category from Laika Pet Care & Veterinary Center.";
    }
} elseif (!empty($tag_slug)) {
    $tag_name_res = $conn->query("SELECT tag_name FROM tags WHERE tag_slug = '" . $conn->real_escape_string($tag_slug) . "' LIMIT 1");
    if ($tag_name_res && $tag_name_res->num_rows > 0) {
        $tag_row = $tag_name_res->fetch_assoc();
        $active_filter_text = "Tag: " . $tag_row['tag_name'];
        $page_title = "Articles tagged with '" . $tag_row['tag_name'] . "' | Laika Pet Care";
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
                <div class="col-xl-6 col-lg-7">
                    <div class="breadcrumb__content">
                        <h1 class="title">
                            <?php echo empty($active_filter_text) ? "Our Blogs" : $active_filter_text; ?>
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./">Home</a></li>
                                <li class="breadcrumb-separator"><i class="fas fa-angle-right"></i></li>
                                <?php if (!empty($active_filter_text)): ?>
                                    <li class="breadcrumb-item"><a href="blog">Blog</a></li>
                                    <li class="breadcrumb-separator"><i class="fas fa-angle-right"></i></li>
                                    <li class="breadcrumb-item active" aria-current="page"><?php echo $active_filter_text; ?></li>
                                <?php else: ?>
                                    <li class="breadcrumb-item active" aria-current="page">Blog</li>
                                <?php endif; ?>
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

    <!-- blog-area -->
    <section class="blog__post-area-two">
        <div class="container">
            <div class="row justify-content-center">
                
                <!-- Blog List Container -->
                <div class="col-lg-8">
                    <?php if (empty($posts)): ?>
                        <div class="alert alert-info py-4 text-center">
                            <i class="fas fa-info-circle fa-2x mb-3 text-primary d-block"></i>
                            <h4 class="fw-bold">No posts found</h4>
                            <p class="text-muted mb-0">We couldn't find any blog posts matching your search criteria.</p>
                            <a href="blog" class="btn btn-primary mt-3">Reset Filters</a>
                        </div>
                    <?php else: ?>
                        <div class="row justify-content-center">
                            <?php foreach ($posts as $post): ?>
                                <div class="col-md-6 col-sm-10">
                                    <div class="blog__post-item shine-animate-item">
                                        <div class="blog__post-thumb">
                                            <div class="blog__post-mask shine-animate">
                                                <a href="blog/<?php echo htmlspecialchars($post['post_slug']); ?>">
                                                    <img loading="lazy" src="<?php echo htmlspecialchars(resolve_blog_image_path($post['image_path'])); ?>" alt="<?php echo htmlspecialchars($post['post_title']); ?>">
                                                </a>
                                                <?php if (!empty($post['category_name'])): ?>
                                                    <ul class="list-wrap blog__post-tag">
                                                        <li>
                                                            <a href="blog?category=<?php echo htmlspecialchars($post['category_slug']); ?>">
                                                                <?php echo htmlspecialchars($post['category_name']); ?>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                <?php endif; ?>
                                            </div>
                                            <div class="shape">
                                                <img loading="lazy" src="assets/img/blog/blog_img_shape.svg" alt="" class="injectable">
                                            </div>
                                        </div>
                                        <div class="blog__post-content">
                                            <div class="blog__post-meta">
                                                <ul class="list-wrap">
                                                    <li><i class="flaticon-user"></i>by <a href="blog/<?php echo htmlspecialchars($post['post_slug']); ?>">Admin</a></li>
                                                    <li><i class="flaticon-calendar"></i><?php echo date('d M, Y', strtotime($post['created_at'])); ?></li>
                                                </ul>
                                            </div>
                                            <h2 class="title">
                                                <a href="blog/<?php echo htmlspecialchars($post['post_slug']); ?>">
                                                    <?php echo htmlspecialchars($post['post_title']); ?>
                                                </a>
                                            </h2>
                                            <p class="text-muted small mt-2">
                                                <?php 
                                                $text = strip_tags($post['post_content']);
                                                echo mb_strimwidth($text, 0, 110, "...");
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Pagination -->
                        <?php if ($total_pages > 1): ?>
                            <div class="pagination__wrap mt-30">
                                <nav>
                                    <ul class="list-wrap d-flex justify-content-center align-items-center">
                                        <?php if ($page > 1): ?>
                                            <li>
                                                <a href="blog?<?php echo http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>">
                                                    <i class="fas fa-angle-double-left"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                            <li class="<?php echo ($i === $page) ? 'active' : ''; ?>">
                                                <a href="blog?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>">
                                                    <?php echo $i; ?>
                                                </a>
                                            </li>
                                        <?php endfor; ?>

                                        <?php if ($page < $total_pages): ?>
                                            <li>
                                                <a href="blog?<?php echo http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>">
                                                    <i class="fas fa-angle-double-right"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <!-- Sidebar Container -->
                <div class="col-lg-4">
                    <aside class="blog-sidebar">
                        
                        <!-- Search Widget -->
                        <div class="blog-widget">
                            <h4 class="widget-title">Search</h4>
                            <div class="sidebar-search-form">
                                <form action="blog" method="GET">
                                    <input type="text" name="search" placeholder="Search articles..." value="<?php echo htmlspecialchars($search); ?>">
                                    <?php if (!empty($cat_slug)): ?>
                                        <input type="hidden" name="category" value="<?php echo htmlspecialchars($cat_slug); ?>">
                                    <?php endif; ?>
                                    <?php if (!empty($tag_slug)): ?>
                                        <input type="hidden" name="tag" value="<?php echo htmlspecialchars($tag_slug); ?>">
                                    <?php endif; ?>
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
                                        <?php if ($s_cat['post_count'] > 0 || $s_cat['category_slug'] === $cat_slug): ?>
                                            <li>
                                                <a href="blog?category=<?php echo htmlspecialchars($s_cat['category_slug']); ?>" class="<?php echo ($cat_slug === $s_cat['category_slug']) ? 'fw-bold text-primary' : ''; ?>">
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
                                                <a href="blog?tag=<?php echo htmlspecialchars($s_tag['tag_slug']); ?>" class="<?php echo ($tag_slug === $s_tag['tag_slug']) ? 'active' : ''; ?>">
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
    <!-- blog-area-end -->

</main>
<!-- main-area-end -->

<?php include 'footer.php'; ?>
