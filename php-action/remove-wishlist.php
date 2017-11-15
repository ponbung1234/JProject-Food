<?php
include_once '../dbconfig.php';

$id = $_POST['hidden_id'];
$query = "DELETE FROM wishlist WHERE food_id= $id";
$result = mysqli_query($connect, $query);

if ($connect->query($query) === TRUE) {
    echo "Successfully removed from wishlist";
} else
    echo "Error: " . $query . "<br>" . $connect->error;

$connect->close();