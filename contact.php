<!DOCTYPE html>
<html lang="en">

<?php
// تعيين اللغة حسب الرابط أو استخدام "en" كلغة افتراضية
$lang = isset($_GET['langID']) ? $_GET['langID'] : 'en';
?>

<?php include 'includes/head.php'; ?>


<body>

    <?php
    $activePage = 'contact';
    include 'includes/navbar.php';
    ?>



    <?php
    $title = 'Contact';
    include 'includes/header.php';
    ?>


    <!-- Contact Start -->
    <div class="container-fluid pt-5">
        <div class="container">
            <div class="section-title">
                <h4 class="text-primary text-uppercase" style="letter-spacing: 5px;">
                    <?php echo $langArray['contact_page']['section_title']['subtitle']; ?>
                </h4>
                <h1 class="display-4"><?php echo $langArray['contact_page']['section_title']['title']; ?></h1>
            </div>
            <div class="row px-3 pb-2">
                <div class="col-sm-4 text-center mb-3">
                    <i class="fa fa-2x fa-map-marker-alt mb-3 text-primary"></i>
                    <h4 class="font-weight-bold">
                        <?php echo $langArray['contact_page']['contact_info']['address']['title']; ?>
                    </h4>
                    <p><?php echo $langArray['contact_page']['contact_info']['address']['content']; ?></p>
                </div>
                <div class="col-sm-4 text-center mb-3">
                    <i class="fa fa-2x fa-phone-alt mb-3 text-primary"></i>
                    <h4 class="font-weight-bold">
                        <?php echo $langArray['contact_page']['contact_info']['phone']['title']; ?>
                    </h4>
                    <p><?php echo $langArray['contact_page']['contact_info']['phone']['content']; ?></p>
                </div>
                <div class="col-sm-4 text-center mb-3">
                    <i class="far fa-2x fa-envelope mb-3 text-primary"></i>
                    <h4 class="font-weight-bold">
                        <?php echo $langArray['contact_page']['contact_info']['email']['title']; ?>
                    </h4>
                    <p><?php echo $langArray['contact_page']['contact_info']['email']['content']; ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 pb-5">
                    <!-- Updated iframe for Google Maps link -->
                    <iframe style="width: 100%; height: 443px; border:0;" 
                     src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3401.403315939283!2d34.44342192467606!3d31.5130809742173!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14fd7fe4eea37a45%3A0x2f4dd6e9eaea1466!2z2KfZhNmF2YPYqtio2Kkg2KfZhNmF2LHZg9iy2YrYqQ!5e0!3m2!1sar!2s!4v1750241949380!5m2!1sar!2s" 
                     allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>

                </div>
                <div class="col-md-6 pb-5">
                    <div class="contact-form">
                        <div id="success"></div>
                        <form name="sentMessage" id="contactForm" action="contact.php" method="POST"
                            novalidate="novalidate">
                            <div class="control-group">
                                <input type="text" class="form-control bg-transparent p-4" id="name" name="name"
                                    placeholder="<?php echo $langArray['contact_page']['contact_form']['name_placeholder']; ?>"
                                    required="required"
                                    data-validation-required-message="<?php echo $langArray['contact_page']['contact_form']['name_validation']; ?>" />
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="control-group">
                                <input type="email" class="form-control bg-transparent p-4" id="email" name="email"
                                    placeholder="<?php echo $langArray['contact_page']['contact_form']['email_placeholder']; ?>"
                                    required="required"
                                    data-validation-required-message="<?php echo $langArray['contact_page']['contact_form']['email_validation']; ?>" />
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="control-group">
                                <input type="text" class="form-control bg-transparent p-4" id="subject" name="subject"
                                    placeholder="<?php echo $langArray['contact_page']['contact_form']['subject_placeholder']; ?>"
                                    required="required"
                                    data-validation-required-message="<?php echo $langArray['contact_page']['contact_form']['subject_validation']; ?>" />
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="control-group">
                                <textarea class="form-control bg-transparent py-3 px-4" rows="5" id="message"
                                    name="message"
                                    placeholder="<?php echo $langArray['contact_page']['contact_form']['message_placeholder']; ?>"
                                    required="required"
                                    data-validation-required-message="<?php echo $langArray['contact_page']['contact_form']['message_validation']; ?>"></textarea>
                                <p class="help-block text-danger"></p>
                            </div>
                            <div>
                                <button class="btn btn-primary font-weight-bold py-3 px-5" type="submit"
                                    id="sendMessageButton"><?php echo $langArray['contact_page']['contact_form']['submit_button']; ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

    <?php
    include 'includes/footer.php';
    ?>

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>