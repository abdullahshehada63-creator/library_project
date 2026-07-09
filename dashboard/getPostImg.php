<?php
include "conn.php";
$post_id = $_GET['post_id']; // تأمين المدخلات
$postImg = mysqli_query($conn, "SELECT `post_image` FROM `posts` WHERE `post_id` = $post_id");
$postImg = mysqli_fetch_assoc($postImg);

$img = $postImg['post_image'];
if (empty($img)) {
    $img = file_get_contents("img/post_def.png"); // تأكد من وجود هذا الملف كصورة افتراضية
}

header("Content-type: image/jpeg");
echo $img;
?>