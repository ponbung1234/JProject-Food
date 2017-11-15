<!-- <?php

// if (isset($_GET['fid']))
//     echo $_GET['fid'];
?>
 -->
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Thai Food Delivery</title>
    <link rel="stylesheet" type="text/css" href="vendor/css/food.css">
    <link rel="stylesheet" type="text/css" href="vendor/css/comment.css">
</head>
<body>
    <?php
require_once('menu.php');

    $editid = $_GET['fid'];
    $q = "SELECT * FROM foods WHERE food_id = '$editid'";
    $result = $connect->query($q);
    if(!$result){
        echo "Cannot get current record<br>".$q;
        exit();
    }
    $row = mysqli_fetch_array($result);

    // $name = $_GET['name'];
    // $comment = $_GET['comment'];
    // $submit = $_GET['submit'];

//     if ($connect->query($sql) === TRUE) {
//     echo "New record created successfully";
// }   else {
//     echo "Error: " . $sql . "<br>" . $conn->error;
// }
//     $insert = mysql_query("INSERT INTO comment (com_name,com_comment) VALUE ('name','comment')");


?>



<div class="container" style="width:60%;">

    <h1><?php echo $row["name"]; ?>
    <span class="price-new text-danger">฿<?php echo $row["price"]; ?></span>
    </h1>
                                    <br>
    <img src="<?php echo $row["image"]; ?>" class="img-responsive"
                                 alt="Product Image"
                                 style="width:50%; text-align: center" />
                                 <br>
     <h4>&emsp;<?php echo $row["description"]; ?></h4>
     <br>
<?php 
require_once('comment.php')
 ?>




<!--     <div class="warpper">
        <div class="comment-wrapper">
            <form action="food-info.php" method="POST">
                <table>
                    <tr>
                        <td>Name: </td>
                        <td><input type="text" name="name"/></td>
                    </tr>
                    <tr><td colspan="2">Comment: </td></tr>
                    <tr><td colspan="2"><textarea name="comment"></textarea></td></tr>
                    <tr><td colspan="2"><input type="submit" name="submit" value="comment"></input></td></tr>
                </table>
            </form>
        </div>
    </div>
 -->
 



</div>




</body>
</html>

<script>
    var foodID, btnString = 'cart';

    $(document).ready(function () {
        $(".col-sm-4").fadeIn("slow");
        initialLoad();
    });

    function initialLoad() {
        $('#menu1').addClass('active');
        $('[data-toggle="tooltip"]').tooltip();

        $('button[name="addButton"]').click(function () {
            btnString = 'cart';
            foodID = $(this).val();
        });
        $('button[name="wishButton"]').click(function () {
            foodID = $(this).val();
            btnString = 'wish';
        });
        $('button[name="infoButton"]').click(function () {
            foodID = $(this).val();
            btnString = 'info';
        });

        // Attach a submit handler to the form
        $("#foodsForm").submit(function (event) {
            // Stop form from submitting normally
            event.preventDefault();
            if (!isLogin && btnString !== 'info') {
                swal(
                    'Please login first!',
                    '',
                    'error'
                );
                return;
            }
            // Send the data using post
            var posting;
            if (btnString === 'cart')
                posting = $.post("php-action/add-cart.php", {hidden_id: foodID});
            else if (btnString === 'info')
                window.location = "food-info.php?fid=" + foodID;
            else
                posting = $.post("php-action/add-wishlist.php", {hidden_id: foodID});
            // Put the results in a div
            posting.done(function (data) {
                if (data === "success-cart") {
                    swal(
                        'Added!',
                        'Your selected food has been added to cart',
                        'success'
                    ).then(function () {
                        location.reload();
                    });
                } else if (data === "success-wishlist") {
                    swal(
                        'Added!',
                        'Your selected food has been added to wishlist',
                        'success'
                    );
                } else if (data === "already added to wishlist") {
                    swal(
                        'Food exists!',
                        'This food is ' + data,
                        'warning'
                    );
                } else
                    alert(data)
            });
        });
    }
    $(document).ready(function(){

    
    $("[data-toggle=tooltip]").tooltip();
    });

</script>
