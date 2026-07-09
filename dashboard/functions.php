<?php
function getCatName($id)
{
    include "conn.php";
    $catName=mysqli_query($conn,"SELECT `cat_name` FROM `category` WHERE `cat_id`=$id");
    $catName=mysqli_fetch_assoc($catName);
    $catName=$catName['cat_name'];
    return $catName;
}

?>