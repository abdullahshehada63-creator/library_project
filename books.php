<?php
session_start();
include "dashboard/conn.php";

$stmt = $conn->prepare("SELECT * FROM items");
$stmt->execute();
$result = $stmt->get_result();
$items = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

if (empty($items)) {
  echo "<div style='color: red; font-weight: bold; text-align: center; margin: 20px;'>No books found!</div>";
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'includes/head.php'; ?>

<head>
  <link rel="stylesheet" href="css/books.css">
</head>

<body>

  <?php
  $activePage = 'home';
  include 'includes/navbar.php';
  ?>

  <?php
  $title = 'Books';
  include 'includes/header.php';
  ?>

  <h1 class="page-title"></h1>


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
                  placeholder="<?php echo $langArray['search_page']['search_section']['placeholder']; ?>" name="search"
                  aria-label="Search">
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

   <!-- Books Section Start -->
  <div class="books-container">
    <?php foreach ($items as $item): ?>
      <div class="book-card">
        <?php if (!empty($item['item_img'])): ?>
          <div class="book-image">
            <img src="dashboard/<?= htmlspecialchars($item['item_img'] ?? '') ?>"
              alt="<?= htmlspecialchars($item['item_name'] ?? 'Book Cover') ?>">
          </div>
        <?php endif; ?>

        <div class="book-info">
          <a href="book.php?item_id=<?= $item['item_id'] ?>&langID=<?= $lang ?>" class="">
            <h3 class="book-title"><?= htmlspecialchars($item['item_name'] ?? 'Untitled Book') ?>
          </a>
          </h3>
          <p class="book-author"><?= $langArray['books_page']['by'] ?>:
            <?= htmlspecialchars($item['item_author'] ?? 'Unknown Author') ?>
          </p>
          <p class="book-description">
            <?= nl2br(htmlspecialchars($item['item_Description'] ?? 'No description available')) ?>
          </p>

          <div class="book-actions">
            <?php if (!empty($item['item_file'])): ?>
              <a href="<?php echo 'dashboard/' . $item['item_file']; ?>" target="_blank" class="btn btn-xs"
                style="background-color:  #33211D; color: white;">
                <?= $langArray['book_page']['book_details']['view_download'] ?>
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <?php
  include 'includes/footer.php';
  ?>

</body>

</html>