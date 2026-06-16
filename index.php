<?php
// Fetch latest blog posts dynamically from the database
$home_posts = [];
$db_connected = false;
if (file_exists('user-admin/secure/db_connect.php')) {
    // Suppress warnings in case db_connect.php prints output or fails
    ob_start();
    include_once 'user-admin/secure/db_connect.php';
    include_once 'user-admin/secure/blog_helpers.php';
    ob_end_clean();
    
    if (isset($conn) && !$conn->connect_error && !isset($db_connection_error)) {
        $db_connected = true;
        $posts_res = $conn->query("SELECT p.*, c.category_name, c.category_slug 
                                   FROM posts p 
                                   LEFT JOIN category c ON p.category_id = c.category_id 
                                   WHERE p.post_status = 'published' 
                                   ORDER BY p.created_at DESC 
                                   LIMIT 3");
        if ($posts_res) {
            while ($row = $posts_res->fetch_assoc()) {
                $home_posts[] = $row;
            }
        }
    }
}
include 'header.php'; 
?>

    <!-- main-area -->
    <main class="fix">

        <!-- banner-area -->
        <!-- <section class="banner__area banner__bg" data-background="assets/img/banner/banner_bg.jpg"> -->
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-xl-5 col-lg-6">
                        <div class="banner__content">
                            <h1 class="title" data-aos="fade-up" data-aos-delay="200">Trusted Pet <img src="assets/img/banner/banner_title_img01.png" alt=""> care & Veterinary Service <span class="icon"><img src="assets/img/banner/banner_title_img02.png" alt=""></span> Point</h1>
                            <p data-aos="fade-up" data-aos-delay="400">Providing expert veterinary care and loving support for your pets, every day.
</p>
                            <a href="about" class="btn" data-aos="fade-up" data-aos-delay="600">Read More <img src="assets/img/icon/right_arrow.svg" alt="" class="injectable"></a>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-6 col-md-9">
                        <div class="banner__img text-end">
                            <img src="assets/img/banner/banner_img01.png" alt="img" data-aos="fade-left" data-aos-delay="800" style="width: 75%;">
                            <div class="healthy-pets" data-aos="zoom-in" data-aos-delay="1000">
                                <div class="icon">
                                    <img src="assets/img/icon/pet_icon01.svg" alt="" class="injectable">
                                </div>
                                <div class="content">
                                    <h6 class="circle rotateme">BETTER - HEALTHY - PETS - LOVE -</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="banner__shape-wrap">
                <img src="assets/img/banner/banner_shape01.png" alt="img" data-aos="fade-down" data-aos-delay="1200">
                <img src="assets/img/banner/banner_shape02.png" alt="img" data-aos="fade-up-right" data-aos-delay="1200">
                <img src="assets/img/banner/banner_shape03.png" alt="img" class="ribbonRotate">
                <img src="assets/img/banner/banner_shape04.png" alt="img">
            </div>
        </section>
        <!-- banner-area-end -->

        <!-- about-area -->
        <section class="about__area">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8">
                        <div class="about__img" data-aos="fade-right" data-aos-delay="200">
                            <img loading="lazy" src="assets/img/images/home_1.jpeg" alt="" style="border-radius: 10% !important;">
                            <!-- <div class="video__box">
                                <div class="video__box-shape">
                                    <img loading="lazy" src="assets/img/images/about_video_shape.svg" alt="" class="injectable">
                                </div>
                                <h5 class="title">Watch Our <br> Working Video</h5>
                                <a href="https://www.youtube.com/watch?v=XdFfCPK5ycw" class="popup-video play-btn"><i class="fas fa-play"></i></a>
                            </div> -->
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-6">
                        <div class="about__content" data-aos="fade-left" data-aos-delay="300">
                            <div class="section__title mb-20">
                                <span class="sub-title">Learn About Us
                                    <strong class="shake">
                                        <img loading="lazy" src="assets/img/icon/pet_icon02.svg" alt="" class="injectable">
                                    </strong>
                                </span>
                                <h2 class="title">Our Passion Is Caring for <br> Your Pets’ Health</h2>
                            </div>
                            <div class="about__content-inner">
                                <div class="experience__box">
                                    <div class="experience__box-shape">
                                        <img loading="lazy" src="assets/img/images/experience_shape.svg" alt="" class="injectable">
                                    </div>
                                    <div class="experience__box-content">
                                        <h4 class="title">25+ <span>Yrs</span></h4>
                                        <p>Experience</p>
                                    </div>
                                </div>
                                <p>We provide compassionate, expert veterinary care for pets at every life stage.</p>
                            </div>
                            <p>Our experienced veterinarians in Katpadi create personalized care plans, including preventive health, vaccinations, diagnostics and emergency support, ensuring your pets stay happy and healthy.</p>
                            <!-- <div class="about__content-bottom">
                                <div class="about__content-sign">
                                    <img loading="lazy" src="assets/img/images/author_sign.png" alt="">
                                </div>
                                <div class="customer__review">
                                    <div class="customer__review-img">
                                        <ul class="list-wrap">
                                            <li><img loading="lazy" src="assets/img/images/author_01.png" alt=""></li>
                                            <li><img loading="lazy" src="assets/img/images/author_02.png" alt=""></li>
                                            <li><img loading="lazy" src="assets/img/images/author_03.png" alt=""></li>
                                            <li><img loading="lazy" src="assets/img/images/author_04.png" alt=""></li>
                                        </ul>
                                    </div>
                                    <div class="customer__review-content">
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <span>4.7 (1,567 Reviews)</span>
                                    </div>
                                </div>
                            </div> -->
                            <div class="shape">
                                <img loading="lazy" src="assets/img/images/about_shape02.png" alt="img" data-aos="fade-down-left" data-aos-delay="400">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="about__shape-wrap">
                <img loading="lazy" src="assets/img/images/about_shape01.png" alt="img" data-aos="fade-up-right" data-aos-delay="800">
                <img loading="lazy" src="assets/img/images/about_shape03.png" alt="img" class="ribbonRotate">
            </div>
        </section>
        <!-- about-area-end -->

        <!-- marquee-area -->
        <div class="marquee__area">
            <div class="marquee__wrap">
                <div class="marquee__box">
                    <a href="#">Pet Care Service <img loading="lazy" src="assets/img/images/marquee_icon.svg" alt=""></a>
                    <a href="#">Vaccination & Treatment <img loading="lazy" src="assets/img/images/marquee_icon.svg" alt=""></a>
                    <a href="#">Surgical Center <img loading="lazy" src="assets/img/images/marquee_icon.svg" alt=""></a>
                    <a href="#">Diagnostic Laboratory <img loading="lazy" src="assets/img/images/marquee_icon.svg" alt=""></a>
                    <a href="#">X-ray & Ultra Scan <img loading="lazy" src="assets/img/images/marquee_icon.svg" alt=""></a>
                    <a href="#">Pet Spa (Grooming) <img loading="lazy" src="assets/img/images/marquee_icon.svg" alt=""></a>
                    <a href="#">Pet Shop <img loading="lazy" src="assets/img/images/marquee_icon.svg" alt=""></a>
                    <a href="#">Pet Dentistry (Dental Scaling) <img loading="lazy" src="assets/img/images/marquee_icon.svg" alt=""></a>
                    <a href="#">Pet Inpatients <img loading="lazy" src="assets/img/images/marquee_icon.svg" alt=""></a>
                    <a href="#">Pet Day Care <img loading="lazy" src="assets/img/images/marquee_icon.svg" alt=""></a>
                </div>
                <div class="marquee__box">
                    <a href="#">Pet Care Service <img loading="lazy" src="assets/img/images/marquee_icon.svg" alt=""></a>
                    <a href="#">Vaccination & Treatment <img loading="lazy" src="assets/img/images/marquee_icon.svg" alt=""></a>
                    <a href="#">Surgical Center <img loading="lazy" src="assets/img/images/marquee_icon.svg" alt=""></a>
                    <a href="#">Diagnostic Laboratory <img loading="lazy" src="assets/img/images/marquee_icon.svg" alt=""></a>
                    <a href="#">X-ray & Ultra Scan <img loading="lazy" src="assets/img/images/marquee_icon.svg" alt=""></a>
                    <a href="#">Pet Spa (Grooming) <img loading="lazy" src="assets/img/images/marquee_icon.svg" alt=""></a>
                    <a href="#">Pet Shop <img loading="lazy" src="assets/img/images/marquee_icon.svg" alt=""></a>
                    <a href="#">Pet Dentistry (Dental Scaling) <img loading="lazy" src="assets/img/images/marquee_icon.svg" alt=""></a>
                    <a href="#">Pet Inpatients <img loading="lazy" src="assets/img/images/marquee_icon.svg" alt=""></a>
                    <a href="#">Pet Day Care <img loading="lazy" src="assets/img/images/marquee_icon.svg" alt=""></a>
                </div>
            </div>
        </div>
        <!-- marquee-area-end -->

        <!-- services-area -->
        <section class="services__area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-lg-7">
                        <div class="section__title mb-40" data-aos="fade-up" data-aos-delay="200">
                            <span class="sub-title">Complete Pet Wellness Care
                                <strong class="shake">
                                    <img loading="lazy" src="assets/img/icon/pet_icon02.svg" alt="" class="injectable">
                                </strong>
                            </span>
                            <h2 class="title">Expert care and personalized support for every pet</h2>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-5">
                        <div class="view__all-btn text-end mb-40" data-aos="fade-up" data-aos-delay="300">
                            <a href="service" class="btn border-btn">See All Services <img loading="lazy" src="assets/img/icon/right_arrow.svg" alt="" class="injectable"></a>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8" data-aos="fade-up" data-aos-delay="200">
                        <div class="services__item">
                            <div class="services__shape">
                                <div class="shape-one">
                                    <img loading="lazy" src="assets/img/images/services_shape01.svg" alt="" class="injectable">
                                </div>
                                <div class="shape-two">
                                    <img loading="lazy" src="assets/img/images/services_shape02.svg" alt="" class="injectable">
                                </div>
                            </div>
                            <div class="services__icon">
                                <i class="flaticon-vet"></i>
                                <div class="services__icon-shape">
                                    <img loading="lazy" src="assets/img/images/services_icon_shape.svg" alt="" class="injectable">
                                </div>
                            </div>
                            <div class="services__content">
                                <h4 class="title"><a href="service#pet-care">Pet Care Service</a></h4>
                                <p>Routine checkups and preventive care to keep your pets healthy and happy.</p>
                                <a href="service#pet-care" class="btn border-btn">See Details <img loading="lazy" src="assets/img/icon/right_arrow02.svg" alt="" class="injectable"></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8" data-aos="fade-up" data-aos-delay="300">
                        <div class="services__item">
                            <div class="services__shape">
                                <div class="shape-one">
                                    <img loading="lazy" src="assets/img/images/services_shape01.svg" alt="" class="injectable">
                                </div>
                                <div class="shape-two">
                                    <img loading="lazy" src="assets/img/images/services_shape02.svg" alt="" class="injectable">
                                </div>
                            </div>
                            <div class="services__icon">
                                <i class="flaticon-vaccine"></i>
                                <div class="services__icon-shape">
                                    <img loading="lazy" src="assets/img/images/services_icon_shape.svg" alt="" class="injectable">
                                </div>
                            </div>
                            <div class="services__content">
                                <h4 class="title"><a href="service#vaccination">Vaccination & Treatment</a></h4>
                                <p>Timely vaccines and treatments to protect pets from common illnesses.</p>
                                <a href="service#vaccination" class="btn border-btn">See Details <img loading="lazy" src="assets/img/icon/right_arrow02.svg" alt="" class="injectable"></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8" data-aos="fade-up" data-aos-delay="400">
                        <div class="services__item">
                            <div class="services__shape">
                                <div class="shape-one">
                                    <img loading="lazy" src="assets/img/images/services_shape01.svg" alt="" class="injectable">
                                </div>
                                <div class="shape-two">
                                    <img loading="lazy" src="assets/img/images/services_shape02.svg" alt="" class="injectable">
                                </div>
                            </div>
                            <div class="services__icon">
                                <i class="flaticon-spay"></i>
                                <div class="services__icon-shape">
                                    <img loading="lazy" src="assets/img/images/services_icon_shape.svg" alt="" class="injectable">
                                </div>
                            </div>
                            <div class="services__content">
                                <h4 class="title"><a href="service#surgical">Surgical Center</a></h4>
                                <p>Safe, modern procedures for pets with precision and care.</p>
                                <a href="service#surgical" class="btn border-btn">See Details <img loading="lazy" src="assets/img/icon/right_arrow02.svg" alt="" class="injectable"></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8" data-aos="fade-up" data-aos-delay="500">
                        <div class="services__item">
                            <div class="services__shape">
                                <div class="shape-one">
                                    <img loading="lazy" src="assets/img/images/services_shape01.svg" alt="" class="injectable">
                                </div>
                                <div class="shape-two">
                                    <img loading="lazy" src="assets/img/images/services_shape02.svg" alt="" class="injectable">
                                </div>
                            </div>
                            <div class="services__icon">
                                <i class="flaticon-loupe"></i>
                                <div class="services__icon-shape">
                                    <img loading="lazy" src="assets/img/images/services_icon_shape.svg" alt="" class="injectable">
                                </div>
                            </div>
                            <div class="services__content">
                                <h4 class="title"><a href="service#diagnostic">Diagnostic laboratory</a></h4>
                                <p>Accurate lab tests and imaging for early health issue detection.</p>
                                <a href="service#diagnostic" class="btn border-btn">See Details <img loading="lazy" src="assets/img/icon/right_arrow02.svg" alt="" class="injectable"></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8" data-aos="fade-up" data-aos-delay="200">
                        <div class="services__item">
                            <div class="services__shape">
                                <div class="shape-one">
                                    <img loading="lazy" src="assets/img/images/services_shape01.svg" alt="" class="injectable">
                                </div>
                                <div class="shape-two">
                                    <img loading="lazy" src="assets/img/images/services_shape02.svg" alt="" class="injectable">
                                </div>
                            </div>
                            <div class="services__icon">
                                <i class="flaticon-paw"></i>
                                <div class="services__icon-shape">
                                    <img loading="lazy" src="assets/img/images/services_icon_shape.svg" alt="" class="injectable">
                                </div>
                            </div>
                            <div class="services__content">
                                <h4 class="title"><a href="service#xray">X-ray & Ultra Scan</a></h4>
                                <p>Advanced imaging to assess and monitor your pet’s health.</p>
                                <a href="service#xray" class="btn border-btn">See Details <img loading="lazy" src="assets/img/icon/right_arrow02.svg" alt="" class="injectable"></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8" data-aos="fade-up" data-aos-delay="300">
                        <div class="services__item">
                            <div class="services__shape">
                                <div class="shape-one">
                                    <img loading="lazy" src="assets/img/images/services_shape01.svg" alt="" class="injectable">
                                </div>
                                <div class="shape-two">
                                    <img loading="lazy" src="assets/img/images/services_shape02.svg" alt="" class="injectable">
                                </div>
                            </div>
                            <div class="services__icon">
                                <i class="flaticon-beauty-saloon"></i>
                                <div class="services__icon-shape">
                                    <img loading="lazy" src="assets/img/images/services_icon_shape.svg" alt="" class="injectable">
                                </div>
                            </div>
                            <div class="services__content">
                                <h4 class="title"><a href="service#spa">Pet Spa(Grooming)</a></h4>
                                <p>Professional pet spa services for hygiene and comfort.</p>
                                <a href="service#spa" class="btn border-btn">See Details <img loading="lazy" src="assets/img/icon/right_arrow02.svg" alt="" class="injectable"></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8" data-aos="fade-up" data-aos-delay="400">
                        <div class="services__item">
                            <div class="services__shape">
                                <div class="shape-one">
                                    <img loading="lazy" src="assets/img/images/services_shape01.svg" alt="" class="injectable">
                                </div>
                                <div class="shape-two">
                                    <img loading="lazy" src="assets/img/images/services_shape02.svg" alt="" class="injectable">
                                </div>
                            </div>
                            <div class="services__icon">
                                <i class="flaticon-shopping-bag"></i>
                                <div class="services__icon-shape">
                                    <img loading="lazy" src="assets/img/images/services_icon_shape.svg" alt="" class="injectable">
                                </div>
                            </div>
                            <div class="services__content">
                                <h4 class="title"><a href="service#shop">Pet Shop</a></h4>
                                <p>High-quality food, toys and essential products for daily care.</p>
                                <a href="service#shop" class="btn border-btn">See Details <img loading="lazy" src="assets/img/icon/right_arrow02.svg" alt="" class="injectable"></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8" data-aos="fade-up" data-aos-delay="500">
                        <div class="services__item">
                            <div class="services__shape">
                                <div class="shape-one">
                                    <img loading="lazy" src="assets/img/images/services_shape01.svg" alt="" class="injectable">
                                </div>
                                <div class="shape-two">
                                    <img loading="lazy" src="assets/img/images/services_shape02.svg" alt="" class="injectable">
                                </div>
                            </div>
                            <div class="services__icon">
                                <i class="flaticon-vet"></i>
                                <div class="services__icon-shape">
                                    <img loading="lazy" src="assets/img/images/services_icon_shape.svg" alt="" class="injectable">
                                </div>
                            </div>
                            <div class="services__content">
                                <h4 class="title"><a href="service#dentistry">Pet Dentistry (Dental Scaling)</a></h4>
                                <p>Professional dental cleaning and scaling to keep your pet's teeth healthy.</p>
                                <a href="service#dentistry" class="btn border-btn">See Details <img loading="lazy" src="assets/img/icon/right_arrow02.svg" alt="" class="injectable"></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8" data-aos="fade-up" data-aos-delay="200">
                        <div class="services__item">
                            <div class="services__shape">
                                <div class="shape-one">
                                    <img loading="lazy" src="assets/img/images/services_shape01.svg" alt="" class="injectable">
                                </div>
                                <div class="shape-two">
                                    <img loading="lazy" src="assets/img/images/services_shape02.svg" alt="" class="injectable">
                                </div>
                            </div>
                            <div class="services__icon">
                                <i class="flaticon-animals"></i>
                                <div class="services__icon-shape">
                                    <img loading="lazy" src="assets/img/images/services_icon_shape.svg" alt="" class="injectable">
                                </div>
                            </div>
                            <div class="services__content">
                                <h4 class="title"><a href="service#inpatients">Pet Inpatients</a></h4>
                                <p>24/7 supportive hospitalization and dedicated nursing care for recovering pets.</p>
                                <a href="service#inpatients" class="btn border-btn">See Details <img loading="lazy" src="assets/img/icon/right_arrow02.svg" alt="" class="injectable"></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8" data-aos="fade-up" data-aos-delay="300">
                        <div class="services__item">
                            <div class="services__shape">
                                <div class="shape-one">
                                    <img loading="lazy" src="assets/img/images/services_shape01.svg" alt="" class="injectable">
                                </div>
                                <div class="shape-two">
                                    <img loading="lazy" src="assets/img/images/services_shape02.svg" alt="" class="injectable">
                                </div>
                            </div>
                            <div class="services__icon">
                                <i class="flaticon-dog"></i>
                                <div class="services__icon-shape">
                                    <img loading="lazy" src="assets/img/images/services_icon_shape.svg" alt="" class="injectable">
                                </div>
                            </div>
                            <div class="services__content">
                                <h4 class="title"><a href="service#daycare">Pet Day Care</a></h4>
                                <p>Safe, fun, and attentive daytime supervision and activities for your pets.</p>
                                <a href="service#daycare" class="btn border-btn">See Details <img loading="lazy" src="assets/img/icon/right_arrow02.svg" alt="" class="injectable"></a>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="services__shape-wrap">
                <img loading="lazy" src="assets/img/images/services_shape01.png" alt="img" class="ribbonRotate">
                <img loading="lazy" src="assets/img/images/services_shape02.png" alt="img" data-aos="fade-up-right" data-aos-delay="800">
                <img loading="lazy" src="assets/img/images/services_shape03.png" alt="img" data-aos="fade-down-left" data-aos-delay="400">
            </div>
        </section>
        <!-- services-area-end -->

        <!-- why-we-are-area -->
        <section class="why__we-are-area">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6 col-md-8 col-sm-10">
                        <div class="why__we-are-img" data-aos="fade-right" data-aos-delay="200">
                            <img loading="lazy" src="assets/img/images/why_we_are_img.png" alt="">
                            <div class="shape shape-one" data-aos="fade-down-right" data-aos-delay="500">
                                <img loading="lazy" src="assets/img/images/why_shape01.svg" alt="" class="injectable">
                            </div>
                            <div class="shape shape-two" data-aos="fade-up-right" data-aos-delay="500">
                                <img loading="lazy" src="assets/img/images/why_shape02.svg" alt="" class="injectable">
                            </div>
                            <div class="shape shape-three" data-aos="fade-up-left" data-aos-delay="500">
                                <img loading="lazy" src="assets/img/images/why_shape03.svg" alt="" class="injectable">
                            </div>
                            <div class="shape shape-four ribbonRotate">
                                <img loading="lazy" src="assets/img/images/why_shape04.svg" alt="" class="injectable">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="why__we-are-content" data-aos="fade-left" data-aos-delay="300">
                            <div class="section__title mb-10">
                                <span class="sub-title">Why We are The Best
                                    <strong class="shake">
                                        <img loading="lazy" src="assets/img/icon/pet_icon02.svg" alt="" class="injectable">
                                    </strong>
                                </span>
                                <h2 class="title">Pet Emergencies <br> Made Simple</h2>
                            </div>
                            <p>We understand that your pet is a cherished family member. Our team provides timely, compassionate care to handle emergencies and ensure your furry friends stay safe and healthy.</p>
                            <div class="why__list-box">
                                <ul class="list-wrap">
                                    <li>
                                        <div class="why__list-box-item">
                                            <div class="why__list-box-item-top">
                                                <div class="icon">
                                                    <img loading="lazy" src="assets/img/icon/check_icon.svg" alt="" class="injectable">
                                                </div>
                                                <h4 class="title">Vet Experts</h4>
                                            </div>
                                            <p>Skilled care for all pet emergencies.</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="why__list-box-item">
                                            <div class="why__list-box-item-top">
                                                <div class="icon">
                                                    <img loading="lazy" src="assets/img/icon/check_icon.svg" alt="" class="injectable">
                                                </div>
                                                <h4 class="title">Affordable Care</h4>
                                            </div>
                                            <p>Quality treatment with transparent pricing.</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="why__list-box-item">
                                            <div class="why__list-box-item-top">
                                                <div class="icon">
                                                    <img loading="lazy" src="assets/img/icon/check_icon.svg" alt="" class="injectable">
                                                </div>
                                                <h4 class="title">Pet Training Tips</h4>
                                            </div>
                                            <p>Guidance to keep pets happy & well-behaved.</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="why__list-box-item">
                                            <div class="why__list-box-item-top">
                                                <div class="icon">
                                                    <img loading="lazy" src="assets/img/icon/check_icon.svg" alt="" class="injectable">
                                                </div>
                                                <h4 class="title">Daily Health Support</h4>
                                            </div>
                                            <p>Routines and tips for ongoing wellness.</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- why-we-are-area-end -->

        <!-- counter-area -->
        <section class="counter__area">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-5 col-md-8 order-0 order-lg-2">
                        <div class="counter__img" data-aos="fade-up" data-aos-delay="200">
                            <div class="mask-img-wrap">
                                <img loading="lazy" src="assets/img/images/counter_img.png" alt="img">
                            </div>
                            <div class="counter__img-shape">
                                <img loading="lazy" src="assets/img/images/counter_img_shape.svg" alt="" class="injectable">
                            </div>
                            <div class="shape">
                                <img loading="lazy" src="assets/img/images/counter_shape01.png" alt="img" class="ribbonRotate">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-7">
                        <div class="counter__content" data-aos="fade-right" data-aos-delay="300">
                            <div class="section__title white-title mb-10">
                                <span class="sub-title" style="color: #000000 !important;">Your Trust Our Priority
                                    <strong class="shake">
                                        <img loading="lazy" src="assets/img/icon/pet_icon02.svg" alt="" class="injectable" style="margin-left: 10px !important;">
                                    </strong>
                                </span>
                                <h2 class="title">Dedicated, professional pet care with guaranteed quality and attention.</h2>
                            </div>
                            <p>We understand that your furry friend is a treasured member of your family and deserves the best care possible.</p>
                            <a href="about" class="btn border-btn white-btn">Read More <img loading="lazy" src="assets/img/icon/right_arrow.svg" alt="" class="injectable"></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-5 order-3">
                        <div class="counter__item-wrap" data-aos="fade-left" data-aos-delay="400">
                            <div class="counter__item">
                                <h2 class="count"><span class="odometer" data-count="25"></span>+</h2>
                                <p>years of experience</p>
                            </div>
                            <div class="counter__item">
                                <h2 class="count"><span class="odometer" data-count="23"></span>K</h2>
                                <p>Our Beloved Clients</p>
                            </div>
                            <div class="counter__item">
                                <h2 class="count"><span class="odometer" data-count="15"></span>K+</h2>
                                <p>Real Customer Reviews</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="counter__shape">
                <img loading="lazy" src="assets/img/images/counter_shape02.png" alt="img" data-aos="fade-up-left" data-aos-delay="400">
            </div>
        </section>
        <!-- counter-area-end -->

       

        <!-- team-area -->
        <section class="team__area">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="section__title text-center mb-40" data-aos="fade-up" data-aos-delay="200">
                            <span class="sub-title">WE CHANGE YOUR LIFE & WORLD
                                <strong class="shake">
                                    <img loading="lazy" src="assets/img/icon/pet_icon02.svg" alt="" class="injectable">
                                </strong>
                            </span>
                            <h2 class="title">Meet Our Expertise <br> Pet Doctors</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mobile-carousel">
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8 mobile-carousel-item" data-aos="fade-up" data-aos-delay="300">
                        <div class="team__item">
                            <div class="team__item-img">
                                <div class="mask-img-wrap">
                                    <img loading="lazy" src="assets/img/team/team_img01.png" alt="img">
                                </div>
                                <div class="team__item-img-shape">  
                                    <div class="shape-one">
                                        <img loading="lazy" src="assets/img/team/team_img_shape01.svg" alt="" class="injectable">
                                    </div>
                                    <div class="shape-two">
                                        <img loading="lazy" src="assets/img/team/team_img_shape02.svg" alt="" class="injectable">
                                    </div>
                                </div>
                            </div>
                            <div class="team__item-content">
                                <h4 class="title"><a href="about#team">Dr. SenthilKumar</a></h4>
                                <span>Senior Veterinary Surgeon</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8 mobile-carousel-item" data-aos="fade-up" data-aos-delay="400">
                        <div class="team__item">
                            <div class="team__item-img">
                                <div class="mask-img-wrap">
                                    <img loading="lazy" src="assets/img/team/doctor_2.png" alt="img">
                                </div>
                                <div class="team__item-img-shape">  
                                    <div class="shape-one">
                                        <img loading="lazy" src="assets/img/team/team_img_shape01.svg" alt="" class="injectable">
                                    </div>
                                    <div class="shape-two">
                                        <img loading="lazy" src="assets/img/team/team_img_shape02.svg" alt="" class="injectable">
                                    </div>
                                </div>
                            </div>
                            <div class="team__item-content">
                                <h4 class="title"><a href="about#team">Dr. C. Christen</a></h4>
                                <span>M.V.Sc in Veterinary Medicine</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8 mobile-carousel-item" data-aos="fade-up" data-aos-delay="500">
                        <div class="team__item">
                            <div class="team__item-img">
                                <div class="mask-img-wrap">
                                    <img loading="lazy" src="assets/img/team/doctor_3.png" alt="img">
                                </div>
                                <div class="team__item-img-shape">  
                                    <div class="shape-one">
                                        <img loading="lazy" src="assets/img/team/team_img_shape01.svg" alt="" class="injectable">
                                    </div>
                                    <div class="shape-two">
                                        <img loading="lazy" src="assets/img/team/team_img_shape02.svg" alt="" class="injectable">
                                    </div>
                                </div>
                            </div>
                            <div class="team__item-content">
                                <h4 class="title"><a href="about#team">Dr. R. Faith Rani</a></h4>
                                <span>M.V.Sc in Veterinary Surgery and Radiology</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="team__bottom-content" data-aos="fade-up" data-aos-delay="500">
                    <!-- <p>Our Valuable Expert Doctors Team</p> -->
                    <a href="about#team" class="btn">See All Doctors <img loading="lazy" src="assets/img/icon/right_arrow.svg" alt="" class="injectable"></a>
                </div>
            </div>
            <div class="team__shape">
                <img loading="lazy" src="assets/img/team/team_shape.png" alt="img" class="ribbonRotate">
            </div>
        </section>
        <!-- team-area-end -->


        <!-- testimonial-area -->
        <section class="testimonial__area">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6 col-md-8 order-0 order-lg-2">
                        <div class="testimonial__img" data-aos="fade-left" data-aos-delay="200">
                            <div class="mask-img testimonial__img-mask">
                                <img loading="lazy" src="assets/img/images/testimonial_img.png" alt="img">
                            </div>
                            <div class="testimonial__img-shape">
                                <div class="shape-one">
                                    <img loading="lazy" src="assets/img/images/testimonial_img_shape.svg" alt="" class="injectable">
                                </div>
                                <div class="shape-two">
                                    <img loading="lazy" src="assets/img/images/testimonial_shape03.png" alt="img" class="alltuchtopdown">
                                </div>
                            </div>
                            <div class="review__box">
                                <div class="review__box-shape">
                                    <img loading="lazy" src="assets/img/images/review_shape.svg" alt="" class="injectable">
                                </div>
                                <div class="review__box-content">
                                    <img loading="lazy" src="assets/img/icon/star.svg" alt="" class="injectable">
                                    <h2 class="title">850+</h2>
                                    <span>Happy pets</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" data-aos="fade-right" data-aos-delay="300">
                        <div class="testimonial__item-wrap">
                            <div class="swiper testimonial-active">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="testimonial__item">
                                            <div class="testimonial__icon">
                                                <img loading="lazy" src="assets/img/icon/quote.svg" alt="" class="injectable">
                                            </div>
                                            <div class="testimonial__content">
                                                <h2 class="title">Exceptional Care & Parvo Recovery</h2>
                                                <p>“ Words can’t express our gratitude for the treatments and care our pets received at Laikas in the last six months.

Our special thanks to Dr. Senthil, Dr. Bismin and all other support staff at Laikas. All their collective effort helped three of our pets survive parvo and get back on track.

The hospital has all the required facilities/infrastructure for any type of pet emergency or treatment. ”</p>
                                                <div class="testimonial__author">
                                                    <div class="testimonial__author-thumb">
                                                        <div class="author-letter">H</div>
                                                    </div>
                                                    <div class="testimonial__author-content">
                                                        <h4 class="title">Harish N</h4>
                                                        <!-- <span>Business Study</span> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="testimonial__item">
                                            <div class="testimonial__icon">
                                                <img loading="lazy" src="assets/img/icon/quote.svg" alt="" class="injectable">
                                            </div>
                                            <div class="testimonial__content">
                                                <h2 class="title">Excellent Treatment & Recovery</h2>
                                                <p>“ My puppy was sick due to jaundice and Parvo virus. Dr.Senthil Kumar sir has treated him very well and now puppy is recovering. They have well mannered staff and we can get best dog food with reasonable cost. ”</p>
                                                <div class="testimonial__author">
                                                    <div class="testimonial__author-thumb">
                                                        <div class="author-letter">M</div>
                                                    </div>
                                                    <div class="testimonial__author-content">
                                                        <h4 class="title">Mohan Chinna</h4>
                                                        <!-- <span>Business Study</span> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="testimonial__shape-wrap">
                <img loading="lazy" src="assets/img/images/testimonial_shape01.png" alt="img" data-aos="fade-down-right" data-aos-delay="400">
                <img loading="lazy" src="assets/img/images/testimonial_shape02.png" alt="img" data-aos="fade-right" data-aos-delay="400">
            </div>
        </section>
        <!-- testimonial-area-end -->

        <!-- registration-area -->
        <section class="registration__area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="registration__inner-wrap" data-aos="fade-up" data-aos-delay="200">
                            <h2 class="title">Schedule a visit today!</h2>
                            <div class="shape">
                                <img loading="lazy" src="assets/img/images/registration_shape.svg" alt="">
                            </div>
                            <form action="#">
                                <div class="row gutter-15">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-grp">
                                            <label for="name">Name</label>
                                            <input id="name" type="text" placeholder="Type Full Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-grp">
                                            <label for="phone">Phone</label>
                                            <input id="phone" type="tel" placeholder="+91  ....">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-grp select-grp">
                                            <label>Pet Type</label>
                                            <select name="pet_type" class="orderby">
                                                <option value="Select Pet Type">Select Pet Type</option>
                                                <option value="Cat">Cat</option>
                                                <option value="Dog">Dog</option>
                                                <option value="Bird">Bird</option>
                                                <option value="Rabbit">Rabbit</option>
                                                <!-- <option value="Fish">Fish</option> -->
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-grp select-grp">
                                            <label>Interest In</label>
                                            <select name="interest" class="orderby">
                                                <option value="Select Service">Select Service</option>
                                                <option value="Pet Training">Pet Training</option>
                                                <option value="Pet Grooming">Pet Grooming</option>
                                                <option value="Care Services">Care Services</option>
                                                <option value="Pet Boarding">Pet Boarding</option>
                                                <option value="Pet Bath">Pet Bath</option>
                                                <option value="Pet Adoption">Pet Adoption</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-grp">
                                            <label for="date">Date</label>
                                            <input id="date" type="text" class="datepicker" placeholder="Select Date" autocomplete="off" style="width: 100%; padding: 14px 20px; border-radius: 6px; border: 1px solid #EBEBEB; color: var(--tg-body-color);">
                                            <i class="far fa-calendar-alt" style="cursor: pointer;"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-grp">
                                            <label for="message">Message</label>
                                            <textarea id="message" placeholder="Type your message" style="width: 100%; height: 56px; resize: none; padding: 14px 20px; border-radius: 6px; border: 1px solid #EBEBEB;"></textarea>
                                        </div>
                                    </div>
                                    
                                </div>
                                <style>
                                    /* Make sub-title pet icon black */
                                    .section__title.white-title .sub-title svg {
                                        color: #000000 !important;
                                    }
                                    /* Normal state */
                                    .registration__inner-wrap .submit__btn .btn-registration {
                                        background-color: #ffffff !important;
                                        color: #ed1f31 !important;
                                        border: 2px solid #ed1f31 !important;
                                        transition: all 0.3s ease;
                                    }
                                    /* Hover sliding overlay background */
                                    .registration__inner-wrap .submit__btn .btn-registration::before {
                                        background: #ed1f31 !important;
                                    }
                                    /* Hover state */
                                    .registration__inner-wrap .submit__btn .btn-registration:hover {
                                        background-color: #ed1f31 !important;
                                        color: #ffffff !important;
                                    }
                                    /* Ensure SVG stroke icon is white on hover */
                                    .registration__inner-wrap .submit__btn .btn-registration:hover svg path {
                                        stroke: #ffffff !important;
                                    }
                                    
                                    /* Mobile Carousel Grid to Slider */
                                    @media (max-width: 767.98px) {
                                        .mobile-carousel {
                                            display: flex !important;
                                            flex-wrap: nowrap !important;
                                            overflow-x: auto !important;
                                            scroll-snap-type: x mandatory !important;
                                            scroll-behavior: smooth !important;
                                            -webkit-overflow-scrolling: touch !important;
                                            padding: 10px 20px 25px 20px !important;
                                            margin-left: -20px !important;
                                            margin-right: -20px !important;
                                            justify-content: flex-start !important;
                                        }
                                        
                                        /* Hide scrollbar */
                                        .mobile-carousel::-webkit-scrollbar {
                                            display: none !important;
                                        }
                                        .mobile-carousel {
                                            -ms-overflow-style: none !important;
                                            scrollbar-width: none !important;
                                        }
                                        
                                        .mobile-carousel-item {
                                            flex: 0 0 82% !important;
                                            max-width: 82% !important;
                                            scroll-snap-align: center !important;
                                            margin-right: 15px !important;
                                            padding-left: 0 !important;
                                            padding-right: 0 !important;
                                        }
                                        
                                        .mobile-carousel-item:last-child {
                                            margin-right: 0 !important;
                                        }

                                        /* Bypass AOS on mobile to prevent hidden items */
                                        .mobile-carousel-item[data-aos] {
                                            opacity: 1 !important;
                                            transform: none !important;
                                            transition: none !important;
                                        }
                                    }
                                </style>
                                <div class="submit__btn text-center mt-25">
                                    <button type="submit" class="btn btn-registration">Schedule Your visit <img loading="lazy" src="assets/img/icon/right_arrow.svg" alt="" class="injectable"></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- registration-area-end -->

        <!-- blog-post-area -->
        <section class="blog__post-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="section__title mb-40" data-aos="fade-up" data-aos-delay="200">
                            <span class="sub-title">News & Blogs
                                <strong class="shake">
                                    <img loading="lazy" src="assets/img/icon/pet_icon02.svg" alt="" class="injectable">
                                </strong>
                            </span>
                            <h2 class="title">Our Recent Articles</h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="view__all-btn text-end mb-40" data-aos="fade-up" data-aos-delay="300">
                            <a href="blog" class="btn btn-two">See All Posts <img loading="lazy" src="assets/img/icon/right_arrow.svg" alt="" class="injectable"></a>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mobile-carousel">
                    <?php if (!empty($home_posts)): ?>
                        <?php 
                        $delay = 300;
                        foreach ($home_posts as $post): 
                        ?>
                            <div class="col-lg-4 col-md-6 col-sm-8 mobile-carousel-item" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
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
                                    </div>
                                </div>
                            </div>
                        <?php 
                            $delay += 100;
                        endforeach; 
                        ?>
                    <?php else: ?>
                        <div class="col-lg-4 col-md-6 col-sm-8 mobile-carousel-item" data-aos="fade-up" data-aos-delay="300">
                            <div class="blog__post-item shine-animate-item">
                                <div class="blog__post-thumb">
                                    <div class="blog__post-mask shine-animate">
                                        <a href="blog"><img loading="lazy" src="assets/img/blog/blog_post01.png" alt="img"></a>
                                        <ul class="list-wrap blog__post-tag">
                                            <li><a href="blog">Pet</a></li>
                                            <li><a href="blog">Medical</a></li>
                                        </ul>
                                    </div>
                                    <div class="shape">
                                        <img loading="lazy" src="assets/img/blog/blog_img_shape.svg" alt="" class="injectable">
                                    </div>
                                </div>
                                <div class="blog__post-content">
                                    <div class="blog__post-meta">
                                        <ul class="list-wrap">
                                            <li><i class="flaticon-user"></i>by <a href="blog">admin</a></li>
                                            <li><i class="flaticon-calendar"></i>25th Mar, 2026</li>
                                        </ul>
                                    </div>
                                    <h2 class="title"><a href="blog">Clean indoor air as important in controlling asthma</a></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-8 mobile-carousel-item" data-aos="fade-up" data-aos-delay="400">
                            <div class="blog__post-item shine-animate-item">
                                <div class="blog__post-thumb">
                                    <div class="blog__post-mask shine-animate">
                                        <a href="blog"><img loading="lazy" src="assets/img/blog/blog_post01.png" alt="img"></a>
                                        <ul class="list-wrap blog__post-tag">
                                            <li><a href="blog">Care</a></li>
                                        </ul>
                                    </div>
                                    <div class="shape">
                                        <img loading="lazy" src="assets/img/blog/blog_img_shape.svg" alt="" class="injectable">
                                    </div>
                                </div>
                                <div class="blog__post-content">
                                    <div class="blog__post-meta">
                                        <ul class="list-wrap">
                                            <li><i class="flaticon-user"></i>by <a href="blog">admin</a></li>
                                            <li><i class="flaticon-calendar"></i>25th Mar, 2026</li>
                                        </ul>
                                    </div>
                                    <h2 class="title"><a href="blog">Clean indoor air as important in controlling asthma</a></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-8 mobile-carousel-item" data-aos="fade-up" data-aos-delay="500">
                            <div class="blog__post-item shine-animate-item">
                                <div class="blog__post-thumb">
                                    <div class="blog__post-mask shine-animate">
                                        <a href="blog"><img loading="lazy" src="assets/img/blog/blog_post01.png" alt="img"></a>
                                        <ul class="list-wrap blog__post-tag">
                                            <li><a href="blog">Pet Care</a></li>
                                        </ul>
                                    </div>
                                    <div class="shape">
                                        <img loading="lazy" src="assets/img/blog/blog_img_shape.svg" alt="" class="injectable">
                                    </div>
                                </div>
                                <div class="blog__post-content">
                                    <div class="blog__post-meta">
                                        <ul class="list-wrap">
                                            <li><i class="flaticon-user"></i>by <a href="blog">admin</a></li>
                                            <li><i class="flaticon-calendar"></i>25th Mar, 2026</li>
                                        </ul>
                                    </div>
                                    <h2 class="title"><a href="blog">Clean indoor air as important in controlling asthma</a></h2>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="blog__shape-wrap">
                <img loading="lazy" src="assets/img/blog/blog_shape01.png" alt="img" data-aos="fade-up-right" data-aos-delay="400">
                <img loading="lazy" src="assets/img/blog/blog_shape02.png" alt="img" class="ribbonRotate">
            </div>
        </section>
        <!-- blog-post-area-end -->

        <!-- instagram-area -->
        <!-- <div class="instagram__area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="instagram__follow-btn">
                            <a href="https://www.instagram.com/" target="_blank">Follow Us On Instagram</a>
                        </div>
                    </div>
                </div>
                <div class="swiper instagram-active">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="instagram__item">
                                <a href="https://www.instagram.com/" target="_blank"><img loading="lazy" src="assets/img/instagram/instagram_img01.jpg" alt=""></a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="instagram__item">
                                <a href="https://www.instagram.com/" target="_blank"><img loading="lazy" src="assets/img/instagram/instagram_img02.jpg" alt=""></a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="instagram__item">
                                <a href="https://www.instagram.com/" target="_blank"><img loading="lazy" src="assets/img/instagram/instagram_img03.jpg" alt=""></a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="instagram__item">
                                <a href="https://www.instagram.com/" target="_blank"><img loading="lazy" src="assets/img/instagram/instagram_img04.jpg" alt=""></a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="instagram__item">
                                <a href="https://www.instagram.com/" target="_blank"><img loading="lazy" src="assets/img/instagram/instagram_img05.jpg" alt=""></a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="instagram__item">
                                <a href="https://www.instagram.com/" target="_blank"><img loading="lazy" src="assets/img/instagram/instagram_img03.jpg" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- instagram-area-end -->

    </main>
    <!-- main-area-end -->


<?php include 'footer.php'; ?>

