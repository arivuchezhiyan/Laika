<?php
// Define SEO metadata before header
$page_title = "Our Gallery | Laika Pet Care & Veterinary Center";
$page_description = "Browse through images and videos showing our facilities, pet treatments, spa services, and happy animals at Laika Pet Care.";

include 'header.php';

// Prepare gallery items
$gallery_items = [];

// Video item (vid-1.mp4)
$gallery_items[] = [
    'type' => 'video',
    'src' => 'assets/img/gallery/vid-1.mp4',
    'title' => 'Laika Pet Care Clinic Video Tour',
    'thumb' => 'assets/img/gallery/img-1.jpeg', // Use img-1 as the thumbnail for the video
    'classes' => 'video',
];

// Add the 23 images (excluding visual duplicates img-10 and img-19)
for ($i = 1; $i <= 23; $i++) {
    if ($i === 10 || $i === 19) {
        continue;
    }
    $gallery_items[] = [
        'type' => 'image',
        'src' => "assets/img/gallery/img-$i.jpeg",
        'title' => "Laika Gallery Image $i",
        'thumb' => "assets/img/gallery/img-$i.jpeg",
        'classes' => 'image',
    ];
}

// Add the 29 infrastructure images
for ($i = 1; $i <= 29; $i++) {
    $gallery_items[] = [
        'type' => 'image',
        'src' => "assets/img/shop/img_$i.jpeg",
        'title' => "Laika Infrastructure Image $i",
        'thumb' => "assets/img/shop/img_$i.jpeg",
        'classes' => 'image infrastructure',
    ];
}
?>

<!-- main-area -->
<main class="fix">
    <style>
    .breadcrumb__area {
        background-image: url('assets/img/banner/pet banner 2.png') !important;
    }
    @media (min-width: 768px) {
        .breadcrumb__area {
            background-image: url('assets/img/banner/pet banner 2.png') !important;
        }
    }
    </style>

    <!-- breadcrumb-area -->
    <section class="breadcrumb__area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-7">
                    <div class="breadcrumb__content">
                        <h1 class="title">Gallery</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./">Home</a></li>
                                <li class="breadcrumb-separator"><i class="fas fa-angle-right"></i></li>
                                <li class="breadcrumb-item active" aria-current="page">Gallery</li>
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

    <!-- gallery-area -->
    <section class="gallery__area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="section__title text-center mb-40">
                        <span class="sub-title">Laika Moments
                            <strong class="shake">
                                <img src="assets/img/icon/pet_icon02.svg" alt="" class="injectable">
                            </strong>
                        </span>
                        <h2 class="title">Our Gallery</h2>
                    </div>
                    <div class="gallery__filter-wrap text-center mb-50">
                        <button class="gallery__filter-btn active" data-filter="all">All</button>
                        <button class="gallery__filter-btn" data-filter="image">Images</button>
                        <button class="gallery__filter-btn" data-filter="video">Videos</button>
                        <button class="gallery__filter-btn" data-filter="infrastructure">Infrastructure</button>
                    </div>
                </div>
            </div>
            
            <div class="row justify-content-center gallery-active">
                <?php foreach ($gallery_items as $item): ?>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-10 gallery-item <?php echo $item['classes']; ?>">
                    <div class="gallery__item">
                        <div class="gallery__img">
                            <img src="<?php echo htmlspecialchars($item['thumb']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" class="w-100">
                        </div>
                        <?php if ($item['type'] === 'video'): ?>
                            <a href="<?php echo htmlspecialchars($item['src']); ?>" class="popup-video" title="<?php echo htmlspecialchars($item['title']); ?>"><i class="fas fa-play"></i></a>
                        <?php else: ?>
                            <a href="<?php echo htmlspecialchars($item['src']); ?>" class="popup-image" title="<?php echo htmlspecialchars($item['title']); ?>"><i class="fas fa-eye"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!-- gallery-area-end -->

</main>
<!-- main-area-end -->

<?php include 'footer.php'; ?>

<!-- Gallery Filter Logic -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.gallery__filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            filterBtns.forEach(b => b.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');

            const filterValue = this.getAttribute('data-filter');

            galleryItems.forEach(item => {
                if (filterValue === 'all') {
                    item.style.display = 'block';
                    item.style.opacity = '0';
                    setTimeout(() => {
                        item.style.transition = 'opacity 0.4s ease-out';
                        item.style.opacity = '1';
                    }, 50);
                } else if (item.classList.contains(filterValue)) {
                    item.style.display = 'block';
                    item.style.opacity = '0';
                    setTimeout(() => {
                        item.style.transition = 'opacity 0.4s ease-out';
                        item.style.opacity = '1';
                    }, 50);
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
});
</script>
