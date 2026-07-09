<?php
include 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">

<?php
// تعيين اللغة حسب الرابط أو استخدام "en" كلغة افتراضية
$lang = isset($_GET['langID']) ? $_GET['langID'] : 'en';
?>

<?php include 'includes/head.php'; ?>

<head>
    <link rel="stylesheet" href="css/categories.css">
</head>

<body>
    <?php
    $activePage = 'categories';
    include 'includes/navbar.php';
    ?>

    <?php
    $title = 'Categories';
    include 'includes/header.php';
    ?>

<!-- Search Section Start -->
<section id="search-section" style="padding: 60px 0;">
  <div class="container">
    <div class="search-box-wrapper text-center p-5 shadow-lg rounded bg-white"
         style="max-width: 800px; margin: auto; border: 1px solid #ccc;">
      <h2 class="mb-4 font-weight-bold" style="font-size: 30px; color: #333;">
        <?php echo $langArray['search_page']['search_section']['title']; ?>
      </h2>

      <!-- Start of search form -->
      <form action="search.php" method="get" class="search-form">
        <input type="hidden" name="langID" value="<?= $lang ?>" />
        <div class="input-group shadow-sm" style="border: 1px solid #ccc; border-radius: 4px; overflow: hidden;">
          <input type="text" class="form-control" name="search"
            placeholder="<?php echo $langArray['search_page']['search_section']['placeholder']; ?>"
            aria-label="Search"
            style="border: none; box-shadow: none;">
          <div class="input-group-append">
            <button class="btn btn-light" type="submit" style="border-left: 1px solid #ccc;">
              <i class="fas fa-search text-muted"></i>
            </button>
          </div>
        </div>
      </form>
      <!-- End of search form -->

    </div>
  </div>
</section>

    <!-- Category Section Start -->
    <section id="categories-section" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5 section-title"><?php echo $langArray['categories_page']['browse_categories']; ?>
            </h2>
            <div class="row">
                <?php
               $allCat = mysqli_query($conn, "SELECT `cat_id`, `cat_name_ar`, `cat_name_en`, `img` FROM `category` ORDER BY `cat_id` DESC");
                while ($row = mysqli_fetch_array($allCat)) {
                    $imagePath = "dashboard/getMajorCatImg.php?img_id=" . $row['cat_id'];
                    ?>
                    <div class="col-6 col-md-4 col-lg-3 mb-4">
                        <div class="category-card card h-100 border-0 shadow-sm">
                            <div class="card-img-top">
                            <img src="<?php echo $imagePath ?>" alt="<?php echo $lang === 'ar' ? $row['cat_name_ar'] : $row['cat_name_en']; ?>" class="img-fluid">
                            </div>
                            <div class="card-body text-center">
                                <a href="category.php?category_id=<?php echo $row['cat_id']; ?>&langID=<?php echo $lang; ?>"
                                    class="stretched-link category-link">
                                    <?php echo $lang === 'ar' ? $row['cat_name_ar'] : $row['cat_name_en']; ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- Category Section End -->

    <?php
    include 'includes/footer.php';
    ?>
</body>

</html>