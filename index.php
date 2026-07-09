<?php
include "dashboard/conn.php"; // تأكد من المسار الصحيح للملف

// سجل الزيارة
$insertVisitor = mysqli_query($conn, "INSERT INTO site_visitors () VALUES ()");
?>

<?php
if (!isset($_GET['langID'])) {
    $lang = 'en';
} else {
    $lang = $_GET['langID'];
}


include('locale/' . $lang . '.php');
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'includes/head.php'; ?>



<body>

    <?php
    $activePage = 'home';
    include 'includes/navbar.php';
    ?>

    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5">
        <div id="blog-carousel" class="carousel slide overlay-bottom" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="img/casual1.jpg" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <h1 class="display-1 text-white m-0"><?php echo $langArray['carousel']['title']; ?></h1>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="w-100" src="img/casual2.png" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">

                        <h1 class="display-1 text-white m-0"><?php echo $langArray['carousel']['title']; ?></h1>

                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#blog-carousel" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#blog-carousel" data-slide="next">
                <span class="carousel-control-next-icon"></span>
            </a>
        </div>
    </div>
    <!-- Carousel End -->


    <!-- About Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h4 class="text-primary text-uppercase" style="letter-spacing: 5px; font-weight: 700;">
                    <?php echo $langArray['about']['title']; ?>
                </h4>
                <h1 class="display-4" style="color: #000; font-weight: 800;">
                    <?php echo $langArray['about']['subtitle']; ?>
                </h1>
            </div>
            <div class="row align-items-center">
                <!-- نص المكتبة -->
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 class="mb-3" style="color: #222; font-weight: 700;">
                        <?php echo $langArray['about']['heading']; ?>
                    </h2>
                    <p class="lead" style="color: #333; font-weight: 500;">
                        <?php echo $langArray['about']['description1']; ?>
                    </p>
                    <p style="color: #444; font-weight: 400;">
                        <?php echo $langArray['about']['description2']; ?>
                    </p>
                    <a href="about.php"
                        class="btn btn-primary font-weight-bold py-2 px-4 mt-3"><?php echo $langArray['about']['learn_more']; ?></a>
                </div>

                <!-- صورة المكتبة -->
                <div class="col-lg-6">
                    <div class="text-center">
                        <img src="img/R.jpg" alt="Library Image" class="img-fluid rounded shadow"
                            style="max-height: 400px; width: auto;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Service Start -->
    <div class="container-fluid pt-5">
        <div class="container">
            <div class="section-title">
                <h4 class="text-primary text-uppercase" style="letter-spacing: 5px;">
                    <?php echo $langArray['services']['title']; ?>
                </h4>
                <h1 class="display-4"><?php echo $langArray['services']['subtitle']; ?></h1>
            </div>
            <section id="section2">
                <div class="container">
                    <div class="row shapes">
                        <?php
                        // عرض فقط الخدمات التي تكون مفعلة للظهور في الصفحة الرئيسية
                        $sql = "SELECT * FROM service WHERE show_on_index = 1";
                        $services = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($services)) {
                            ?>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="row">
                                    <div class="col-md-12 minHeightProp">
                                        <img class="imgback"
                                            src="dashboard/getMajorServiceImg.php?img_id=<?php echo $row['service_id'] ?>"
                                            alt="">
                                    </div>
                                    <div class="col-md-12">
                                        <div class="text-center">
                                        <h4 class="txt"><?php echo $lang === 'ar' ? $row['service_name_ar'] : $row['service_name_en']; ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="col-md-12 text-center mt-4 ">
                           <a href="services.php?langID=<?php echo htmlspecialchars($lang); ?>" class="btn btn-primary btn-lg">
                            <?php echo $langArray['services']['view_all']; ?>
                           </a>

                        </div>
                    </div>
                </div>
        </div>
        </section>
    </div>
    </div>
    <!-- Service End -->

    <!-- Post start -->
    <div class="container-fluid pt-5">
        <div class="container">
            <div class="section-title text-center">
                <h4 class="text-primary text-uppercase" style="letter-spacing: 5px;">
                    <?php echo $langArray['posts']['title']; ?>
                </h4>
                <h1 class="display-4"><?php echo $langArray['posts']['subtitle']; ?></h1>
            </div>
            <div class="row">
                <?php
                // استعلام لاسترجاع المنشورات من قاعدة البيانات
                $sql = "SELECT * FROM posts ORDER BY post_date DESC LIMIT 3";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                  $post_title = $lang === 'ar' ? $row['post_title_ar'] : $row['post_title_en'];
                  $post_description = $lang === 'ar' ? $row['post_description_ar'] : $row['post_description_en'];
                  $post_image = $row['post_image']; // BLOB
                  $post_date = $row['post_date'];
                ?>
                <div class="col-md-4">
                <div class="card h-100 shadow-sm" style="border-radius: 16px; overflow: hidden;">
                  <img src="data:image/jpeg;base64,<?php echo base64_encode($post_image); ?>" class="card-img-top"
                    alt="Post Image" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($post_title); ?></h5>
                    <p class="card-text description" style="max-height: 100px; overflow: hidden;">
                        <?php echo htmlspecialchars($post_description); ?>
                    </p>
                    <button class="btn btn-link p-0 read-more-btn"><?php echo $langArray['posts']['read_more']; ?></button>
                    <p class="text-muted"><?php echo $langArray['posts']['posted_on']; ?> <?php echo $post_date; ?></p>
                 </div>
               </div>
             </div>
        <?php
    }
                } else {
                    // عرض رسالة بديلة إذا لم توجد منشورات
                    echo '<div class="col-12 text-center">';
                    echo '<div class="no-posts">';
                    echo '<img src="img/no-posts.png" alt="No Posts Available" class="img-fluid mb-3">';
                    echo '<h3 class="text-muted">No posts available at the moment.</h3>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>
    <!-- Post End -->

    <!-- Motivational Quotes Section Start-->
    <div class="container-fluid pt-5">
        <div class="container text-center">
            <div class="section-title">
                <h4 class="text-primary text-uppercase" style="letter-spacing: 5px;">
                    <?php echo $langArray['quotes']['title']; ?>
                </h4>
                <h1 class="display-4"><?php echo $langArray['quotes']['subtitle']; ?></h1>
            </div>

            <?php
            $quotes = mysqli_query($conn, "SELECT * FROM quotes ORDER BY quote_id DESC LIMIT 6");
            if (mysqli_num_rows($quotes) > 0) {
                ?>
                <div id="quoteCarousel" class="carousel slide" data-ride="carousel" data-interval="5000">
                    <div class="carousel-inner">
                        <?php
                        $active = true;
                        while ($quote = mysqli_fetch_array($quotes)) {
                            ?>
                            <div class="carousel-item<?php echo $active ? ' active' : ''; ?>">
                            <h3>
                             "<?php echo $lang === 'ar' ? htmlspecialchars($quote['quote_text_ar']) : htmlspecialchars($quote['quote_text_en']); ?>"
                           - <?php echo $lang === 'ar' ? htmlspecialchars($quote['quote_author_ar']) : htmlspecialchars($quote['quote_author_en']); ?>
                            </h3>

                            </div>
                            <?php
                            $active = false;
                        }
                        ?>
                    </div>
                    <a class="carousel-control-prev" href="#quoteCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </a>
                    <a class="carousel-control-next" href="#quoteCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </a>
                </div>
                <?php
            } else {
                echo '<p class="text-muted">No quotes available at the moment.</p>';
            }
            ?>
        </div>
    </div>
    <!-- Motivational Quotes Section End-->


   <!-- Category Start -->
   <div class="container-fluid pt-5">
    <div class="container">
        <div class="section-title">
            <h4 class="text-primary text-uppercase" style="letter-spacing: 5px;">
                <?php echo $langArray['categories']['title']; ?>
            </h4>
            <h1 class="display-4"><?php echo $langArray['categories']['subtitle']; ?></h1>
        </div>

        <section id="section2">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="maintext text-center">
                            <!-- Optional text or intro for the categories -->
                        </div>
                    </div>
                </div>
                <div class="row shapes">
                    <?php
                    // تعديل الاستعلام ليشمل الفئات التي is_visible = 1
                    $allCat = mysqli_query($conn, "SELECT `cat_id`, `cat_name_ar`, `cat_name_en`, `img` FROM `category` WHERE `is_visible` = 1 ORDER BY `cat_id` DESC");
                    while ($row = mysqli_fetch_array($allCat)) {
                        ?>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="row">
                                <div class="col-md-12 minHeightProp">
                                    <img class="imgbackk"
                                        src="dashboard/getMajorCatImg.php?img_id=<?php echo $row['cat_id'] ?>" alt="">
                                </div>
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <h3 class="txt">
                                            <a href="category.php?category_id=<?php echo $row['cat_id']; ?>&langID=<?php echo htmlspecialchars($lang); ?>">
                                                <?php echo $lang === 'ar' ? $row['cat_name_ar'] : $row['cat_name_en']; ?>
                                            </a>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="col-md-12 text-center mt-4">
                        <a href="categories.php?langID=<?php echo htmlspecialchars($lang); ?>"
                            class="btn btn-primary btn-lg"><?php echo $langArray['categories']['view_all']; ?></a>
                    </div>
                </div>
            </div>
        </section>
    </div>
   </div>
   <!-- Category End -->


    <!-- Donation Section Start-->
    <div id="donation" class="container-fluid pt-3 pb-3" style="background-color: #f9f9f9;">
        <div class="container">
            <div class="section-title text-center mb-3">
                <h4 class="text-primary text-uppercase" style="letter-spacing: 5px;">
                    <?php echo $langArray['donation']['title']; ?>
                </h4>
                <h1 class="display-4">
                    <i class="fas fa-hand-holding-heart text-danger"></i>
                    <?php echo $langArray['donation']['subtitle']; ?>
                </h1>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-lg p-3 text-center" style="border: 2px dashed #ff6b6b; background: #fff;">
                        <img src="img/Donation.jpg" alt="Donate to University Library" class="img-fluid mb-3"
                            style="max-width: 300px; height: auto; margin: 0 auto;">
                        <p class="mb-3" style="font-size: 16px; font-weight: 500; color: #555;">
                            <?php echo $langArray['donation']['description']; ?>
                            <br>
                        </p>
                        <a href="https://iugaza.ensany.com/campaign/7102?lang=en" class="btn btn-danger" target="_self"
                            style="width: 100%; padding: 10px 0; font-size: 16px;">
                            <i class="fas fa-donate"></i> <?php echo $langArray['donation']['donate_now']; ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Donation Section End-->


    <?php
    include 'includes/footer.php';
    ?>



    <script>

        document.querySelectorAll('.read-more-btn').forEach(function (button) {
            button.addEventListener('click', function () {
                const text = this.previousElementSibling;
                if (text.style.maxHeight === 'none') {
                    text.style.maxHeight = '100px';
                    this.textContent = 'Read more';
                } else {
                    text.style.maxHeight = 'none';
                    this.textContent = 'Read less';
                }
            });
        });

    </script>

    