<?php
require_once('../dbconfig.php');
session_start();
if (isset($_POST['submit']))
    $_SESSION['admin_name'] = $_POST['username'];
if (!isset($_SESSION['admin_name']))
    header("Location: login.html");
?>

<title>TFD Dashboard</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../vendor/bootstrap-3.3.7-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="css/index.css">
<link rel="stylesheet" type="text/css" href="../vendor/css/sweetalert2.min.css">
<!--    <link href="css/fileinput.min.css" media="all" rel="stylesheet" type="text/css"/>-->
<script src="../vendor/js/jquery-3.2.1.min.js"></script>
<script src="../vendor/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
<script src="../vendor/js/sweetalert2.min.js"></script>
<!--    <script src="js/plugins/piexif.min.js"></script>-->
<!--    <script src="js/plugins/sortable.min.js"></script>-->
<!--    <script src="js/plugins/purify.min.js"></script>-->
<!--    <script src="js/fileinput.min.js"></script>-->

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">Thai Food Dashboard</a>
        </div>
        <ul class="nav navbar-nav">
            <li id="menu1"><a href="index.php">Delivery status</a></li>
            <li id="menu2"><a href="add-menu.php">Add menu</a></li>
            <li id="menu3"><a href="edit-menu.php">Edit menu</a></li>
            <li id="menu4"><a href="stats.php">Statistics</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href=""><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        </ul>
    </div>
</nav>

<script>
    $(".navbar-right a").click(function () {
        $.post("../php-action/logout.php", function () {
            window.location.href = "index.php";
        });
    });
</script>