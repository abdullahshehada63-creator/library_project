<?php
ob_start();
include "headerPart.php";
?>

<div class="row">
   <div class="col-sm-12">
      <div class="panel panel-default">
         <div class="panel-heading text-center" style="font-size: 20px; font-weight: bolder;">Add New Service</div>

         <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6 text-center">
               <br /><br />
               <div class="panel panel-default">
                  <div class="panel-body">

                     <form action="" method="post" enctype="multipart/form-data">
                        <!-- الاسم بالإنجليزية -->
                        <input type="text" name="service_name_en" value="<?= isset($_POST['service_name_en']) ? htmlspecialchars($_POST['service_name_en']) : '' ?>" class="form-control" placeholder="Enter Service Name (English)" /><br />

                        <!-- الاسم بالعربية -->
                        <input type="text" name="service_name_ar" value="<?= isset($_POST['service_name_ar']) ? htmlspecialchars($_POST['service_name_ar']) : '' ?>" class="form-control" placeholder="أدخل اسم الخدمة (عربي)" dir="rtl" /><br />

                        <!-- رفع الصورة -->
                        <input type="file" name="img" class="form-control" /><br />

                        <!-- خيار الظهور في الصفحة الرئيسية -->
                        <label>
                           <input type="checkbox" name="show_on_index" value="1" checked>
                           Show service on home page
                        </label>
                        <br /><br />

                        <input type="submit" name="save" value="Save" class="btn btn-primary" />
                     </form>

                     <?php
                     if (isset($_POST['save'])) {
                        if (!empty($_POST['service_name_en']) && !empty($_POST['service_name_ar'])) {
                           $serviceNameEn = mysqli_real_escape_string($conn, $_POST['service_name_en']);
                           $serviceNameAr = mysqli_real_escape_string($conn, $_POST['service_name_ar']);
                           $showOnIndex = isset($_POST['show_on_index']) ? 1 : 0;
                           $img = "";

                           if (!empty($_FILES['img']['tmp_name'])) {
                              $img = addslashes(file_get_contents($_FILES['img']['tmp_name']));
                           }

                           $query = "INSERT INTO `service` (`service_name_en`, `service_name_ar`, `img`, `show_on_index`) 
                                     VALUES ('$serviceNameEn', '$serviceNameAr', '$img', '$showOnIndex')";

                           if (mysqli_query($conn, $query)) {
                              echo "<div class='alert alert-success'><strong>Success!</strong> New Service Added successfully.</div>";
                              header("Location: services.php");
                              exit;
                           } else {
                              echo "<div class='alert alert-danger'><strong>Error!</strong> Failed to add service: " . mysqli_error($conn) . "</div>";
                           }
                        } else {
                           echo "<div class='alert alert-warning'><strong>Warning!</strong> Both English and Arabic names are required.</div>";
                        }
                     }
                     ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<?php
ob_end_flush();
include "footerPart.php";
?>
