<?php
include "conn.php";
$img_id=$_GET['img_id'];
$imgService=mysqli_query($conn,"SELECT `img` FROM `service` WHERE `service_id`=$img_id"); 
$imgService=mysqli_fetch_assoc($imgService);
$img=$imgService['img'];
if(empty($img))
{
    $img=file_get_contents("img/category_def.png");
}
header("Content-type:image/jpeg");
echo $img;
?>