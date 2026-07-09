<?php

session_start();
include "dashboard/conn.php";

// Sanitize and validate item_id from GET
$item_id = isset($_GET['item_id']) ? (int) $_GET['item_id'] : 0;

$stmt = $conn->prepare("SELECT * FROM items WHERE item_id = ?");
$stmt->bind_param("i", $item_id);
$stmt->execute();
$result = $stmt->get_result();
$items = $result->fetch_assoc();

if (!$items) {
  echo "<div style='color: red; font-weight: bold;'>" . ($langArray['book_page']['not_found'] ?? 'Item not found!') . "</div>";
  exit;
}

// معالجة إرسال التعليقات
if (isset($_POST['comment'])) {
  $comment_text = $_POST['comment_text'] ?? '';

  // التحقق من أن التعليق غير فارغ
  if (!empty($comment_text)) {
    // إدخال التعليق في قاعدة البيانات
    $stmt = $conn->prepare("INSERT INTO comments (product_id, comment) VALUES (?, ?)");
    $stmt->bind_param("is", $item_id, $comment_text);

    if ($stmt->execute()) {
      echo "<div class='alert alert-success'>" . ($langArray['book_page']['comment_form']['success'] ?? 'Comment added successfully!') . "</div>";
    } else {
      echo "<div class='alert alert-danger'>" . ($langArray['book_page']['comment_form']['fail'] ?? 'Failed to add comment. Please try again later.') . "</div>";
    }
  } else {
    echo "<div class='alert alert-warning'>" . ($langArray['book_page']['comment_form']['empty'] ?? 'Please enter a comment.') . "</div>";
  }
}

// جلب التعليقات الخاصة بالكتاب
$stmt = $conn->prepare("SELECT * FROM comments WHERE product_id = ? ORDER BY product_id DESC");
$stmt->bind_param("i", $item_id);
$stmt->execute();
$comments_result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang ?? 'en') ?>">

<?php include 'includes/head.php'; ?>

<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($items['item_name']) ?></title>
  <link rel="stylesheet" href="css/book.css">

</head>

<body>

  <?php
  $activePage = 'home';
  include 'includes/navbar.php';
  ?>

  <?php
  $title = $langArray['book_page']['title'] ?? 'Book';
  include 'includes/header.php';
  ?>

  <div class="main-container">
    <div class="book-container">
      <div class="book-image">
        <img src="dashboard/<?= htmlspecialchars($items['item_img']) ?>"
          alt="<?= htmlspecialchars($items['item_name']) ?>">
      </div>
      <div class="book-details">
        <h1><?= htmlspecialchars($items['item_name']) ?></h1>
        <p class="author"><?= $langArray['book_page']['author'] ?? 'Author' ?>: <?= htmlspecialchars($items['item_author']) ?></p>
        <p class="description"><?= nl2br(htmlspecialchars($items['item_Description'])) ?></p>
      </div>
    </div>

    <!-- PDF Viewer -->
    <!-- <iframe class="pdf-view"
      src="dashboard/books/<?= urlencode($items['item_file']) ?>"></iframe> -->

    <!-- Buttons -->
    <?php if (!empty($items['item_file'])): ?>
      <div class="book-meta">
        <strong><?= $langArray['book_page']['book_details']['file'] ?? 'File' ?>:</strong>
        <a href="<?php echo 'dashboard/' . $items['item_file']; ?>" target="_blank" class="btn btn-xs"
          style="background-color:  #33211D; color: white;">
          <?= $langArray['book_page']['book_details']['view_download'] ?? 'View / Download' ?>
        </a>
      </div>
    <?php endif; ?>

    <!-- Comment Form -->
    <div class="comment-form">
      <form action="" method="post">
        <textarea name="comment_text"
          placeholder="<?= $langArray['book_page']['comment_form']['placeholder'] ?? 'Enter your comment here...' ?>"></textarea><br>
        <input type="hidden" name="item_id" value="<?= htmlspecialchars($items['item_id']) ?>">
        <input type="submit" name="comment" value="<?= $langArray['book_page']['comment_form']['button'] ?? 'Add Comment' ?>">
      </form>
    </div>

    <!-- Display Comments -->
    <div class="comments-list">
      <?php while ($comment = $comments_result->fetch_assoc()) { ?>
        <div class="comment-item">
          <p><strong><?= $langArray['search_page']['results_section']['comment_button'] ?? 'Comment' ?>:</strong>
            <?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
        </div>
      <?php } ?>
    </div>
  </div>

  <!-- Suggested Books Section -->
  <div class="suggested-books">
    <h2><?= $langArray['book_page']['suggested_books']['title'] ?? 'Suggested Books' ?></h2>
    <div class="book-grid">
      <?php
      // Get suggested books (same author or same category)
      $suggested_query = $conn->prepare("
            SELECT * FROM items 
            WHERE (item_author = ? OR item_sub_cat = ?) 
            AND item_id != ?
            LIMIT 8
        ");
      $suggested_query->bind_param("ssi", $items['item_author'], $items['item_sub_cat'], $item_id);
      $suggested_query->execute();
      $suggested_result = $suggested_query->get_result();

      if ($suggested_result->num_rows > 0) {
        while ($suggested_book = $suggested_result->fetch_assoc()) {
          echo '
                <div class="book-card">
                    <a href="book.php?langID=' . htmlspecialchars($lang) . '&item_id=' . $suggested_book['item_id'] . '">
                        <img src="dashboard/' . htmlspecialchars($suggested_book['item_img']) . '" alt="' . htmlspecialchars($suggested_book['item_name']) . '">
                        <h3>' . htmlspecialchars($suggested_book['item_name']) . '</h3>
                        <p>' . htmlspecialchars($suggested_book['item_author']) . '</p>
                    </a>
                </div>';
        }
      } else {
        echo '<p style="text-align:center;">' . ($langArray['book_page']['suggested_books']['no_books'] ?? 'No suggested books found') . '</p>';
      }
      ?>
    </div>
  </div>

  <?php
  include 'includes/footer.php';
  ?>

</body>

</html>
