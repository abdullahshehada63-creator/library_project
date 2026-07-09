<?php
include 'connect.php';

$search = @$_GET['search'];
if (!$search) {
    //  إذا لم يتم إدخال أي مصطلح بحث، قم بعرض الكتب المقترحة

    $sql = "SELECT * FROM `items` ORDER BY `item_id` DESC LIMIT 10";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        die();
    }
} else {
    // استخدام prepared statement لتجنب SQL Injection
    $stmt = mysqli_prepare($conn, "SELECT * FROM `items` WHERE `item_name` LIKE ? ORDER BY `item_id` DESC");
    $searchTerm = "%" . $search . "%";
    mysqli_stmt_bind_param($stmt, "s", $searchTerm);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // إضافة تعليق إذا تم إرساله
    if (isset($_POST['comment'])) {
        if (!empty($_POST['comment_text'])) {
            $item_id = $_POST['item_id'];
            $comment_text = $_POST['comment_text'];
            $sql = "INSERT INTO comments (product_id, comment) VALUES ('$item_id', '$comment_text')";
            if (mysqli_query($conn, $sql) === TRUE) {
                echo "Comment added";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">


<?php
include "includes/head.php";
?>


<head>
    <style>

    </style>
</head>

<body>

    <?php
    $activePage = 'home';
    include 'includes/navbar.php';
    ?>

    <?php
    $title = 'Search Results';
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
                <form action="search.php" method="get">
                    <div class="search-container ml-auto">
                        <form action="search.php" method="get" class="search-form">
                            <div class="input-group">
                                <input type="hidden" name="langID" value="<?= $lang ?>" />
                                <input type="text" class="form-control search-input"
                                    placeholder="<?php echo $langArray['search_page']['search_section']['placeholder']; ?>"
                                    name="search" aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-search bg-black" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                        </form>
                    </div>
            </div>
            </form>
        </div>
        </div>
    </section>
    <!-- Search Section End -->

    <!-- Menu Section Start -->
    <section class="menu" id="menu">
        <h1 class="heading"><?php echo $langArray['search_page']['results_section']['title']; ?></h1>
        <div class="books-container">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    ?>
                    <div class="book-card">
                        <?php if (!empty($row['item_img'])): ?>
                            <div class="book-image">
                                <img src="dashboard/<?= htmlspecialchars($row['item_img'] ?? '') ?>"
                                    alt="<?= htmlspecialchars($row['item_name'] ?? 'Book Cover') ?>">
                            </div>
                        <?php endif; ?>

                        <div class="book-info">
                            <a href="book.php?item_id=<?= $row['item_id'] ?>&langID=<?= $lang ?>" class="">
                                <h3 class="book-title"><?= htmlspecialchars($row['item_name'] ?? 'Untitled Book') ?>
                            </a>
                            </h3>
                            <p class="book-author"><?= $langArray['books_page']['by'] ?>:
                                <?= htmlspecialchars($row['item_author'] ?? 'Unknown Author') ?>
                            </p>
                            <p class="book-description">
                                <?= nl2br(htmlspecialchars($row['item_Description'] ?? 'No description available')) ?>
                            </p>

                            <div class="book-actions">
                                <?php if (!empty($row['item_file'])): ?>
                                    <a href="<?php echo 'dashboard/' . $row['item_file']; ?>" target="_blank" class="btn btn-xs"
                                        style="background-color:  #33211D; color: white;">
                                        <?= $langArray['book_page']['book_details']['view_download'] ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<div class="no-results" style="text-align: center; width: 100%; padding: 40px; background: #f9f9f9; border-radius: 8px; margin: 20px 0;">';
                echo '<i class="fas fa-book-open" style="font-size: 48px; color: #ccc; margin-bottom: 15px;"></i>';
                echo '<h3 style="color: #555;">No books found</h3>';
                echo '<p style="color: #777;">We couldn\'t find any books matching your search</p>';
                echo '</div>';
            }
            ?>
        </div>

    </section>
    <!-- Menu Section End -->

    <?php
    include 'includes/footer.php';
    ?>

    <script src="plugin.js"></script>
</body>

</html>

<?php
// إغلاق الاتصال بقاعدة البيانات
mysqli_close($conn);
?>