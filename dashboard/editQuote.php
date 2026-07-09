<?php
include "headerPart.php";

$quote_id = intval($_GET['quote_id']);
$quoteData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `quotes` WHERE `quote_id` = $quote_id"));

if (!$quoteData) {
    echo "<script>alert('Quote not found.'); window.location='quotes.php';</script>";
    exit;
}

if (isset($_POST['update'])) {
    $quote_text_en = mysqli_real_escape_string($conn, $_POST['quote_text_en']);
    $quote_author_en = mysqli_real_escape_string($conn, $_POST['quote_author_en']);
    $quote_text_ar = mysqli_real_escape_string($conn, $_POST['quote_text_ar']);
    $quote_author_ar = mysqli_real_escape_string($conn, $_POST['quote_author_ar']);

    if (!empty($quote_text_en) && !empty($quote_author_en) && !empty($quote_text_ar) && !empty($quote_author_ar)) {
        $updateQuery = "UPDATE `quotes` SET 
            `quote_text_en`='$quote_text_en', 
            `quote_author_en`='$quote_author_en', 
            `quote_text_ar`='$quote_text_ar', 
            `quote_author_ar`='$quote_author_ar' 
            WHERE `quote_id`=$quote_id";

        if (mysqli_query($conn, $updateQuery)) {
            echo "<script>alert('Quote updated successfully.'); window.location='quotes.php';</script>";
            exit;
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
            <div class="panel-heading text-center" style="font-size: 20px; font-weight: bolder;">Edit Quote</div>
            <div class="panel-body text-center">
                <form action="" method="post" class="col-sm-6 col-sm-offset-3">

                    <h4>English</h4>
                    <textarea name="quote_text_en" class="form-control" required><?= htmlspecialchars($quoteData['quote_text_en']) ?></textarea><br />
                    <input type="text" name="quote_author_en" class="form-control" placeholder="Author name in English" required value="<?= htmlspecialchars($quoteData['quote_author_en']) ?>" /><br />

                    <h4>العربية</h4>
                    <textarea name="quote_text_ar" class="form-control" required style="direction: rtl; text-align: right;"><?= htmlspecialchars($quoteData['quote_text_ar']) ?></textarea><br />
                    <input type="text" name="quote_author_ar" class="form-control" placeholder="اسم المؤلف بالعربية" required value="<?= htmlspecialchars($quoteData['quote_author_ar']) ?>" /><br />

                    <input type="submit" name="update" value="Update Quote" class="btn btn-primary" />
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "footerPart.php"; ?>
