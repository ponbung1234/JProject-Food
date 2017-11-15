<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Thai Food Delivery</title>
</head>
<body>
<?php
require_once('menu.php');
?>

<div class="container" style="width:60%;">
    <h2 align="center">Select food</h2>
    <?php
    if (!isset($_GET['input-product']))
        $query = "SELECT * FROM foods ORDER BY food_id";
    else {
        $input_product = $_GET['input-product'];
        $query = "SELECT * FROM foods WHERE name LIKE '%$input_product%'";
    }

    $result = mysqli_query($connect, $query); ?>
    <form method="post" id="foodsForm">
        <?php
        if (mysqli_num_rows($result) > 0):
            while ($row = mysqli_fetch_array($result)):
                ?>
                <div class="col-md-6">
                    <div style="border: 1px solid #eaeaec; margin: -1px 19px 3px -1px; box-shadow: 0 15px 30px rgba(0,0,0,0.05); padding:10px;"
                         align="center">
                        <img src="<?php echo $row["image"]; ?>" class="img-responsive">
                        <h5 class="text-info"><?php echo $row["name"]; ?></h5>
                        <h5 class="text-danger">฿<?php echo $row["price"]; ?></h5>
                        <button name="addButton" style="margin-top:5px;" class="btn btn-success"
                                value="<?php echo $row["food_id"]; ?>"> Add to Cart
                        </button>
                        <button name="wishButton" style="margin-top:5px;" class="btn btn-info"
                                value="<?php echo $row["food_id"]; ?>"> Add to Wishlist
                        </button>
                    </div>

                </div>
                <?php
            endwhile;
        endif;
        ?>
    </form>
</div>
</body>
</html>

<script>
    var foodID, btnString = 'cart';

    $(document).ready(function () {
        initialLoad();
    });

    function initialLoad() {
        $('button[name="addButton"]').click(function () {
            foodID = $(this).val();
        });
        $('button[name="wishButton"]').click(function () {
            foodID = $(this).val();
            btnString = 'wish';
        });
        // Attach a submit handler to the form
        $("#foodsForm").submit(function (event) {
            // Stop form from submitting normally
            event.preventDefault();
            // Send the data using post
            if (btnString === 'cart')
                var posting = $.post("php-action/add-cart.php", {hidden_id: foodID});
            else
                var posting = $.post("php-action/add-wishlist.php", {hidden_id: foodID});
            // Put the results in a div
            posting.done(function (data) {
                alert(data);
                location.reload();
            });
        });

        $('#menu1').addClass('active');
    }
</script>
