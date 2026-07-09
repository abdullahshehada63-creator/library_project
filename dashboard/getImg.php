<?php
$id=$_GET['id'];
include "conn.php";
$img=mysqli_query($conn,"SELECT `img` FROM `t_user` WHERE `user_id`=$id");
$img=mysqli_fetch_assoc($img);
$img=$img['img'];
if(empty($img))
{
    $img=file_get_contents("noImg.png"); 
}
header("Content-type:image/jpeg");
echo $img;
?>