<?php
include "headerPart.php";

// لغة العرض: افتراضياً إنجليزي، يمكن تغييرها بتمرير ?lang=ar
$lang = (isset($_GET['lang']) && $_GET['lang'] === 'ar') ? 'ar' : 'en';

// Handle quote deletion
if (isset($_GET['delete'])) {
   $quote_id = intval($_GET['delete']);

   $deleteQuery = "DELETE FROM `quotes` WHERE `quote_id` = $quote_id";
   if (mysqli_query($conn, $deleteQuery)) {
      echo '<div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Quote deleted successfully.
              </div>';
   } else {
      echo '<div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Error deleting quote: ' . mysqli_error($conn) . '
              </div>';
   }
}
?>

<style>
/* (نفس التنسيقات كما في كودك الأصلي) */
.quotes-container {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
  gap: 25px;
  margin-top: 30px;
}
.quote-card {
  background: white;
  border-radius: 8px;
  box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
  padding: 25px;
  position: relative;
  transition: all 0.3s ease;
  direction: <?= $lang === 'ar' ? 'rtl' : 'ltr' ?>;
  text-align: <?= $lang === 'ar' ? 'right' : 'left' ?>;
}
.quote-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}
.quote-text {
  font-size: 18px;
  line-height: 1.6;
  color: #333;
  font-style: italic;
  margin-bottom: 20px;
  position: relative;
  padding-left: <?= $lang === 'ar' ? '0' : '20px' ?>;
  padding-right: <?= $lang === 'ar' ? '20px' : '0' ?>;
}
.quote-text:before {
  content: '"';
  font-size: 60px;
  color: #f0f0f0;
  position: absolute;
  <?= $lang === 'ar' ? 'right: -15px;' : 'left: -15px;' ?>
  top: -20px;
  z-index: 0;
}
.quote-author {
  font-weight: bold;
  color: #555;
  margin-bottom: 10px;
  position: relative;
  z-index: 1;
  text-align: <?= $lang === 'ar' ? 'left' : 'right' ?>;
}
.quote-date {
  font-size: 13px;
  color: #888;
  text-align: <?= $lang === 'ar' ? 'left' : 'right' ?>;
}
.quote-actions {
  display: flex;
  gap: 10px;
  margin-top: 20px;
  border-top: 1px solid #f0f0f0;
  padding-top: 15px;
  justify-content: center;
}
.quote-actions a {
  flex: 1;
  text-align: center;
  padding: 8px 0;
}
.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
  padding-bottom: 15px;
  border-bottom: 1px solid #eee;
  direction: ltr;
}
@media (max-width: 768px) {
  .quotes-container {
    grid-template-columns: 1fr;
  }
}
</style>

<div class="page-header">
   <h2 style="margin: 0;">Quotes Management</h2>
   <div>
       <!-- روابط لتغيير اللغة -->
       <a href="quotes.php?lang=en" class="btn btn-default" style="margin-right:10px;">English</a>
       <a href="quotes.php?lang=ar" class="btn btn-default">العربية</a>
       <a href="newQuote.php" class="btn btn-primary" style="margin-left:20px;">
          <span class="glyphicon glyphicon-plus"></span> Add New Quote
       </a>
   </div>
</div>

<div class="quotes-container">
   <?php
   $allQuotes = mysqli_query($conn, "SELECT * FROM `quotes` ORDER BY `quote_id` DESC");
   while ($row = mysqli_fetch_assoc($allQuotes)):
      $textField = 'quote_text_' . $lang;
      $authorField = 'quote_author_' . $lang;
      ?>
      <div class="quote-card">
         <div class="quote-text">
            <?= nl2br(htmlspecialchars($row[$textField])) ?>
         </div>
         <div class="quote-author">
            - <?= htmlspecialchars($row[$authorField]) ?>
         </div>
         <div class="quote-date">
            <?= date('F j, Y', strtotime($row['quote_date'])) ?>
         </div>
         <div class="quote-actions">
            <a href="editQuote.php?quote_id=<?= $row['quote_id'] ?>" class="btn btn-warning">
               <span class="glyphicon glyphicon-edit"></span> Edit
            </a>
            <a href="quotes.php?delete=<?= $row['quote_id'] ?>&lang=<?= $lang ?>" class="btn btn-danger"
               onclick="return confirm('Are you sure you want to delete this quote?');">
               <span class="glyphicon glyphicon-trash"></span> Delete
            </a>
         </div>
      </div>
   <?php endwhile; ?>
</div>

<?php include "footerPart.php"; ?>
