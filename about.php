<!DOCTYPE html>
<html lang="en">

<?php
// تعيين اللغة حسب الرابط أو استخدام "en" كلغة افتراضية
$lang = isset($_GET['langID']) ? $_GET['langID'] : 'en';
?>

<?php include 'includes/head.php'; ?>

<body>
    <?php
    $activePage = 'about';
    include 'includes/navbar.php';
    ?>

    <?php
    $title = 'About';
    include 'includes/header.php';
    ?>

    <!-- About Section -->
    <section class="container-fluid py-5 bg-light" id="about" style="max-width: 90%;">
        <div class="text-center mb-5">
            <h2 class="mb-3"><?php echo $langArray['about_page']['about_section']['title']; ?></h2>
            <p class="lead mx-auto text-center" style="max-width: 900px;">
                <?php echo $langArray['about_page']['about_section']['description']; ?>
            </p>
        </div>
        <div class="row align-items-center px-4">
            <div class="col-12 col-lg-6 mb-4">
                <p><?php echo $langArray['about_page']['about_section']['stats']['title']; ?></p>
                <ul>
                    <li><?php echo $langArray['about_page']['about_section']['stats']['items'][0]; ?></li>
                    <li><?php echo $langArray['about_page']['about_section']['stats']['items'][1]; ?></li>
                    <li><?php echo $langArray['about_page']['about_section']['stats']['items'][2]; ?></li>
                    <li><?php echo $langArray['about_page']['about_section']['stats']['items'][3]; ?></li>
                    <li><?php echo $langArray['about_page']['about_section']['stats']['items'][4]; ?></li>
                </ul>
                <p><?php echo $langArray['about_page']['about_section']['management']; ?></p>
                <p><?php echo $langArray['about_page']['about_section']['mission']; ?></p>
            </div>
            <div class="col-12 col-lg-6 text-center">
                <img src="img/R.jpg" class="img-fluid rounded shadow-sm w-100" alt="IUG Library"
                    style="max-height: 400px; object-fit: cover;">
            </div>
        </div>
    </section>

    <!-- Goals Section -->
    <section class="container-fluid py-5" id="goals" style="max-width: 90%;">
        <h2 class="text-center mb-4"><?php echo $langArray['about_page']['goals_section']['title']; ?></h2>
        <div class="row text-center px-4">
            <div class="col-md-4 mb-4">
                <i class="fas fa-book-reader fa-3x mb-3 text-primary"></i>
                <h5><?php echo $langArray['about_page']['goals_section']['goals'][0]['title']; ?></h5>
                <p><?php echo $langArray['about_page']['goals_section']['goals'][0]['description']; ?></p>
            </div>
            <div class="col-md-4 mb-4">
                <i class="fas fa-laptop fa-3x mb-3 text-primary"></i>
                <h5><?php echo $langArray['about_page']['goals_section']['goals'][1]['title']; ?></h5>
                <p><?php echo $langArray['about_page']['goals_section']['goals'][1]['description']; ?></p>
            </div>
            <div class="col-md-4 mb-4">
                <i class="fas fa-users fa-3x mb-3 text-primary"></i>
                <h5><?php echo $langArray['about_page']['goals_section']['goals'][2]['title']; ?></h5>
                <p><?php echo $langArray['about_page']['goals_section']['goals'][2]['description']; ?></p>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="container py-5" id="team" style="max-width: 90%;">
        <h2 class="text-center mb-4"><?php echo $langArray['about_page']['team_section']['title']; ?></h2>
        <div class="row justify-content-center">
            <div class="col-md-4 mb-4">
                <div class="card text-center">
                    <img src="img/team1.jpg" class="card-img-top" alt="Dr. Mamdouh Khader Farwana">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php echo $langArray['about_page']['team_section']['members'][0]['name']; ?></h5>
                        <p class="card-text">
                            <?php echo $langArray['about_page']['team_section']['members'][0]['position']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-center">
                    <img src="img/team2.jpg" class="card-img-top" alt="Ibrahim Al-Kurd">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php echo $langArray['about_page']['team_section']['members'][1]['name']; ?></h5>
                        <p class="card-text">
                            <?php echo $langArray['about_page']['team_section']['members'][1]['position']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-center">
                    <img src="img/team3.png" class="card-img-top" alt="Hani Al-Sous">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php echo $langArray['about_page']['team_section']['members'][2]['name']; ?></h5>
                        <p class="card-text">
                            <?php echo $langArray['about_page']['team_section']['members'][2]['position']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <?php
    include 'includes/footer.php';
    ?>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>