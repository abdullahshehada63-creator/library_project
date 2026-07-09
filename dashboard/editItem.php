<?php
ob_start();
include "headerPart.php";

// تحديد اللغة الحالية
$lang = $_SESSION['lang'] ?? 'en';
$catColumn = $lang === 'ar' ? 'cat_name_ar' : 'cat_name_en';

// جلب بيانات الكتاب
$item_id = (int) $_GET['id'];
$itemData = mysqli_query($conn, "SELECT * FROM `items` WHERE `item_id` = $item_id");
$itemData = mysqli_fetch_assoc($itemData);

// القيم الافتراضية
$itemImage = $itemData['item_img'] ?? '';
$bookFileName = $itemData['item_file'] ?? '';
$defaultValues = [
   'cat' => $itemData['item_sub_cat'] ?? '',
   'name' => $itemData['item_name'] ?? '',
   'author' => $itemData['item_author'] ?? '',
   'Description' => $itemData['item_Description'] ?? ''
];
?>

<div class="row" style="padding: 10px;">
   <div class="col-sm-12">
      <div class="panel panel-default">
         <div class="page-header text-center" style="font-size: 25px; font-weight: bolder;">
            <?php echo $lang === 'ar' ? 'تعديل الكتاب' : 'Edit Book'; ?>
         </div>
         <div class="panel-body">
            <div class="row">
               <div class="col-sm-3"></div>
               <div class="col-sm-6">
                  <form action="" method="post" enctype="multipart/form-data">

                     <!-- التصنيفات -->
                     <label><?php echo $lang === 'ar' ? 'اختر التصنيف' : 'Select Category'; ?></label>
                     <select name="cat" class="form-control" required>
                        <?php
                        $mainCat = mysqli_query($conn, "SELECT * FROM `category` ORDER BY `cat_id`");
                        while ($row = mysqli_fetch_assoc($mainCat)) {
                           $catName = htmlspecialchars($row[$catColumn]);
                           $selected = ($row['cat_id'] == ($_POST['cat'] ?? $defaultValues['cat'])) ? 'selected' : '';
                           echo "<option value='{$row['cat_id']}' $selected>$catName</option>";
                        }
                        ?>
                     </select>

                     <!-- عنوان الكتاب -->
                     <label style="margin-top:25px;"><?php echo $lang === 'ar' ? 'عنوان الكتاب' : 'Enter Book Name'; ?></label>
                     <input type="text" name="name"
                        value="<?= htmlspecialchars($_POST['name'] ?? $defaultValues['name']) ?>" class="form-control"
                        required />

                     <!-- اسم المؤلف -->
                     <label style="margin-top:25px;"><?php echo $lang === 'ar' ? 'اسم المؤلف' : 'Enter Author'; ?></label>
                     <input type="text" name="author"
                        value="<?= htmlspecialchars($_POST['author'] ?? $defaultValues['author']) ?>"
                        class="form-control" required />

                     <!-- الغلاف الحالي -->
                     <label style="margin-top:25px;"><?php echo $lang === 'ar' ? 'الغلاف الحالي' : 'Current Book Cover'; ?></label><br>
                     <?php if (!empty($itemImage)): ?>
                        <img src="<?= htmlspecialchars($itemImage) ?>" class="thumbnail"
                           style="width: 300px; height: 250px;" />
                     <?php else: ?>
                        <p><?php echo $lang === 'ar' ? 'لا توجد صورة غلاف' : 'No cover image available'; ?></p>
                     <?php endif; ?>

                     <!-- تحميل غلاف جديد -->
                     <label style="margin-top:25px;"><?php echo $lang === 'ar' ? 'تحديث الغلاف (اختياري)' : 'Upload New Book Cover (optional)'; ?></label>
                     <input type="file" name="itemImage" class="form-control" accept="image/*" />

                     <!-- الوصف -->
                     <label style="margin-top:25px;"><?php echo $lang === 'ar' ? 'الوصف' : 'Description'; ?></label>
                     <input type="text" name="Description"
                        value="<?= htmlspecialchars($_POST['Description'] ?? $defaultValues['Description']) ?>"
                        class="form-control" required />

                     <!-- الملف الحالي -->
                     <label style="margin-top:25px;">
                        <?php echo $lang === 'ar' ? 'ملف الكتاب الحالي: ' : 'Current Book File: '; ?>
                        <?= htmlspecialchars(basename($bookFileName)) ?>
                     </label>

                     <!-- تحميل ملف جديد -->
                     <label style="margin-top:25px;"><?php echo $lang === 'ar' ? 'تحديث الملف (اختياري)' : 'Upload New Book File (optional)'; ?></label>
                     <input type="file" name="bookFile" class="form-control" accept=".pdf,.doc,.docx" />

                     <center>
                        <input type="submit" value="<?php echo $lang === 'ar' ? 'حفظ' : 'Save'; ?>" name="save" class="btn btn-primary"
                           style="margin-top:25px;" />
                     </center>

                     <?php
                     if (isset($_POST['save'])) {
                        if (!empty($_POST['cat']) && !empty($_POST['name']) && !empty($_POST['author'])) {
                           $timestamp = time();
                           $randomString = bin2hex(random_bytes(4));
                           $uniqueId = $timestamp . '_' . $randomString;

                           $catid = (int) $_POST['cat'];
                           $name = mysqli_real_escape_string($conn, $_POST['name']);
                           $author = mysqli_real_escape_string($conn, $_POST['author']);
                           $Description = mysqli_real_escape_string($conn, $_POST['Description']);

                           // معالجة الصورة
                           if (!empty($_FILES['itemImage']['tmp_name'])) {
                              if (!empty($itemImage) && file_exists($itemImage)) {
                                 unlink($itemImage);
                              }
                              $imgExtension = pathinfo($_FILES['itemImage']['name'], PATHINFO_EXTENSION);
                              $img = "itemImg/book_cover_{$uniqueId}." . strtolower($imgExtension);
                              move_uploaded_file($_FILES['itemImage']['tmp_name'], $img);
                           } else {
                              $img = $itemImage;
                           }

                           // معالجة الملف
                           if (!empty($_FILES['bookFile']['tmp_name'])) {
                              if (!empty($bookFileName) && file_exists($bookFileName)) {
                                 unlink($bookFileName);
                              }
                              $bookFileExtension = pathinfo($_FILES['bookFile']['name'], PATHINFO_EXTENSION);
                              $bookFileName = "books/book_file_{$uniqueId}." . strtolower($bookFileExtension);
                              move_uploaded_file($_FILES['bookFile']['tmp_name'], $bookFileName);
                           }

                           $updateSQL = "UPDATE items SET 
                              item_name = '$name', 
                              item_author = '$author', 
                              item_Description = '$Description',
                              item_img = '$img',
                              item_sub_cat = '$catid',
                              item_file = '$bookFileName'
                              WHERE item_id = $item_id";

                           if (mysqli_query($conn, $updateSQL)) {
                              echo "<div class='alert alert-success'><strong>" . ($lang === 'ar' ? 'تم التحديث بنجاح' : 'Success!') . "</strong></div>";
                              header("Location: items.php");
                              exit;
                           } else {
                              echo "<div class='alert alert-danger'><strong>" . ($lang === 'ar' ? 'خطأ!' : 'Error!') . "</strong> " . mysqli_error($conn) . "</div>";
                           }
                        } else {
                           echo "<div class='alert alert-danger'><strong>" . ($lang === 'ar' ? 'خطأ!' : 'Error!') . "</strong> " . ($lang === 'ar' ? 'يرجى ملء جميع الحقول المطلوبة' : 'Please fill all required fields.') . "</div>";
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
