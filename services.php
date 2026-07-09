<?php
$lang = isset($_GET['langID']) ? $_GET['langID'] : 'en';
include('locale/' . $lang . '.php');
?>



<?php
include 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">

<?php include 'includes/head.php'; ?>


<body>

    <?php
    $activePage = 'services';
    include 'includes/navbar.php';
    ?>

    <?php
    $title = 'Services';
    include 'includes/header.php';
    ?>

    <!-- Main Welcome Message Start -->
    <div class="container-fluid text-center py-5">
        <h1 class="display-4 font-weight-bold" style="color:rgb(81, 54, 37);">
            <?php echo $langArray['services_page']['welcome']['title']; ?>
        </h1>
        <p class="lead mt-3" style="font-size: 20px; color: #333;">
            <?php echo $langArray['services_page']['welcome']['subtitle']; ?>
        </p>
    </div>
    <!-- Main Welcome Message End -->

    <!-- Crisis Services Section Start -->
    <section id="crisis-services" style="background:rgb(239, 243, 249); padding: 40px 20px;">
        <div class="container">
            <h2 class="text-center mb-4" style="color:#003366;"><i class="fas fa-exclamation-circle"></i>
                <?php echo $langArray['services_page']['crisis_services']['title']; ?></h2>
            <p class="text-center mb-4" style="font-size: 18px;">
                <?php echo $langArray['services_page']['crisis_services']['description']; ?>
            </p>
            <div class="row">
                <div class="col-md-6">
                    <ul style="font-size: 16px;">
                        <li>📘 <?php echo $langArray['services_page']['crisis_services']['items'][0]; ?></li>
                        <li>✉️ <a
                                href="contact.php?langID=<?php echo $lang; ?>"><?php echo $langArray['services_page']['crisis_services']['items'][1]; ?></a>.
                        </li>
                        <li>📚 <?php echo $langArray['services_page']['crisis_services']['items'][2]; ?></li>
                    </ul>
                </div>
                <div class="col-md-6 text-center">
                    <a href="books.php?langID=<?php echo $lang; ?>" class="btn btn-primary px-4 py-2">📥
                        <?php echo $langArray['services_page']['crisis_services']['browse_button']; ?></a>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- Crisis Services Section End -->

  <!-- Service Start -->
<section id="section2">
    <div class="container">
        <div class="row shapes">
            <?php
            $sql = "SELECT * FROM `service`";
            $services = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($services)) {
                // اختيار اسم الخدمة بناءً على اللغة
                $serviceName = $lang === 'ar' && !empty($row['service_name_ar']) ? $row['service_name_ar'] : $row['service_name_en'];
            ?>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="row">
                        <div class="col-md-12 minHeightProp">
                            <img class="imgback"
                                src="dashboard/getMajorServiceImg.php?img_id=<?php echo $row['service_id'] ?>" alt="">
                        </div>
                        <div class="col-md-12">
                            <div class="text-center">
                                <h4 class="txt"><?php echo $serviceName; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</section>
<!-- Service End -->



    <!-- Useful Links Section Start -->
    <section id="useful-links" style="background-color: #f4f6f9; padding: 40px 20px;">
        <div class="container">
            <h2 class="text-center mb-4" style="color: #003366;"><i class="fas fa-link"></i>
                <?php echo $langArray['services_page']['useful_links']['title']; ?></h2>
            </h2>
            <div class="row">
                <div class="col-md-3 col-sm-6 mb-3 text-center">
                    <a href="https://sportal.iugaza.edu.ps/ords/f?p=147:LOGIN_DESKTOP:13379637589281:::::"
                        target="_blank" class="btn btn-outline-primary w-100 py-3">
                        <i class="fas fa-user-graduate fa-2x mb-2"></i><br>
                        <?php echo $langArray['services_page']['useful_links']['links'][0]['title']; ?>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6 mb-3 text-center">
                    <a href="mailto:public@iugaza.edu.ps" target="_blank" class="btn btn-outline-primary w-100 py-3">
                        <i class="fas fa-envelope fa-2x mb-2"></i><br>
                        <?php echo $langArray['services_page']['useful_links']['links'][1]['title']; ?>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6 mb-3 text-center">
                    <a href="https://lectures.iugaza.edu.ps/" target="_blank"
                        class="btn btn-outline-primary w-100 py-3">
                        <i class="fas fa-laptop fa-2x mb-2"></i><br>
                        <?php echo $langArray['services_page']['useful_links']['links'][2]['title']; ?>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6 mb-3 text-center">
                    <a href="https://iugaza.ensany.com/campaign/7102?lang=en" target="_blank" class="btn btn-outline-primary w-100 py-3">
                        <i class="fas fa-credit-card fa-2x mb-2"></i><br>
                        <?php echo $langArray['services_page']['useful_links']['links'][3]['title']; ?>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6 mb-3 text-center">
                    <a href="https://moodle.iugaza.edu.ps/my/" target="_blank"
                        class="btn btn-outline-primary w-100 py-3">
                        <i class="fas fa-book fa-2x mb-2"></i><br>
                        <?php echo $langArray['services_page']['useful_links']['links'][4]['title']; ?>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6 mb-3 text-center">
                    <a href="https://newstd.iugaza.edu.ps/%d8%a7%d8%ac%d8%b1%d8%a7%d8%a1%d8%a7%d8%aa-%d8%a7%d9%84%d8%aa%d8%b3%d8%ac%d9%8a%d9%84/" target="_blank"
                        class="btn btn-outline-primary w-100 py-3">
                        <i class="fas fa-edit fa-2x mb-2"></i><br>
                        <?php echo $langArray['services_page']['useful_links']['links'][5]['title']; ?>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6 mb-3 text-center">
                    <a href="https://support.iugaza.edu.ps/ords/f?p=133:LOGIN_DESKTOP:16442569384909:::::" target="_blank" class="btn btn-outline-primary w-100 py-3">
                        <i class="fas fa-info-circle fa-2x mb-2"></i><br>
                        <?php echo $langArray['services_page']['useful_links']['links'][6]['title']; ?>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- Useful Links Section End -->

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
</body>

</html>