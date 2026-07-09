<?php
include "headerPart.php";

$item_id = (int) $_GET['id'];
$itemData = mysqli_query($conn, "SELECT * FROM `items` WHERE item_id = $item_id");
$itemData = mysqli_fetch_assoc($itemData);

// تحديد اللغة الحالية
$lang = $_SESSION['lang'] ?? 'en';
$catColumn = $lang === 'ar' ? 'cat_name_ar' : 'cat_name_en';
$dir = $lang === 'ar' ? 'rtl' : 'ltr';
$textAlign = $lang === 'ar' ? 'text-right' : 'text-left';

if (!empty($itemData)) {
    $itemName = htmlspecialchars($itemData['item_name']);
    $itemAuthor = htmlspecialchars($itemData['item_author']);
    $image = htmlspecialchars($itemData['item_img']);
    $dateAdded = htmlspecialchars($itemData['date_added']);
    $description = htmlspecialchars($itemData['item_Description'] ?? ($lang === 'ar' ? 'لا يوجد وصف' : 'No description available'));
    $categoryId = (int) $itemData['item_sub_cat'];
    $filePath = htmlspecialchars($itemData['item_file'] ?? '');

    // Get category name
    $categoryQuery = mysqli_query($conn, "SELECT `$catColumn` FROM category WHERE cat_id = $categoryId");
    $category = mysqli_fetch_assoc($categoryQuery);
    $categoryName = htmlspecialchars($category[$catColumn] ?? ($lang === 'ar' ? 'غير مصنف' : 'Uncategorized'));
}
?>

<style>
    .card-custom {
        background: #fff;
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.1);
        padding: 25px;
        margin-top: 30px;
    }

    .card-custom img {
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        max-height: 400px;
        width: 100%;
        object-fit: contain;
        background-color: #f8f8f8;
        padding: 10px;
    }

    .meta-item {
        font-size: 16px;
        margin-bottom: 10px;
    }

    .meta-item strong {
        color: #444;
        min-width: 100px;
        display: inline-block;
    }

    .description-box {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 8px;
        line-height: 1.7;
    }

    .btn-group-custom {
        margin-top: 25px;
    }

    .btn-custom {
        min-width: 140px;
    }
</style>

<div class="container" dir="<?php echo $dir; ?>">
    <div class="card-custom">
        <div class="row">
            <div class="col-md-4 text-center">
                <img src="<?php echo $image; ?>" alt="Book Image" class="img-fluid">
            </div>

            <div class="col-md-8 <?php echo $textAlign; ?>">
                <h3 class="mb-4"><?php echo $itemName; ?></h3>

                <div class="meta-item">
                    <strong><?php echo $lang === 'ar' ? 'المؤلف:' : 'Author:'; ?></strong> <?php echo $itemAuthor; ?>
                </div>

                <div class="meta-item">
                    <strong><?php echo $lang === 'ar' ? 'التصنيف:' : 'Category:'; ?></strong> <?php echo $categoryName; ?>
                </div>

                <div class="meta-item">
                    <strong><?php echo $lang === 'ar' ? 'تاريخ الإضافة:' : 'Date Added:'; ?></strong>
                    <?php echo date('F j, Y', strtotime($dateAdded)); ?>
                </div>

                <?php if (!empty($filePath)): ?>
                    <div class="meta-item">
                        <strong><?php echo $lang === 'ar' ? 'الملف:' : 'File:'; ?></strong>
                        <a href="<?php echo $filePath; ?>" target="_blank" class="btn btn-sm btn-info">
                            <?php echo $lang === 'ar' ? 'عرض / تحميل' : 'View / Download'; ?>
                        </a>
                    </div>
                <?php endif; ?>

                <div class="mt-4">
                    <h5><?php echo $lang === 'ar' ? 'الوصف' : 'Description'; ?>:</h5>
                    <div class="description-box">
                        <?php echo nl2br($description); ?>
                    </div>
                </div>

                <div class="btn-group-custom">
                    <a href="editItem.php?id=<?php echo $item_id; ?>" class="btn btn-warning btn-custom">
                        <span class="glyphicon glyphicon-edit"></span> <?php echo $lang === 'ar' ? 'تعديل الكتاب' : 'Edit Book'; ?>
                    </a>
                    <a href="items.php" class="btn btn-secondary btn-custom">
                        <span class="glyphicon glyphicon-arrow-left"></span> <?php echo $lang === 'ar' ? 'العودة للقائمة' : 'Back to List'; ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
