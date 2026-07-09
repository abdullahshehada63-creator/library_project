<?php
ob_start();  // لتخزين المخرجات مؤقتاً
include "headerPart.php";
?>

<div class="row">
   <div class="col-sm-12">
      <div class="panel panel-default">
         <div class="panel-heading text-center" style="font-size: 20px; font-weight: bolder;">
            Add New Category
         </div>

         <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6 text-center">
               <br /><br />
               <div class="panel panel-default">
                  <div class="panel-body" style="border-radius: 0px;">

                     <form action="" method="post" enctype="multipart/form-data">
                        <input type="text" name="cat_name_en" value="<?= isset($_POST['cat_name_en']) ? htmlspecialchars($_POST['cat_name_en']) : '' ?>" class="form-control" placeholder="Enter Category Name (English)" /><br />
                        
                        <input type="text" name="cat_name_ar" value="<?= isset($_POST['cat_name_ar']) ? htmlspecialchars($_POST['cat_name_ar']) : '' ?>" class="form-control" placeholder="Enter Category Name (Arabic)" /><br />
                        
                        <input type="file" name="img" class="form-control" /><br />
                        
                        <label>
                           <input type="checkbox" name="is_visible" value="1" checked>
                           Show category on home page
                        </label>
                        <br /><br />
                        
                        <input type="submit" name="save" value="Save" class="btn btn-primary" />
                     </form>

                     <?php
                     if (isset($_POST['save'])) {
                        $catNameEn = trim($_POST['cat_name_en']);
                        $catNameAr = trim($_POST['cat_name_ar']);
                        $isVisible = isset($_POST['is_visible']) ? 1 : 0;
                        $img = "";

                        if (!empty($catNameEn) && !empty($catNameAr)) {
                           $catNameEn = mysqli_real_escape_string($conn, $catNameEn);
                           $catNameAr = mysqli_real_escape_string($conn, $catNameAr);

                           if (!empty($_FILES['img']['tmp_name'])) {
                              $img = addslashes(file_get_contents($_FILES['img']['tmp_name']));
                           }

                           $query = "INSERT INTO `category` (`cat_name_en`, `cat_name_ar`, `img`, `is_visible`) 
                                     VALUES ('$catNameEn', '$catNameAr', '$img', '$isVisible')";

                           if (mysqli_query($conn, $query)) {
                              echo "<div class='alert alert-success'>
                                       <strong>Success!</strong> New Category Added successfully.
                                    </div>";
                              header("Location: categories.php");
                              exit;
                           } else {
                              echo "<div class='alert alert-danger'>
                                       <strong>Error!</strong> Failed to add category. " . mysqli_error($conn) . "
                                    </div>";
                           }
                        } else {
                           echo "<div class='alert alert-warning'>
                                    <strong>Warning!</strong> Both English and Arabic names are required.
                                 </div>";
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
include "footerPart.php";
?>
