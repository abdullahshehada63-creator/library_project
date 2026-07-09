<?php
session_start();
include "dashboard/conn.php";
include "dashboard/functions.php";
if(isset($_SESSION['id']))
{
    if($_SESSION['type']==0)
    {
         
    }
    else
    {
        echo "<br /><br /><br /><center><h1>This Page Only For Adminstrator</h1></center>";die;
    }
}
else
{
}
if(isset($_GET['out']))
{
    session_destroy();
    header("Location:login.php");
}
?>