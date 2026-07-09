<?php
ob_start();  // تخزين المخرجات مؤقتًا لتجنب أخطاء التوجيه
include "headerPart.php";

// تحديد اللغة الحالية
$lang = $_SESSION['lang'] ?? 'en';
$catColumn = $lang === 'ar' ? 'cat_name_ar' : 'cat_name_en';
?>

<div class="row" style="padding: 10px;">
  <div class="col-sm-12">
    <div class="panel panel-default">
      <div class="page-header text-center" style="font-size: 25px; font-weight: bolder;">
        <?php echo $lang === 'ar' ? 'إضافة كتاب جديد' : 'Add New Book'; ?>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-sm-3"></div>
          <div class="col-sm-6">
            <form action="" method="post" enctype="multipart/form-data">

              <!-- الفئة -->
              <label><?php echo $lang === 'ar' ? 'اختر التصنيف' : 'Select Category'; ?></label>
              <select name="cat" class="form-control" required>
                <?php
                $subCat = mysqli_query($conn, "SELECT * FROM `category`");
                while ($row = mysqli_fetch_assoc($subCat)) {
                  $catName = htmlspecialchars($row[$catColumn]);
                  echo "<option value='{$row['cat_id']}'>$catName</option>";
                }
                ?>
              </select>

              <!-- اسم الكتاب -->
              <label style="margin-top:25px;"><?php echo $lang === 'ar' ? 'عنوان الكتاب' : 'Enter Book Title'; ?></label>
              <input type="text" name="name" value="" class="form-control" required />

              <!-- اسم المؤلف -->
              <label style="margin-top:25px;"><?php echo $lang === 'ar' ? 'اسم المؤلف' : 'Enter Author Name'; ?></label>
              <input type="text" name="author" value="" class="form-control" required />

              <!-- الوصف -->
              <label style="margin-top:25px;"><?php echo $lang === 'ar' ? 'الوصف' : 'Description'; ?></label>
              <input type="text" name="Description" value="" class="form-control" required />

              <!-- صورة الغلاف -->
              <label style="margin-top:25px;"><?php echo $lang === 'ar' ? 'صورة الغلاف' : 'Upload Book Cover'; ?></label>
              <input type="file" name="itemImage" class="form-control" required accept="image/*" />

              <!-- ملف الكتاب -->
              <label style="margin-top:25px;"><?php echo $lang === 'ar' ? 'ملف الكتاب' : 'Upload Book File'; ?></label>
              <input type="file" name="bookFile" class="form-control" required accept=".pdf,.doc,.docx" />

              <!-- زر الحفظ -->
              <center>
                <input type="submit" value="<?php echo $lang === 'ar' ? 'حفظ' : 'Save'; ?>" name="save" class="btn btn-primary" style="margin-top:25px;" />
              </center>

              <?php
              if (isset($_POST['save'])) {
                // Generate unique file names
                $timestamp = time();
                $randomString = bin2hex(random_bytes(4));
                $uniqueId = $timestamp . '_' . $randomString;

                $catid = (int) $_POST['cat'];
                $name = mysqli_real_escape_string($conn, $_POST['name']);
                $author = mysqli_real_escape_string($conn, $_POST['author']);
                $Description = mysqli_real_escape_string($conn, $_POST['Description']);
                $date = date("Y/m/d");

                // Process image upload
                $imgExtension = pathinfo($_FILES['itemImage']['name'], PATHINFO_EXTENSION);
                $img = "itemImg/book_cover_{$uniqueId}." . strtolower($imgExtension);

                // Process book file upload
                $bookFileExtension = pathinfo($_FILES['bookFile']['name'], PATHINFO_EXTENSION);
                $bookFileName = "books/book_file_{$uniqueId}." . strtolower($bookFileExtension);

                $insert = "INSERT INTO `items` (`item_sub_cat`, `item_name`, `item_author`, `item_img`, `item_Description`, `item_file`, `date_added`) 
                           VALUES ($catid, '$name', '$author', '$img', '$Description', '$bookFileName', '$date')";

                if (mysqli_query($conn, $insert)) {
                  // Move uploaded files
                  move_uploaded_file($_FILES['itemImage']['tmp_name'], $img);
                  move_uploaded_file($_FILES['bookFile']['tmp_name'], $bookFileName);

                  echo "<div class='alert alert-success'><strong>" . ($lang === 'ar' ? 'تم بنجاح!' : 'Success!') . "</strong> " . ($lang === 'ar' ? 'تمت إضافة الكتاب.' : 'Book added successfully.') . "</div>";

                  // إعادة التوجيه
                  header("Location: items.php");
                  exit;
                } else {
                  echo "<div class='alert alert-danger'><strong>" . ($lang === 'ar' ? 'خطأ!' : 'Error!') . "</strong> " . mysqli_error($conn) . "</div>";
                }
              }
              ?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
