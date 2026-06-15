<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <?php
    $base_dir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
    ?>
    <base href="<?php echo htmlspecialchars($base_dir); ?>">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) : "Laika - Premium Pet Care & Veterinary Center"; ?></title>
    <meta name="description" content="<?php echo isset($page_description) ? htmlspecialchars($page_description) : "Laika provides compassionate, high-quality care for your beloved pets. From routine checkups to specialized treatments, your pet's health is our top priority."; ?>">
    <?php if (isset($page_keywords) && !empty($page_keywords)): ?>
    <meta name="keywords" content="<?php echo htmlspecialchars($page_keywords); ?>">
    <?php endif; ?>
    <?php
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $clean_uri = preg_replace('/\.php$/i', '', $request_uri);
    $canonical_url = $protocol . $host . $clean_uri;
    ?>
    <link rel="canonical" href="<?php echo htmlspecialchars($canonical_url); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/flaticon_pet_care.css">
    <link rel="stylesheet" href="assets/css/odometer.css">
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/css/select2.min.css">
    <link rel="stylesheet" href="assets/css/jquery-ui.css">
    <link rel="stylesheet" href="assets/css/aos.css">
    <link rel="stylesheet" href="assets/css/default.css">
    <link rel="stylesheet" href="assets/css/main.css?v=1.3">
</head>

<body>

    <!--Preloader-->
    <!-- <div id="preloader">
        <div id="loader" class="loader">
            <div class="loader-container">
                <div class="loader-icon"><img src="assets/img/logo/preloader.svg" alt="Preloader"></div>
            </div>
        </div>
    </div> -->
    <!--Preloader-end -->

    <!-- Scroll-top -->
    <button class="scroll__top scroll-to-target" data-target="html">
        <i class="fas fa-angle-up"></i>
    </button>
    <!-- Scroll-top-end-->

    <!-- header-area -->
    <header>
        <div id="header-fixed-height"></div>
        <div class="tg-header__top">
            <div class="container custom-container">
                <div class="row">
                    <div class="col-xl-6 col-lg-8">
                        <ul class="tg-header__top-info left-side list-wrap">
                            <li><i class="flaticon-placeholder"></i>VIT ROAD, Vellore - Chennai Rd, Old Katpadi, Vellore
                            </li>
                            <li><i class="flaticon-mail"></i><a href="mailto:info@likapet.in">info@likapet.in</a></li>
                        </ul>
                    </div>
                    <div class="col-xl-6 col-lg-4">
                        <ul class="tg-header__top-right list-wrap">
                            <li><i class="flaticon-three-o-clock-clock"></i>Working Hours: Mon - Sun : 9am to 7pm</li>
                            <li class="tg-header__top-social">
                                <ul class="list-wrap">
                                    <li><a href="https://www.facebook.com/" target="_blank"><i
                                                class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="https://twitter.com" target="_blank"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                fill="currentColor" viewBox="0 0 16 16" style="margin-top:-3px;">
                                                <path
                                                    d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z" />
                                            </svg></a></li>
                                    <!-- <li><a href="https://www.whatsapp.com/" target="_blank"><i class="fab fa-whatsapp"></i></a></li> -->
                                    <li><a href="https://www.instagram.com/" target="_blank"><i
                                                class="fab fa-instagram"></i></a></li>
                                    <li><a href="https://www.youtube.com/" target="_blank"><i
                                                class="fab fa-youtube"></i></a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="sticky-header" class="tg-header__area">
            <div class="container custom-container">
                <div class="row">
                    <div class="col-12">
                        <div class="tgmenu__wrap">
                            <nav class="tgmenu__nav">
                                <div class="logo" style="margin-left: 180px;">
                                    <a href="./"><img src="assets/img/logo/logo.png" alt="Logo" style="transform: scale(1.4); transform-origin: left center;"></a>
                                </div>
                                <div class="tgmenu__navbar-wrap tgmenu__main-menu d-none d-lg-flex">
                                    <ul class="navigation">
                                        <li><a href="./">Home</a>
                                            <!-- <ul class="sub-menu">
                                                <li class="active"><a href="./">Pet Care & Veterinary</a></li>
                                                <li><a href="index-2">Pet Breed</a></li>
                                                <li><a href="index-3">Pet Adopt</a></li>
                                                <li><a href="index-4">pet Woocommerce</a></li>
                                            </ul> -->
                                        </li>
                                        <li><a href="about">About</a></li>
                                        <!-- <li class="menu-item-has-children"><a href="#">Shop</a>
                                            <ul class="sub-menu">
                                                <li><a href="product">Our Shop</a></li>
                                                <li><a href="product-details">Shop Details</a></li>
                                            </ul>
                                        </li> -->
                                        <li class="menu-item-has-children"><a href="service">Services</a>
                                            <ul class="sub-menu">
                                                <li><a href="service#pet-care">Pet Care Service</a></li>
                                                <li><a href="service#vaccination">Vaccination & Treatment</a></li>
                                                <li><a href="service#surgical">Surgical Center</a></li>
                                                <li><a href="service#diagnostic">Diagnostic laboratory</a></li>
                                                <li><a href="service#xray">X-ray & Ultra Scan</a></li>
                                                <li><a href="service#spa">Pet Spa(Grooming)</a></li>
                                                <li><a href="service#shop">Pet Shop</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="blog">Blogs</a></li>
                                        <li><a href="gallery">Gallery</a></li>
                                        <li><a href="contact">contacts</a></li>
                                    </ul>
                                </div>
                                <div class="tgmenu__action d-none d-md-block">
                                    <ul class="list-wrap">
                                        <!-- <li class="header-search">
                                            <a href="javascript:void(0)" class="search-open-btn">
                                                <i class="flaticon-loupe"></i>
                                            </a>
                                        </li>
                                        <li class="header-cart">
                                            <a href="javascript:void(0)">
                                                <i class="flaticon-shopping-bag"></i>
                                                <span>0</span>
                                            </a>
                                        </li> -->
                                        <!-- <li class="offCanvas-menu">
                                            <a href="javascript:void(0)" class="menu-tigger">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="16" viewBox="0 0 26 16" fill="none">
                                                    <rect width="9" height="2" rx="1" fill="currentcolor"/>
                                                    <rect x="11" width="15" height="2" rx="1" fill="currentcolor" />
                                                    <rect y="14" width="26" height="2" rx="1" fill="currentcolor" />
                                                    <rect y="7" width="16" height="2" rx="1" fill="currentcolor" />
                                                    <rect x="17" y="7" width="9" height="2" rx="1" fill="currentcolor" />
                                                </svg>
                                            </a>
                                        </li> -->
                                        <li class="header-btn"><a href="contact" class="btn"><i
                                                    class="flaticon-calendar-1"></i>Appointment</a></li>
                                    </ul>
                                </div>
                                <div class="mobile-nav-toggler">
                                    <i class="flaticon-layout"></i>
                                </div>
                            </nav>
                        </div>

                        <!-- Mobile Menu  -->
                        <div class="tgmobile__menu">
                            <nav class="tgmobile__menu-box">
                                <div class="close-btn"><i class="fas fa-times"></i></div>
                                <div class="nav-logo">
                                    <a href="./"><img src="assets/img/logo/logo.png" alt="Logo"></a>
                                </div>
                                <!-- <div class="tgmobile__search">
                                    <form action="#">
                                        <input type="text" placeholder="Search here...">
                                        <button><i class="fas fa-search"></i></button>
                                    </form>
                                </div> -->
                                <div class="tgmobile__menu-outer">
                                    <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                                </div>
                                <div class="social-links">
                                    <ul class="list-wrap">
                                        <li><a href="https://www.facebook.com/" target="_blank"><i
                                                    class="fab fa-facebook-f"></i></a></li>
                                        <li><a href="https://twitter.com" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512" fill="currentColor"><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/></svg></a></li>
                                        <!-- <li><a href="https://www.whatsapp.com/" target="_blank"><i class="fab fa-whatsapp"></i></a></li> -->
                                        <li><a href="https://www.instagram.com/" target="_blank"><i
                                                    class="fab fa-instagram"></i></a></li>
                                        <li><a href="https://www.youtube.com/" target="_blank"><i
                                                    class="fab fa-youtube"></i></a></li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                        <div class="tgmobile__menu-backdrop"></div>
                        <!-- End Mobile Menu -->

                    </div>
                </div>
            </div>
        </div>

        <!-- header-search -->
        <div class="search__popup">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="search__wrapper">
                            <div class="search__close">
                                <button type="button" class="search-close-btn">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17 1L1 17" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M1 1L17 17" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="search__form">
                                <form action="#">
                                    <div class="search__input">
                                        <input class="search-input-field" type="text" placeholder="Type keywords here">
                                        <span class="search-focus-border"></span>
                                        <button>
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M9.55 18.1C14.272 18.1 18.1 14.272 18.1 9.55C18.1 4.82797 14.272 1 9.55 1C4.82797 1 1 4.82797 1 9.55C1 14.272 4.82797 18.1 9.55 18.1Z"
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path d="M19.0002 19.0002L17.2002 17.2002" stroke="currentcolor"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="search-popup-overlay"></div>
        <!-- header-search-end -->

        <!-- offCanvas-menu -->
        <div class="offCanvas__info">
            <div class="offCanvas__close-icon menu-close">
                <button><i class="far fa-window-close"></i></button>
            </div>
            <div class="offCanvas__logo mb-30">
                <a href="./"><img src="assets/img/logo/logo.png" alt="Logo"></a>
            </div>
            <div class="offCanvas__side-info mb-30">
                <div class="contact-list mb-30">
                    <h4>Office Address</h4>
                    <p>VIT ROAD, Vellore - Chennai Rd, <br> Old Katpadi, Vellore, Tamil Nadu 632014, India</p>
                </div>
                <div class="contact-list mb-30">
                    <h4>Phone Number</h4>
                    <p>+919976415171</p>
                    <p>+919940919300</p>
                </div>
                <div class="contact-list mb-30">
                    <h4>Email Address</h4>
                    <p>info@likapet.in</p>
                </div>
            </div>
            <div class="offCanvas__social-icon mt-30">
                <a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a>
                <a href="javascript:void(0)"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                        fill="currentColor" viewBox="0 0 16 16" style="margin-top:-3px;">
                        <path
                            d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z" />
                    </svg></a>
                <a href="javascript:void(0)"><i class="fab fa-google-plus-g"></i></a>
                <a href="javascript:void(0)"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
        <div class="offCanvas__overly"></div>
        <!-- offCanvas-menu-end -->

    </header>
    <!-- header-area-end -->