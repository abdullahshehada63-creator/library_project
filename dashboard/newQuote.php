<?php
include "headerPart.php";

// مثال: تحديد اللغة (يمكن تعديلها حسب آلية موقعك)
$lang = 'en';  // 'en' أو 'ar'

// عند حفظ النموذج
if (isset($_POST['save'])) {
    // تعقيم البيانات لكل لغة
    $quote_text_en = mysqli_real_escape_string($conn, $_POST['quote_text_en'] ?? '');
    $quote_text_ar = mysqli_real_escape_string($conn, $_POST['quote_text_ar'] ?? '');
    $quote_author_en = mysqli_real_escape_string($conn, $_POST['quote_author_en'] ?? '');
    $quote_author_ar = mysqli_real_escape_string($conn, $_POST['quote_author_ar'] ?? '');
    $quote_date = date("Y-m-d H:i:s");

    // تحقق من تعبئة الحقول للغتين (يمكن تعديل الشرط حسب رغبتك)
    if (!empty($quote_text_en) && !empty($quote_author_en) && !empty($quote_text_ar) && !empty($quote_author_ar)) {
        $query = "INSERT INTO `quotes` 
            (`quote_text_en`, `quote_author_en`, `quote_text_ar`, `quote_author_ar`, `quote_date`) 
            VALUES 
            ('$quote_text_en', '$quote_author_en', '$quote_text_ar', '$quote_author_ar', '$quote_date')";

        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Quote added successfully.'); window.location='quotes.php';</script>";
        } else {
            echo "<script>alert('Database error: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('All fields are required.');</script>";
    }
}
?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading text-center" style="font-size: 20px; font-weight: bolder;">
                Add New Quote / إضافة اقتباس جديد
            </div>
            <div class="panel-body text-center">
                <form action="" method="post" class="col-sm-8 col-sm-offset-2">
                    <h4>English</h4>
                    <textarea name="quote_text_en" class="form-control" placeholder="Enter quote in English..." required><?= htmlspecialchars($_POST['quote_text_en'] ?? '') ?></textarea><br />
                    <input type="text" name="quote_author_en" class="form-control" placeholder="Author name in English" required value="<?= htmlspecialchars($_POST['quote_author_en'] ?? '') ?>" /><br />
                    
                    <h4>العربية</h4>
                    <textarea name="quote_text_ar" class="form-control" placeholder="أدخل الاقتباس بالعربية..." required><?= htmlspecialchars($_POST['quote_text_ar'] ?? '') ?></textarea><br />
                    <input type="text" name="quote_author_ar" class="form-control" placeholder="اسم المؤلف بالعربية" required value="<?= htmlspecialchars($_POST['quote_author_ar'] ?? '') ?>" /><br />
                    
                    <input type="submit" name="save" value="Save Quote" class="btn btn-primary" />
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "footerPart.php"; ?>
