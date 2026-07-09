<?php
include "headerPart.php";
?>
<div class="row">
   <div class="col-sm-12">
      <div class="panel panel-default">
         <div class="panel-heading text-center" style="font-size: 20px; font-weight: bolder;">Add New Post</div>

         <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6 text-center">
               <br /><br />
               <div class="panel panel-default">
                  <div class="panel-body" style="border-radius: 0px;">
                     <!-- Form to add a post -->
                     <form action="" method="post" enctype="multipart/form-data">
                        <input type="text" name="post_title_ar" value="<?= $_POST['post_title_ar'] ?? '' ?>" class="form-control" placeholder="أدخل عنوان المنشور (عربي)" /><br />

                        <input type="text" name="post_title_en" value="<?= $_POST['post_title_en'] ?? '' ?>" class="form-control" placeholder="Enter Post Title (English)" /><br />

                        <textarea name="post_description_ar" class="form-control" placeholder="أدخل وصف المنشور (عربي)"><?= $_POST['post_description_ar'] ?? '' ?></textarea><br />

                        <textarea name="post_description_en" class="form-control" placeholder="Enter Post Description (English)"><?= $_POST['post_description_en'] ?? '' ?></textarea><br />

                        <input type="file" name="post_image" class="form-control" /><br />

                        <input type="submit" name="save" value="Save" class="btn btn-primary" />
                     </form>

                     <?php
                     if (isset($_POST['save'])) {
                        // Check required fields
                        if (
                           !empty($_POST['post_title_ar']) && !empty($_POST['post_title_en']) &&
                           !empty($_POST['post_description_ar']) && !empty($_POST['post_description_en'])
                        ) {
                           $img = "";
                           $title_ar = mysqli_real_escape_string($conn, $_POST['post_title_ar']);
                           $title_en = mysqli_real_escape_string($conn, $_POST['post_title_en']);
                           $desc_ar = mysqli_real_escape_string($conn, $_POST['post_description_ar']);
                           $desc_en = mysqli_real_escape_string($conn, $_POST['post_description_en']);
                           $status = 'active';
                           $date = date("Y-m-d H:i:s");

                           if (!empty($_FILES['post_image']['tmp_name'])) {
                              $img = addslashes(file_get_contents($_FILES['post_image']['tmp_name']));
                           }

                           $insert = "INSERT INTO `posts` 
                                    (`post_title_ar`, `post_title_en`, `post_description_ar`, `post_description_en`, `post_image`, `post_date`, `post_status`) 
                                    VALUES 
                                    ('$title_ar', '$title_en', '$desc_ar', '$desc_en', '$img', '$date', '$status')";

                           if (mysqli_query($conn, $insert)) {
                              echo "<div class='alert alert-success'>
                                       <strong>Success!</strong> New Post Added successfully.
                                    </div>";
                              exit;
                           } else {
                              echo "<div class='alert alert-danger'>
                                       <strong>Error!</strong> Failed to add post: " . mysqli_error($conn) . "
                                    </div>";
                           }
                        } else {
                           echo "<div class='alert alert-warning'>Please fill in all required fields.</div>";
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
