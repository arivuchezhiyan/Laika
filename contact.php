<?php
// Define SEO metadata before header
$page_title = "Contact Us | Laika Pet Care & Veterinary Center";
$page_description = "Get in touch with Laika Pet Care & Veterinary Center. View our clinic location in Old Katpadi, Vellore, contact numbers, email, operational hours, or send us an inquiry.";
$page_keywords = "contact Laika pet care, veterinary clinic phone number, pet clinic address Katpadi, vet email, map, appointment inquiry";

// Form submission handling in PHP
$message_status = "";
$message_class = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize inputs
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
    $msg = isset($_POST['message']) ? trim($_POST['message']) : '';

    if (empty($name) || empty($phone) || empty($msg)) {
        $message_status = "Please fill in all required fields (Name, Phone, and Message).";
        $message_class = "alert-danger";
    } else {
        // Success placeholder response
        $message_status = "Thank you, $name! Your message has been received. We will get back to you shortly.";
        $message_class = "alert-success";
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
                        <h1 class="title">Contact Us</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./">Home</a></li>
                                <li class="breadcrumb-separator"><i class="fas fa-angle-right"></i></li>
                                <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
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

    <!-- contact-info-area -->
    <section class="contact-info-area" style="padding: 80px 0;">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Head Office Address Card -->
                <div class="col-lg-4 col-md-6 mb-30" data-aos="fade-up" data-aos-delay="200">
                    <div class="contact-info-item text-center p-4" style="background: #ffffff; border-radius: 20px; box-shadow: 0px 10px 30px rgba(0,0,0,0.05); height: 100%; border: 1px solid #ebebeb;">
                        <div class="icon mb-3" style="font-size: 35px; color: #ed1f31; display: inline-block; width: 70px; height: 70px; line-height: 70px; border-radius: 50%; background: #fdf2f3;">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h4 class="title mb-2 fw-bold text-dark" style="font-size: 20px;">Head Office</h4>
                        <p class="mb-0 text-muted" style="font-size: 15px;">
                            KMJ Complex, VIT Road,<br>
                            Old Katpadi - 632 007.<br>
                            Ph: <a href="tel:+916369937762" style="color: inherit; text-decoration: none; font-weight: 500;">63699 37762</a>
                        </p>
                    </div>
                </div>
                <!-- Branch Office 1 Address Card -->
                <div class="col-lg-4 col-md-6 mb-30" data-aos="fade-up" data-aos-delay="300">
                    <div class="contact-info-item text-center p-4" style="background: #ffffff; border-radius: 20px; box-shadow: 0px 10px 30px rgba(0,0,0,0.05); height: 100%; border: 1px solid #ebebeb;">
                        <div class="icon mb-3" style="font-size: 35px; color: #ed1f31; display: inline-block; width: 70px; height: 70px; line-height: 70px; border-radius: 50%; background: #fdf2f3;">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h4 class="title mb-2 fw-bold text-dark" style="font-size: 20px;">Branch Office</h4>
                        <p class="mb-0 text-muted" style="font-size: 15px;">
                            Om Sai Complex, Auxilium College,<br>
                            Rountana, Gandhi Nagar,<br>
                            Vellore - 632 007.<br>
                            Ph: <a href="tel:+919087073504" style="color: inherit; text-decoration: none; font-weight: 500;">9087073504</a>
                        </p>
                    </div>
                </div>
                <!-- Branch Office 2 Address Card -->
                <div class="col-lg-4 col-md-6 mb-30" data-aos="fade-up" data-aos-delay="400">
                    <div class="contact-info-item text-center p-4" style="background: #ffffff; border-radius: 20px; box-shadow: 0px 10px 30px rgba(0,0,0,0.05); height: 100%; border: 1px solid #ebebeb;">
                        <div class="icon mb-3" style="font-size: 35px; color: #ed1f31; display: inline-block; width: 70px; height: 70px; line-height: 70px; border-radius: 50%; background: #fdf2f3;">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h4 class="title mb-2 fw-bold text-dark" style="font-size: 20px;">Branch Office</h4>
                        <p class="mb-0 text-muted" style="font-size: 15px;">
                            Greamspet, Besides Duramma Temple,<br>
                            Opp to Union Bank, Vellore Road,<br>
                            Chittoor, AP.<br>
                            Ph: <a href="tel:+919384185171" style="color: inherit; text-decoration: none; font-weight: 500;">9384185171</a>
                        </p>
                    </div>
                </div>
                <!-- Phone Card -->
                <div class="col-lg-4 col-md-6 mb-30" data-aos="fade-up" data-aos-delay="200">
                    <div class="contact-info-item text-center p-4" style="background: #ffffff; border-radius: 20px; box-shadow: 0px 10px 30px rgba(0,0,0,0.05); height: 100%; border: 1px solid #ebebeb;">
                        <div class="icon mb-3" style="font-size: 35px; color: #ed1f31; display: inline-block; width: 70px; height: 70px; line-height: 70px; border-radius: 50%; background: #fdf2f3;">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <h4 class="title mb-2 fw-bold text-dark" style="font-size: 20px;">Phone Call</h4>
                        <p class="mb-0 text-muted" style="font-size: 15px;">
                            <a href="tel:+919976415171" style="color: inherit; text-decoration: none;">+919976415171</a><br>
                            <a href="tel:+919940919300" style="color: inherit; text-decoration: none;">+919940919300</a>
                        </p>
                    </div>
                </div>
                <!-- Email Card -->
                <div class="col-lg-4 col-md-6 mb-30" data-aos="fade-up" data-aos-delay="300">
                    <div class="contact-info-item text-center p-4" style="background: #ffffff; border-radius: 20px; box-shadow: 0px 10px 30px rgba(0,0,0,0.05); height: 100%; border: 1px solid #ebebeb;">
                        <div class="icon mb-3" style="font-size: 35px; color: #ed1f31; display: inline-block; width: 70px; height: 70px; line-height: 70px; border-radius: 50%; background: #fdf2f3;">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h4 class="title mb-2 fw-bold text-dark" style="font-size: 20px;">Email Address</h4>
                        <p class="mb-0 text-muted" style="font-size: 15px;">
                            <a href="mailto:info@likapet.in" style="color: inherit; text-decoration: none;">info@likapet.in</a>
                        </p>
                    </div>
                </div>
                <!-- Hours Card -->
                <div class="col-lg-4 col-md-6 mb-30" data-aos="fade-up" data-aos-delay="400">
                    <div class="contact-info-item text-center p-4" style="background: #ffffff; border-radius: 20px; box-shadow: 0px 10px 30px rgba(0,0,0,0.05); height: 100%; border: 1px solid #ebebeb;">
                        <div class="icon mb-3" style="font-size: 35px; color: #ed1f31; display: inline-block; width: 70px; height: 70px; line-height: 70px; border-radius: 50%; background: #fdf2f3;">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h4 class="title mb-2 fw-bold text-dark" style="font-size: 20px;">Working Hours</h4>
                        <p class="mb-0 text-muted" style="font-size: 15px;">Mon - Sun : 9am to 7pm</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- contact-info-area-end -->

    <!-- contact-form-map-area -->
    <section class="contact-form-map-area pb-100" style="background-color: #f7f7f9; padding: 80px 0;">
        <div class="container">
            <div class="row align-items-stretch">
                <!-- Contact Form -->
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                    <div class="contact-form-wrap p-4 p-md-5" style="background: #ffffff; border-radius: 20px; box-shadow: 0px 10px 40px rgba(0,0,0,0.05); height: 100%;">
                        <div class="section__title mb-30">
                            <span class="sub-title">Get in Touch
                                <strong class="shake">
                                    <img loading="lazy" src="assets/img/icon/pet_icon02.svg" alt="" class="injectable">
                                </strong>
                            </span>
                            <h2 class="title" style="font-size: 32px;">Send Us a Message</h2>
                        </div>

                        <?php if (!empty($message_status)): ?>
                            <div class="alert <?php echo $message_class; ?> alert-dismissible fade show mb-25" role="alert">
                                <?php echo htmlspecialchars($message_status); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form action="contact" method="POST">
                            <div class="form-grp mb-20">
                                <label for="name" class="fw-bold mb-1 text-dark" style="font-size: 14px;">Your Name *</label>
                                <input id="name" name="name" type="text" placeholder="Enter Full Name" required style="width: 100%; padding: 14px 20px; border-radius: 8px; border: 1px solid #EBEBEB; background: #fafafa; outline: none; font-size: 15px;">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-grp mb-20">
                                        <label for="email" class="fw-bold mb-1 text-dark" style="font-size: 14px;">Email Address</label>
                                        <input id="email" name="email" type="email" placeholder="Enter Email" style="width: 100%; padding: 14px 20px; border-radius: 8px; border: 1px solid #EBEBEB; background: #fafafa; outline: none; font-size: 15px;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-grp mb-20">
                                        <label for="phone" class="fw-bold mb-1 text-dark" style="font-size: 14px;">Phone Number *</label>
                                        <input id="phone" name="phone" type="tel" placeholder="Enter Phone" required style="width: 100%; padding: 14px 20px; border-radius: 8px; border: 1px solid #EBEBEB; background: #fafafa; outline: none; font-size: 15px;">
                                    </div>
                                </div>
                            </div>
                            <div class="form-grp mb-20">
                                <label for="subject" class="fw-bold mb-1 text-dark" style="font-size: 14px;">Subject</label>
                                <input id="subject" name="subject" type="text" placeholder="Subject" style="width: 100%; padding: 14px 20px; border-radius: 8px; border: 1px solid #EBEBEB; background: #fafafa; outline: none; font-size: 15px;">
                            </div>
                            <div class="form-grp mb-30">
                                <label for="message" class="fw-bold mb-1 text-dark" style="font-size: 14px;">Message *</label>
                                <textarea id="message" name="message" placeholder="Type your message here..." required style="width: 100%; height: 120px; resize: none; padding: 14px 20px; border-radius: 8px; border: 1px solid #EBEBEB; background: #fafafa; outline: none; font-size: 15px;"></textarea>
                            </div>
                            <div class="submit-btn-wrap">
                                <button type="submit" class="btn btn-registration" style="background-color: #ed1f31 !important; color: #ffffff !important; border: 2px solid #ed1f31 !important; padding: 14px 30px; border-radius: 8px; font-weight: 700; width: 100%; transition: all 0.3s ease;">
                                    Send Message <img loading="lazy" src="assets/img/icon/right_arrow.svg" alt="" class="injectable" style="margin-left: 8px; filter: brightness(0) invert(1);">
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Google Map Embed -->
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="map-wrap" style="border-radius: 20px; overflow: hidden; box-shadow: 0px 10px 40px rgba(0,0,0,0.05); height: 100%; min-height: 450px; border: 1px solid #ebebeb;">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3888.0042456425986!2d79.1378223!3d12.9715987!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bad38e61fa68ffb%3A0xbedda6917d4056bc!2sVIT%20ROAD%2C%20Vellore%20-%20Chennai%20Rd%2C%20Katpadi%2C%20Vellore%2C%20Tamil%20Nadu!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin" width="100%" height="100%" style="border:0; min-height: 450px; display: block;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- contact-form-map-area-end -->

</main>
<!-- main-area-end -->

<?php include 'footer.php'; ?>
