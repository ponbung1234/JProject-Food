<?php
session_start();
include_once '../dbconfig.php';

$cu_id = $_SESSION["cu_id"];
$id = $_POST['hidden_id'];
$query = "SELECT * FROM wishlist WHERE food_id = $id and cu_id = $cu_id";
$result = mysqli_query($connect, $query);

if (mysqli_num_rows($result) > 0) {
    echo "already added to wishlist";
} else {
    $query = "INSERT INTO wishlist (cu_id, food_id) VALUES ($cu_id, $id)";

    if ($connect->query($query) === TRUE) {
        echo "success-wishlist";
    } else
        echo "Error: " . $query . "<br>" . $connect->error;
}

$connect->close();