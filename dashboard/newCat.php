<?php
include "headerPart.php";

if (isset($_POST['save'])) {
    $cat_name_en = trim($_POST['cat_name_en']);
    $cat_name_ar = trim($_POST['cat_name_ar']);
    $is_visible = isset($_POST['is_visible']) ? 1 : 0;
    $img = "";

    if (!empty($_FILES['img']['tmp_name'])) {
        $img = addslashes(file_get_contents($_FILES['img']['tmp_name']));
    }

    if (!empty($cat_name_en) && !empty($cat_name_ar)) {
        $cat_name_en = mysqli_real_escape_string($conn, $cat_name_en);
        $cat_name_ar = mysqli_real_escape_string($conn, $cat_name_ar);

        $query = "INSERT INTO `category` (`cat_name_en`, `cat_name_ar`, `img`, `is_visible`) 
                  VALUES ('$cat_name_en', '$cat_name_ar', '$img', '$is_visible')";

        if (mysqli_query($conn, $query)) {
            echo "<div class='alert alert-success'><strong>Success!</strong> Category added successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'><strong>Error!</strong> Failed to add category.</div>";
        }
    } else {
        echo "<div class='alert alert-warning'><strong>Warning!</strong> Both English and Arabic names are required.</div>";
    }
}
?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading text-center" style="font-size: 20px; font-weight: bolder;">Add New Category</div>
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6 text-center">
                    <br><br>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <input type="text" name="cat_name_en" class="form-control" placeholder="Category Name (English)" required><br>
                                <input type="text" name="cat_name_ar" class="form-control" placeholder="Category Name (Arabic)" required><br>
                                <input type="file" name="img" class="form-control"><br>
                                <label>
                                    <input type="checkbox" name="is_visible" value="1"> Show category on home page
                                </label>
                                <br><br>
                                <input type="submit" name="save" value="Add Category" class="btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footerPart.php"; ?>
