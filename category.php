<?php
include 'connect.php';
$lang = isset($_GET['langID']) ? $_GET['langID'] : 'en';

$category = @$_GET['category_id'];
if (!$category) {
    echo $langArray['category_page']['not_found'] ?? 'Category not found.';
    die();
} else {
    $category_info = mysqli_query($conn, "SELECT * FROM `category` WHERE `cat_id` = '$category' LIMIT 1");
    $cat_info = mysqli_fetch_array($category_info);
    $category_name = $lang === 'ar' ? $cat_info['cat_name_ar'] : $cat_info['cat_name_en'];

    $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
    if ($search != '') {
        $items = mysqli_query($conn, "SELECT * FROM `items` WHERE `item_sub_cat` = '$category' AND (`item_name` LIKE '%$search%' OR `item_author` LIKE '%$search%') ORDER BY `item_id` DESC");
    } else {
        $items = mysqli_query($conn, "SELECT * FROM `items` WHERE `item_sub_cat` = '$category' ORDER BY `item_id` DESC");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<?php
include 'includes/head.php';
?>

<body>
    <?php
    $activePage = 'categories';
    include 'includes/navbar.php';
    ?>


    <?php
    $title = $category_name;
    include 'includes/header.php';
    ?>


    <!-- Book Search + List -->
    <div class="container">

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

        <!-- Book Results -->
        <div class="row">
            <?php if (mysqli_num_rows($items) > 0) { ?>
                <?php while ($row = mysqli_fetch_array($items)) { ?>
                    <div class="col-md-4 mb-4">
                        <div class="card book-card h-100 shadow-sm">
                            <a href="book.php?item_id=<?= $row['item_id']; ?>&langID=<?= $lang ?>">
                                <img src="dashboard/<?php echo $row['item_img']; ?>" class="card-img-top book-image"
                                    alt="<?php echo $row['item_name']; ?>">
                            </a>
                            <div class="card-body text-center">
                                <div class="book-title"><?php echo $row['item_name']; ?></div>
                                <div class="book-author">Author: <?php echo $row['item_author']; ?></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="col-12 text-center">
                    <h5 class="text-muted">No books found matching your search.</h5>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php
    include 'includes/footer.php';
    ?>

</body>

</html>