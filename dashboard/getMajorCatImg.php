<?php
include "conn.php";
$img_id = $_GET['img_id'];
$imgCat = mysqli_query($conn, "SELECT `img` FROM `category` WHERE `cat_id`=$img_id");
$imgCat = mysqli_fetch_assoc($imgCat);
$img = $imgCat['img'];
if (empty($img)) {
    $img = file_get_contents("img/category_def.png");
}
header("Content-type:image/jpeg");
echo $img;
?>