<?php
include "headerPart.php";

// Handle category deletion
if (isset($_GET['delete'])) {
   $cat_id = intval($_GET['delete']);

   $deleteQuery = "DELETE FROM `category` WHERE `cat_id` = $cat_id";
   if (mysqli_query($conn, $deleteQuery)) {
      echo '<div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Category deleted successfully
              </div>';
   } else {
      echo '<div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Error deleting category: ' . mysqli_error($conn) . '
              </div>';
   }
}
?>

<style>
   .categories-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 20px;
      margin-top: 20px;
   }

   .category-card {
      background: white;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      transition: all 0.3s ease;
   }

   .category-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
   }

   .category-image-container {
      height: 160px;
      overflow: hidden;
      position: relative;
   }

   .category-image {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s;
   }

   .category-card:hover .category-image {
      transform: scale(1.05);
   }

   .category-info {
      padding: 15px;
      text-align: center;
   }

   .category-name {
      font-weight: bold;
      font-size: 18px;
      margin-bottom: 15px;
      color: #2c3e50;
   }

   .category-actions {
      display: flex;
      gap: 10px;
   }

   .category-actions a {
      flex: 1;
      padding: 8px 0;
      font-size: 14px;
   }

   .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      padding-bottom: 15px;
      border-bottom: 1px solid #eee;
   }

   @media (max-width: 768px) {
      .categories-container {
         grid-template-columns: 1fr;
      }
   }
</style>

<div class="page-header">
   <h2 style="margin: 0;">Categories</h2>
   <a href="newCat.php" class="btn btn-primary">
      <span class="glyphicon glyphicon-plus"></span> Add New Category
   </a>
</div>

<div class="categories-container">
   <?php
   $allCat = mysqli_query($conn, "SELECT `cat_id`, `cat_name_en`, `cat_name_ar`, `img` FROM `category` ORDER BY `cat_id` DESC");
   while ($row = mysqli_fetch_assoc($allCat)):
   ?>
      <div class="category-card">
         <div class="category-image-container">
            <img src="getMajorCatImg.php?img_id=<?= $row['cat_id'] ?>" class="category-image"
               alt="<?= htmlspecialchars($row['cat_name_en']) ?>">
         </div>
         <div class="category-info">
            <div class="category-name">
               <?= htmlspecialchars($row['cat_name_en']) ?><br>
               <small style="color: #777;"><?= htmlspecialchars($row['cat_name_ar']) ?></small>
            </div>
            <div class="category-actions">
               <a href="editCat.php?cat_id=<?= $row['cat_id'] ?>" class="btn btn-warning">
                  <span class="glyphicon glyphicon-edit"></span> Edit
               </a>
               <a href="categories.php?delete=<?= $row['cat_id'] ?>" class="btn btn-danger"
                  onclick="return confirm('Are you sure you want to delete this category?');">
                  <span class="glyphicon glyphicon-trash"></span> Delete
               </a>
            </div>
         </div>
      </div>
   <?php endwhile; ?>
</div>

<?php
include "footerPart.php";
?>
