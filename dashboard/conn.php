<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "library_iug";

// الاتصال بقاعدة البيانات باستخدام mysqli
$conn = mysqli_connect($host, $user, $pass, $db);

// التحقق من الاتصال بقاعدة البيانات
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>