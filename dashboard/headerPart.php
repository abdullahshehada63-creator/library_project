<?php
session_start();
include "conn.php";
include "functions.php";
if (isset($_SESSION['id'])) {
    if ($_SESSION['type'] == 0) {

    } else {
        echo "<br /><br /><br /><center><h1>This Page Only For Adminstrator</h1></center>";
        die;
    }
} else {
    header("Location:login.php");
}
if (isset($_GET['out'])) {
    session_destroy();
    header("Location:login.php");
}

include "head.php";
include "navBar.php";
?>
<style>
    body {

        background-color: #D2D2D2;
    }

    .sidNav {
        background-color: #1D1D1D;
        left: 0px;
        position: fixed;
        width: 200px;
        height: 100%;
        padding-top: 70px;
        transition: 0.5s;
        overflow-x: hidden;
    }

    .sidNav a {
        display: block;
        color: whitesmoke;
        font-size: 14px;
        padding-bottom: 10px;
        padding-top: 10px;
        padding-left: 10px;
        text-decoration: none;
        text-transform: uppercase;

        transition: 0.5s;
    }

    .sidNav a:hover {
        background-color: #FFFF80;
        color: black;
        transition: 0.5s;
    }

    .mainContaner {
        margin-left: 200px;
        width: auto;
        transition: 0.5s;
        margin-right: 10px;
    }

    @media (max-width:768px) {
        .sidNav {
            width: 0px;
        }

        .mainContaner {
            margin-left: 10px;

        }
    }
</style>
<div class="sidNav" id="sid">
    <a href="admin.php"><span class="glyphicon glyphicon-home"></span> &nbsp; Dashboard</a>

    <a href="categories.php"><span class="glyphicon glyphicon-folder-open"></span> &nbsp; Categories</a>

    <a href="Posts.php"><span class="glyphicon glyphicon-bullhorn"></span> &nbsp; Posts</a>

    <a href="quotes.php"><span class="glyphicon glyphicon-comment"></span> &nbsp; Quotes</a>

    <a href="services.php"><span class="glyphicon glyphicon-wrench"></span> &nbsp; Services</a>

    <a href="items.php"><span class="glyphicon glyphicon-book"></span> &nbsp; Items</a>

    <a href="comments.php"><span class="glyphicon glyphicon-pencil"></span> &nbsp; Comments</a>
</div>

<br /><br /><br />
<div class="container mainContaner" id="cont">