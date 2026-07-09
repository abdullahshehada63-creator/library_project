<?php
ob_start();  // إضافة هذه السطر في بداية الكود لتخزين المخرجات في الذاكرة.

include "headerPart.php";

$post_id = intval($_GET['post_id']);
$postData = mysqli_query($conn, "SELECT * FROM `posts` WHERE `post_id` = $post_id");
$postData = mysqli_fetch_assoc($postData);

// Initialize form values
$formValues = [
    'post_title_en' => $postData['post_title_en'] ?? '',
    'post_title_ar' => $postData['post_title_ar'] ?? '',
    'post_description_en' => $postData['post_description_en'] ?? '',
    'post_description_ar' => $postData['post_description_ar'] ?? '',
    'post_status' => $postData['post_status'] ?? 'active'
];


// Handle form submission
if (isset($_POST['save'])) {
    $title_en = mysqli_real_escape_string($conn, $_POST['post_title_en']);
    $title_ar = mysqli_real_escape_string($conn, $_POST['post_title_ar']);
    $desc_en = mysqli_real_escape_string($conn, $_POST['post_description_en']);
    $desc_ar = mysqli_real_escape_string($conn, $_POST['post_description_ar']);
    $status = mysqli_real_escape_string($conn, $_POST['post_status']);

    $query = "UPDATE `posts` SET 
        `post_title` = '$title_en',
        `post_description` = '$desc_en',
        `post_status` = '$status',
        `post_title_en` = '$title_en',
        `post_title_ar` = '$title_ar',
        `post_description_en` = '$desc_en',
        `post_description_ar` = '$desc_ar'";

    if (!empty($_FILES['post_image']['tmp_name'])) {
        $image = mysqli_real_escape_string($conn, file_get_contents($_FILES['post_image']['tmp_name']));
        $query .= ", `post_image` = '$image'";
    }

    $query .= " WHERE `post_id` = $post_id";

    if (mysqli_query($conn, $query)) {
        header("Location: posts.php");
        exit;
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show">
                Error updating post: ' . mysqli_error($conn) . '
                <button type="button" class="close" data-dismiss="alert">&times;</button>
              </div>';
    }

    $formValues = [
        'post_title' => $title_en,
        'post_description' => $desc_en,
        'post_status' => $status,
        'post_title_en' => $title_en,
        'post_title_ar' => $title_ar,
        'post_description_en' => $desc_en,
        'post_description_ar' => $desc_ar
    ];
}

?>

<style>
    .edit-post-container {
        max-width: 800px;
        margin: 0 auto;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        padding: 25px;
    }

    .form-header {
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
        margin-bottom: 25px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-control {
        border-radius: 4px;
        border: 1px solid #ddd;
        padding: 10px 15px;
    }

    .form-control:focus {
        border-color: #66afe9;
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(102, 175, 233, 0.6);
    }

    textarea.form-control {
        min-height: 150px;
    }

    .current-image {
        border: 1px solid #eee;
        border-radius: 4px;
        padding: 5px;
        background: white;
        max-width: 100%;
        height: auto;
        margin-bottom: 15px;
    }

    .image-preview {
        display: none;
        max-width: 100%;
        height: auto;
        margin-top: 10px;
        border: 1px solid #eee;
        border-radius: 4px;
        padding: 5px;
    }

    .btn-submit {
        padding: 10px 25px;
        font-weight: bold;
    }

    .status-select {
        width: 200px;
    }

    @media (max-width: 768px) {
        .edit-post-container {
            padding: 15px;
        }
    }
</style>

<div class="edit-post-container">
    <div class="form-header">
        <h2>Edit Post</h2>
    </div>

    <form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
    <label>Title (EN)</label>
    <input type="text" name="post_title_en" class="form-control" value="<?= $formValues['post_title_en'] ?>" required>
</div>

<div class="form-group">
    <label>Title (AR)</label>
    <input type="text" name="post_title_ar" class="form-control" value="<?= $formValues['post_title_ar'] ?>" required>
</div>

<div class="form-group">
    <label>Description (EN)</label>
    <textarea name="post_description_en" class="form-control" required><?= $formValues['post_description_en'] ?></textarea>
</div>

<div class="form-group">
    <label>Description (AR)</label>
    <textarea name="post_description_ar" class="form-control" required><?= $formValues['post_description_ar'] ?></textarea>
</div>


        <div class="form-group">
            <label>Status</label>
            <select name="post_status" class="form-control status-select" required>
                <option value="active" <?= $formValues['post_status'] == 'active' ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= $formValues['post_status'] == 'inactive' ? 'selected' : '' ?>>Inactive
                </option>
            </select>
        </div>

        <div class="form-group">
            <label>Current Image</label><br>
            <img src="getPostImg.php?post_id=<?= $post_id ?>" class="current-image">
        </div>

        <div class="form-group">
            <label>Upload New Image (Leave blank to keep current)</label>
            <input type="file" name="post_image" class="form-control" id="imageUpload" onchange="previewImage(this)">
            <img id="imagePreview" class="image-preview">
        </div>

        <div class="form-group text-right">
            <a href="posts.php" class="btn btn-default">Cancel</a>
            <button type="submit" name="save" class="btn btn-primary btn-submit">
                Save Changes
            </button>
        </div>
    </form>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var preview = document.getElementById('imagePreview');
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<?php
include "footerPart.php";
?>