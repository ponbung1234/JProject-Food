<?php
include_once '../../dbconfig.php';

$id = $_POST['food_id'];
$query = "SELECT * FROM foods WHERE food_id= $id";
$query2 = "DELETE FROM foods WHERE food_id= $id";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_array($result);
unlink("../../" . $row["image"]);

if ($connect->query($query2) === TRUE)
    echo "success";
else
    echo "Error: " . $query . "<br>" . $connect->error;

$connect->close();