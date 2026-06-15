<?php
// Define SEO metadata before header
$page_title = "Our Pet Care Services | Laika Pet Care & Veterinary Center";
$page_description = "Explore the complete range of professional pet care services at Laika. From routine checkups and vaccines to surgical center, scans, grooming spa, and pet shop.";
$page_keywords = "pet care services, dog grooming spa, veterinary surgery, diagnostic lab, cat vaccination, pet shop Katpadi, X-ray";

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
                        <h1 class="title">Our Services</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./">Home</a></li>
                                <li class="breadcrumb-separator"><i class="fas fa-angle-right"></i></li>
                                <li class="breadcrumb-item active" aria-current="page">Services</li>
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

    <!-- services-area -->
    <section class="services__area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-8 col-lg-9">
                    <div class="section__title mb-40" data-aos="fade-up" data-aos-delay="200">
                        <span class="sub-title">Complete Pet Wellness Care
                            <strong class="shake">
                                <img loading="lazy" src="assets/img/icon/pet_icon02.svg" alt="" class="injectable">
                            </strong>
                        </span>
                        <h2 class="title">Expert care and personalized support for every pet</h2>
                    </div>
                </div>
            </div>
            
            <div class="row justify-content-center">
                <!-- Service 1 -->
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
                            <h4 class="title"><a href="service#pet-care" onclick="activateServiceTab('pet-care')">Pet Care Service</a></h4>
                            <p>Routine checkups and preventive care to keep your pets healthy and happy.</p>
                            <a href="service#pet-care" onclick="activateServiceTab('pet-care')" class="btn border-btn">See Details <img loading="lazy" src="assets/img/icon/right_arrow02.svg" alt="" class="injectable"></a>
                        </div>
                    </div>
                </div>

                <!-- Service 2 -->
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
                            <h4 class="title"><a href="service#vaccination" onclick="activateServiceTab('vaccination')">Vaccination & Treatment</a></h4>
                            <p>Timely vaccines and treatments to protect pets from common illnesses.</p>
                            <a href="service#vaccination" onclick="activateServiceTab('vaccination')" class="btn border-btn">See Details <img loading="lazy" src="assets/img/icon/right_arrow02.svg" alt="" class="injectable"></a>
                        </div>
                    </div>
                </div>

                <!-- Service 3 -->
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
                            <h4 class="title"><a href="service#surgical" onclick="activateServiceTab('surgical')">Surgical Center</a></h4>
                            <p>Safe, modern procedures for pets with precision and care.</p>
                            <a href="service#surgical" onclick="activateServiceTab('surgical')" class="btn border-btn">See Details <img loading="lazy" src="assets/img/icon/right_arrow02.svg" alt="" class="injectable"></a>
                        </div>
                    </div>
                </div>

                <!-- Service 4 -->
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
                            <h4 class="title"><a href="service#diagnostic" onclick="activateServiceTab('diagnostic')">Diagnostic laboratory</a></h4>
                            <p>Accurate lab tests and imaging for early health issue detection.</p>
                            <a href="service#diagnostic" onclick="activateServiceTab('diagnostic')" class="btn border-btn">See Details <img loading="lazy" src="assets/img/icon/right_arrow02.svg" alt="" class="injectable"></a>
                        </div>
                    </div>
                </div>

                <!-- Service 5 -->
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
                            <h4 class="title"><a href="service#xray" onclick="activateServiceTab('xray')">X-ray & Ultra Scan</a></h4>
                            <p>Advanced imaging to assess and monitor your pet’s health.</p>
                            <a href="service#xray" onclick="activateServiceTab('xray')" class="btn border-btn">See Details <img loading="lazy" src="assets/img/icon/right_arrow02.svg" alt="" class="injectable"></a>
                        </div>
                    </div>
                </div>

                <!-- Service 6 -->
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
                            <h4 class="title"><a href="service#spa" onclick="activateServiceTab('spa')">Pet Spa(Grooming)</a></h4>
                            <p>Professional pet spa services for hygiene and comfort.</p>
                            <a href="service#spa" onclick="activateServiceTab('spa')" class="btn border-btn">See Details <img loading="lazy" src="assets/img/icon/right_arrow02.svg" alt="" class="injectable"></a>
                        </div>
                    </div>
                </div>

                <!-- Service 7 -->
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
                            <h4 class="title"><a href="service#shop" onclick="activateServiceTab('shop')">Pet Shop</a></h4>
                            <p>High-quality food, toys and essential products for daily care.</p>
                            <a href="service#shop" onclick="activateServiceTab('shop')" class="btn border-btn">See Details <img loading="lazy" src="assets/img/icon/right_arrow02.svg" alt="" class="injectable"></a>
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
            </div>
            <div class="marquee__box">
                <a href="#">Pet Care Service <img loading="lazy" src="assets/img/images/marquee_icon.svg" alt=""></a>
                <a href="#">Vaccination & Treatment <img loading="lazy" src="assets/img/images/marquee_icon.svg" alt=""></a>
                <a href="#">Surgical Center <img loading="lazy" src="assets/img/images/marquee_icon.svg" alt=""></a>
                <a href="#">Diagnostic Laboratory <img loading="lazy" src="assets/img/images/marquee_icon.svg" alt=""></a>
                <a href="#">X-ray & Ultra Scan <img loading="lazy" src="assets/img/images/marquee_icon.svg" alt=""></a>
                <a href="#">Pet Spa (Grooming) <img loading="lazy" src="assets/img/images/marquee_icon.svg" alt=""></a>
                <a href="#">Pet Shop <img loading="lazy" src="assets/img/images/marquee_icon.svg" alt=""></a>
            </div>
        </div>
    </div>
    <!-- marquee-area-end -->

    <!-- explore-services detail tabs section -->
    <section id="explore-services" class="services__detail-area" style="padding: 100px 0; background-color: #f7f7f9;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section__title text-center mb-50" data-aos="fade-up">
                        <span class="sub-title">Service Details Explorer
                            <strong class="shake">
                                <img loading="lazy" src="assets/img/icon/pet_icon02.svg" alt="" class="injectable">
                            </strong>
                        </span>
                        <h2 class="title">Everything You Need to Know</h2>
                    </div>
                </div>
            </div>

            <style>
                .service-tabs-nav {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 10px;
                    justify-content: center;
                    margin-bottom: 40px;
                }
                .service-tab-btn {
                    background-color: #ffffff;
                    border: 1px solid #ebebeb;
                    color: var(--tg-body-color);
                    padding: 12px 24px;
                    border-radius: 30px;
                    font-weight: 600;
                    font-size: 15px;
                    cursor: pointer;
                    transition: all 0.3s ease;
                }
                .service-tab-btn:hover,
                .service-tab-btn.active {
                    background-color: #ed1f31;
                    color: #ffffff;
                    border-color: #ed1f31;
                    box-shadow: 0 5px 15px rgba(237, 31, 49, 0.2);
                }
                .service-tab-content {
                    background: #ffffff;
                    border-radius: 20px;
                    padding: 40px;
                    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
                    display: none;
                }
                .service-tab-content.active {
                    display: block;
                    animation: fadeInUp 0.5s ease forwards;
                }
                .service-detail-list li {
                    display: flex;
                    align-items: flex-start;
                    gap: 10px;
                    margin-bottom: 15px;
                    color: var(--tg-body-color);
                }
                .service-detail-list li i {
                    color: #ed1f31;
                    font-size: 16px;
                    margin-top: 4px;
                }
            </style>

            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="service-tabs-nav" data-aos="fade-up">
                        <button class="service-tab-btn active" onclick="showServiceTab('pet-care')">Pet Care</button>
                        <button class="service-tab-btn" onclick="showServiceTab('vaccination')">Vaccines & Treatment</button>
                        <button class="service-tab-btn" onclick="showServiceTab('surgical')">Surgical Center</button>
                        <button class="service-tab-btn" onclick="showServiceTab('diagnostic')">Diagnostic Lab</button>
                        <button class="service-tab-btn" onclick="showServiceTab('xray')">X-Ray & Scan</button>
                        <button class="service-tab-btn" onclick="showServiceTab('spa')">Pet Spa & Groom</button>
                        <button class="service-tab-btn" onclick="showServiceTab('shop')">Pet Shop</button>
                    </div>

                    <div class="service-tabs-contents" data-aos="fade-up" data-aos-delay="200">
                        <!-- Tab 1: Pet Care -->
                        <div class="service-tab-content active" id="tab-pet-care">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <div class="services__detail-content">
                                        <h3 class="fw-bold mb-3 text-dark">Preventive Pet Care & Wellness</h3>
                                        <p class="mb-20">Support your pet’s long-term health with proactive wellness care, regular monitoring and preventive guidance designed to promote comfort, vitality and overall well-being at every life stage.</p>
                                        <h5 class="fw-bold text-dark mb-3">What We Cover</h5>
                                        <ul class="list-wrap service-detail-list">
                                            <li><i class="fas fa-check-circle"></i> Wellness assessments and health monitoring</li>
                                            <li><i class="fas fa-check-circle"></i> Growth and body condition evaluation</li>
                                            <li><i class="fas fa-check-circle"></i> Preventive care recommendations</li>
                                            <li><i class="fas fa-check-circle"></i> Personalized guidance for lifelong pet wellness</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="services__detail-img text-center">
                                        <img loading="lazy" src="assets/img/images/pet_care_img.png" alt="Pet Care" style="max-width: 90%; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.08);">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 2: Vaccines & Treatment -->
                        <div class="service-tab-content" id="tab-vaccination">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <div class="services__detail-content">
                                        <h3 class="fw-bold mb-3 text-dark">Protection Through Vaccination & Care</h3>
                                        <p class="mb-20">Protect your pet from preventable illnesses with timely vaccinations and professional medical care designed to support immunity, recovery and long-term health.</p>
                                        <h5 class="fw-bold text-dark mb-3">What We Cover</h5>
                                        <ul class="list-wrap service-detail-list">
                                            <li><i class="fas fa-check-circle"></i> Core and lifestyle-based vaccinations</li>
                                            <li><i class="fas fa-check-circle"></i> Preventive healthcare programs</li>
                                            <li><i class="fas fa-check-circle"></i> Medical consultations and treatments</li>
                                            <li><i class="fas fa-check-circle"></i> Follow-up care and recovery support</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="services__detail-img text-center">
                                        <img loading="lazy" src="assets/img/images/vaccines-treatments-img.png" alt="Vaccination" style="max-width: 90%; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.08);">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 3: Surgical Center -->
                        <div class="service-tab-content" id="tab-surgical">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <div class="services__detail-content">
                                        <h3 class="fw-bold mb-3 text-dark">Advanced Surgical Care & Recovery</h3>
                                        <p class="mb-20">Our surgical services focus on safety, precision and comfort, ensuring pets receive professional care before, during and after every procedure.</p>
                                        <h5 class="fw-bold text-dark mb-3">What We Cover</h5>
                                        <ul class="list-wrap service-detail-list">
                                            <li><i class="fas fa-check-circle"></i> Routine surgical procedures</li>
                                            <li><i class="fas fa-check-circle"></i> Soft tissue surgeries</li>
                                            <li><i class="fas fa-check-circle"></i> Pre-surgical evaluations</li>
                                            <li><i class="fas fa-check-circle"></i> Post-operative monitoring and care</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="services__detail-img text-center">
                                        <img loading="lazy" src="assets/img/images/surgery_img.png" alt="Surgical Center" style="max-width: 90%; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.08);">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 4: Diagnostic Lab -->
                        <div class="service-tab-content" id="tab-diagnostic">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <div class="services__detail-content">
                                        <h3 class="fw-bold mb-3 text-dark">Accurate Diagnostics & Health Insights</h3>
                                        <p class="mb-20">Accurate diagnostics help identify health concerns early, allowing timely treatment decisions and better outcomes for your pet's overall well-being.</p>
                                        <h5 class="fw-bold text-dark mb-3">What We Cover</h5>
                                        <ul class="list-wrap service-detail-list">
                                            <li><i class="fas fa-check-circle"></i> Laboratory testing services</li>
                                            <li><i class="fas fa-check-circle"></i> Blood and urine analysis</li>
                                            <li><i class="fas fa-check-circle"></i> Health screening support</li>
                                            <li><i class="fas fa-check-circle"></i> Early disease detection</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="services__detail-img text-center">
                                        <img loading="lazy" src="assets/img/images/lab_img.png" alt="Diagnostic Lab" style="max-width: 90%; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.08);">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 5: X-Ray & Scan -->
                        <div class="service-tab-content" id="tab-xray">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <div class="services__detail-content">
                                        <h3 class="fw-bold mb-3 text-dark">Advanced Imaging & Diagnostic Support</h3>
                                        <p class="mb-20">Advanced imaging services provide detailed insights into your pet’s internal health, supporting accurate diagnosis and effective treatment planning.</p>
                                        <h5 class="fw-bold text-dark mb-3">What We Cover</h5>
                                        <ul class="list-wrap service-detail-list">
                                            <li><i class="fas fa-check-circle"></i> Digital X-ray imaging</li>
                                            <li><i class="fas fa-check-circle"></i> Ultrasound examinations</li>
                                            <li><i class="fas fa-check-circle"></i> Internal health assessments</li>
                                            <li><i class="fas fa-check-circle"></i> Diagnostic imaging support</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="services__detail-img text-center">
                                        <img loading="lazy" src="assets/img/images/xray_scan_img.png" alt="X-Ray & Scan" style="max-width: 90%; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.08);">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 6: Pet Spa & Groom -->
                        <div class="service-tab-content" id="tab-spa">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <div class="services__detail-content">
                                        <h3 class="fw-bold mb-3 text-dark">Professional Grooming & Hygiene Care</h3>
                                        <p class="mb-20">Professional grooming services help maintain hygiene, comfort and appearance while supporting healthy skin, coat condition and overall wellness.</p>
                                        <h5 class="fw-bold text-dark mb-3">What We Cover</h5>
                                        <ul class="list-wrap service-detail-list">
                                            <li><i class="fas fa-check-circle"></i> Bathing and coat care</li>
                                            <li><i class="fas fa-check-circle"></i> Nail trimming services</li>
                                            <li><i class="fas fa-check-circle"></i> Ear and hygiene cleaning</li>
                                            <li><i class="fas fa-check-circle"></i> Routine grooming maintenance</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="services__detail-img text-center">
                                        <img loading="lazy" src="assets/img/images/spa_img.png" alt="Pet Spa" style="max-width: 90%; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.08);">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 7: Pet Shop -->
                        <div class="service-tab-content" id="tab-shop">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <div class="services__detail-content">
                                        <h3 class="fw-bold mb-3 text-dark">Quality Essentials for Everyday Pet Care</h3>
                                        <p class="mb-20">Find quality pet essentials carefully selected to support nutrition, comfort, enrichment and everyday care for pets of all ages.</p>
                                        <h5 class="fw-bold text-dark mb-3">What We Cover</h5>
                                        <ul class="list-wrap service-detail-list">
                                            <li><i class="fas fa-check-circle"></i> Premium pet foods</li>
                                            <li><i class="fas fa-check-circle"></i> Treats and supplements</li>
                                            <li><i class="fas fa-check-circle"></i> Toys and accessories</li>
                                            <li><i class="fas fa-check-circle"></i> Daily care essentials</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="services__detail-img text-center">
                                        <img loading="lazy" src="assets/img/images/shop_img.png" alt="Pet Shop" style="max-width: 90%; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.08);">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- counter-area -->
    <!-- <section class="counter__area" style="padding: 80px 0;">
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
                        <a href="about" class="btn border-btn white-btn">About Our History <img loading="lazy" src="assets/img/icon/right_arrow.svg" alt="" class="injectable"></a>
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
    </section> -->
    <!-- counter-area-end -->

    <!-- registration-area / quick booking form -->
    <!-- <section class="registration__area pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="registration__inner-wrap" data-aos="fade-up" data-aos-delay="200">
                        <h2 class="title">Book a Service Appointment</h2>
                        <div class="shape">
                            <img loading="lazy" src="assets/img/images/registration_shape.svg" alt="">
                        </div>
                        <form action="contact" method="GET">
                            <div class="row gutter-15">
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-grp">
                                        <label for="name">Name</label>
                                        <input id="name" type="text" placeholder="Type Full Name" required>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-grp">
                                        <label for="phone">Phone</label>
                                        <input id="phone" type="tel" placeholder="+91  ...." required>
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
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-grp select-grp">
                                        <label>Select Service</label>
                                        <select id="booking-service-select" name="interest" class="orderby">
                                            <option value="Select Service">Select Service</option>
                                            <option value="Pet Care Service">Pet Care Service</option>
                                            <option value="Vaccination & Treatment">Vaccination & Treatment</option>
                                            <option value="Surgical Center">Surgical Center</option>
                                            <option value="Diagnostic laboratory">Diagnostic laboratory</option>
                                            <option value="X-ray & Ultra Scan">X-ray & Ultra Scan</option>
                                            <option value="Pet Spa(Grooming)">Pet Spa & Grooming</option>
                                            <option value="Pet Shop">Pet Shop Items</option>
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
                                        <label for="message">Details</label>
                                        <textarea id="message" placeholder="Special needs or details" style="width: 100%; height: 56px; resize: none; padding: 14px 20px; border-radius: 6px; border: 1px solid #EBEBEB;"></textarea>
                                    </div>
                                </div>
                            </div> 
                            <style>
                                /* Sub-title pet icon black */
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
                                    border-color: #ed1f31 !important;
                                }
                                /* Ensure SVG stroke icon is white on hover */
                                .registration__inner-wrap .submit__btn .btn-registration:hover svg path {
                                    stroke: #ffffff !important;
                                }
                            </style>
                            <div class="submit__btn text-center mt-25">
                                <button type="submit" class="btn btn-registration">Schedule Appointment <img loading="lazy" src="assets/img/icon/right_arrow.svg" alt="" class="injectable"></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>-->
    <!-- registration-area-end -->

</main>
<!-- main-area-end -->

<?php include 'footer.php'; ?>

<!-- Interactive Tabs script -->
<script>
    function showServiceTab(tabId) {
        // Deactivate all buttons
        const buttons = document.querySelectorAll('.service-tab-btn');
        buttons.forEach(btn => btn.classList.remove('active'));

        // Deactivate all contents
        const contents = document.querySelectorAll('.service-tab-content');
        contents.forEach(content => content.classList.remove('active'));

        // Find active button & tab
        const activeBtn = Array.from(buttons).find(btn => btn.getAttribute('onclick').includes(tabId));
        if (activeBtn) activeBtn.classList.add('active');

        const activeContent = document.getElementById('tab-' + tabId);
        if (activeContent) activeContent.classList.add('active');
    }

    function activateServiceTab(tabId) {
        // Trigger click event and scroll
        showServiceTab(tabId);
        
        // Update the select dropdown in the form to match the clicked service
        const selectElement = document.getElementById('booking-service-select');
        if (selectElement) {
            const options = selectElement.options;
            for (let i = 0; i < options.length; i++) {
                if (options[i].value.toLowerCase().includes(tabId.replace('-', ' '))) {
                    selectElement.selectedIndex = i;
                    // Trigger standard jQuery change event if select2 is used
                    if (window.jQuery && jQuery().select2) {
                        jQuery(selectElement).trigger('change');
                    }
                    break;
                }
            }
        }
    }

    // Auto-select tab and scroll based on URL hash
    document.addEventListener("DOMContentLoaded", function() {
        const hash = window.location.hash;
        if (hash) {
            const cleanHash = hash.replace('#', '');
            const validTabs = ['pet-care', 'vaccination', 'surgical', 'diagnostic', 'xray', 'spa', 'shop'];
            if (validTabs.includes(cleanHash)) {
                setTimeout(() => {
                    activateServiceTab(cleanHash);
                    const target = document.getElementById('explore-services');
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth' });
                    }
                }, 100);
            }
        }
    });

    window.addEventListener("hashchange", function() {
        const hash = window.location.hash;
        if (hash) {
            const cleanHash = hash.replace('#', '');
            const validTabs = ['pet-care', 'vaccination', 'surgical', 'diagnostic', 'xray', 'spa', 'shop'];
            if (validTabs.includes(cleanHash)) {
                activateServiceTab(cleanHash);
                const target = document.getElementById('explore-services');
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            }
        }
    });
</script>
