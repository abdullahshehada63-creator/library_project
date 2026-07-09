<?php
session_start();
$lang = $_SESSION['lang'] ?? 'en'; 
include "headerPart.php";

// تحديد الحقول حسب اللغة
$title_field = $lang === 'ar' ? 'post_title_ar' : 'post_title_en';
$desc_field  = $lang === 'ar' ? 'post_description_ar' : 'post_description_en';

// Handle post deletion
if (isset($_GET['delete'])) {
   $post_id = intval($_GET['delete']); // Sanitize input

   $deleteQuery = "DELETE FROM `posts` WHERE `post_id` = $post_id";
   if (mysqli_query($conn, $deleteQuery)) {
      echo '<div class="alert alert-success alert-dismissible fade in">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Post deleted successfully.
              </div>';
   } else {
      echo '<div class="alert alert-danger alert-dismissible fade in">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Error deleting post: ' . mysqli_error($conn) . '
              </div>';
   }
}

// Fetch all posts for admin
$allPosts = mysqli_query($conn, "SELECT `post_id`, `$title_field` AS `post_title`, `$desc_field` AS `post_description`, `post_image`, `post_date`, `post_status` FROM `posts` ORDER BY `post_id` DESC");
?>

<style>
   .posts-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 20px;
      margin-top: 20px;
   }

   .post-card {
      background: white;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      transition: all 0.3s ease;
   }

   .post-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
   }

   .post-image-container {
      height: 180px;
      overflow: hidden;
      position: relative;
   }

   .post-image {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s;
   }

   .post-card:hover .post-image {
      transform: scale(1.05);
   }

   .post-content {
      padding: 15px;
   }

   .post-title {
      font-weight: bold;
      font-size: 16px;
      margin-bottom: 8px;
      color: #333;
      height: 40px;
      overflow: hidden;
   }

   .post-description {
      font-size: 14px;
      color: #555;
      height: 50px;
      overflow: hidden;
      margin-bottom: 10px;
   }

   .post-meta {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;
   }

   .post-date {
      font-size: 12px;
      color: #777;
   }

   .post-status {
      font-size: 12px;
      padding: 3px 8px;
      border-radius: 3px;
   }

   .status-active {
      background-color: #5cb85c;
      color: white;
   }

   .status-inactive {
      background-color: #777;
      color: white;
   }

   .post-actions {
      display: flex;
      gap: 10px;
   }

   .post-actions .btn {
      flex: 1;
      padding: 6px 0;
      font-size: 13px;
   }

   @media (max-width: 768px) {
      .posts-container {
         grid-template-columns: 1fr;
      }
   }
</style>

<div class="page-header">
   <h1>Posts Management
      <a href="newPost.php" class="btn btn-primary pull-right">
         <span class="glyphicon glyphicon-plus"></span> New Post
      </a>
   </h1>
</div>

<div class="posts-container">
   <?php while ($row = mysqli_fetch_assoc($allPosts)): ?>
      <div class="post-card">
         <div class="post-image-container">
            <img src="getPostImg.php?post_id=<?= $row['post_id'] ?>" class="post-image"
               alt="<?= htmlspecialchars($row['post_title']) ?>">
         </div>
         <div class="post-content">
            <div class="post-title"><?= htmlspecialchars($row['post_title']) ?></div>
            <div class="post-description"><?= htmlspecialchars($row['post_description']) ?></div>
            <div class="post-meta">
               <span class="post-date"><?= date('M j, Y', strtotime($row['post_date'])) ?></span>
               <span class="post-status status-<?= $row['post_status'] ?>">
                  <?= ucfirst($row['post_status']) ?>
               </span>
            </div>
            <div class="post-actions">
               <a href="editPost.php?post_id=<?= $row['post_id'] ?>" class="btn btn-warning">
                  <span class="glyphicon glyphicon-edit"></span> Edit
               </a>
               <a href="posts.php?delete=<?= $row['post_id'] ?>" class="btn btn-danger"
                  onclick="return confirm('Are you sure you want to delete this post?');">
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
