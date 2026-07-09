<?php
include "headerPart.php";

// Handle service deletion
if (isset($_GET['delete'])) {
   $service_id = intval($_GET['delete']);

   $deleteQuery = "DELETE FROM `service` WHERE `service_id` = $service_id";
   if (mysqli_query($conn, $deleteQuery)) {
      echo '<div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Service deleted successfully
              </div>';
   } else {
      echo '<div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Error deleting service: ' . mysqli_error($conn) . '
              </div>';
   }
}
?>

<style>
   .services-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 25px;
      margin-top: 30px;
   }

   .service-card {
      background: white;
      border-radius: 8px;
      box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      transition: all 0.3s ease;
   }

   .service-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
   }

   .service-image-container {
      height: 180px;
      overflow: hidden;
      position: relative;
   }

   .service-image {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s;
   }

   .service-card:hover .service-image {
      transform: scale(1.05);
   }

   .service-info {
      padding: 20px;
      text-align: center;
   }

   .service-name {
      font-weight: bold;
      font-size: 18px;
      margin-bottom: 15px;
      color: #2c3e50;
   }

   .service-actions {
      display: flex;
      gap: 10px;
      margin-top: 15px;
      border-top: 1px solid #f0f0f0;
      padding-top: 15px;
   }

   .service-actions a {
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
      .services-container {
         grid-template-columns: 1fr;
      }
   }
</style>

<div class="page-header">
   <h2 style="margin: 0;">Services Management</h2>
   <a href="newService.php" class="btn btn-primary">
      <span class="glyphicon glyphicon-plus"></span> Add New Service
   </a>
</div>

<div class="services-container">
   <?php
   $services = mysqli_query($conn, "SELECT * FROM `service` ORDER BY `service_id` DESC");

   // إعداد اللغة من الجلسة (مثلاً ar أو en)
   $lang = $_SESSION['lang'] ?? 'en';
   $name_column = ($lang == 'ar') ? 'service_name_ar' : 'service_name_en';

   while ($row = mysqli_fetch_assoc($services)):
   ?>
      <div class="service-card">
         <div class="service-image-container">
            <img src="getMajorServiceImg.php?img_id=<?= $row['service_id'] ?>" class="service-image"
               alt="<?= htmlspecialchars($row[$name_column]) ?>">
         </div>
         <div class="service-info">
            <div class="service-name"><?= htmlspecialchars($row[$name_column]) ?></div>
            <div class="service-actions">
               <a href="editService.php?service_id=<?= $row['service_id'] ?>" class="btn btn-warning">
                  <span class="glyphicon glyphicon-edit"></span> Edit
               </a>
               <a href="services.php?delete=<?= $row['service_id'] ?>" class="btn btn-danger"
                  onclick="return confirm('Are you sure you want to delete this service?');">
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
