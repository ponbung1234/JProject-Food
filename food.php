<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Thai Food Delivery</title>
    <link rel="stylesheet" type="text/css" href="vendor/css/food.css">
</head>
<body>
<?php
require_once('menu.php');

if (isset($_POST['Register'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $query = "INSERT INTO customer (email, password, name) VALUES('$email', '$password', '$name')";
    $connect->query($query);
//    if ($connect->query($query) === TRUE)
//        echo "success";
}
?>
<script src="vendor/js/jquery.slides.min.js"></script>
<div class="container">
    <div id="slides">
        <img src="images/promo1.jpg">
        <img src="images/promo2.jpg">
        <img src="images/promo3.png">
    </div>
</div>

<div class="container">
    <h2 align="center">Select food</h2><br>
    <?php
    if (!isset($_GET['s']))
        $query = "SELECT * FROM foods ORDER BY food_id";
    else {
        $food_name = $_GET['s'];
        $query = "SELECT * FROM foods WHERE name LIKE '%$food_name%'";
    }

    $result = mysqli_query($connect, $query); ?>
    <form method="post" id="foodsForm">
        <?php
        if (mysqli_num_rows($result) > 0):
            while ($row = mysqli_fetch_array($result)):
                ?>
                <div class="col-md-3 col-sm-4 col-xs-6 col-xss-12 food-col">
                    <article class="col-item">
                        <div class="photo">
                            <div class="options-cart-round">
                                <button name="addButton" class="btn btn-default" title="Add to cart"
                                        data-toggle="tooltip" value="<?php echo $row["food_id"]; ?>">
                                    <span class="fa fa-shopping-cart"></span>
                                </button>
                            </div>
                            <div class="options-wishlist-round">
                                <button name="wishButton" class="btn btn-default" title="Add to wishlist"
                                        data-toggle="tooltip" value="<?php echo $row["food_id"]; ?>">
                                    <span class="fa fa-heart"></span>
                                </button>
                            </div>
                            <div class="options-info-round">
                                <button name="infoButton" class="btn btn-default" title="More info"
                                        data-toggle="tooltip" value="<?php echo $row["food_id"]; ?>">
                                    <span class="fa fa-search"></span>
                                </button>
                            </div>
                            <img src="<?php echo $row["image"]; ?>" class="img-responsive"
                                 alt="Product Image"/>
                        </div>
                        <div class="info">
                            <div class="row">
                                <div class="price-details col-md-6">
                                    <!--                                    <p class="details"> Lorem ipsum dolor sit amet, consectetur.. </p>-->
                                    <h1><?php echo $row["name"]; ?></h1>
                                    <br>
                                    <span class="price-new text-danger">฿<?php echo $row["price"]; ?></span>
                                </div>
                            </div>
                        </div>
                    </article>
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
        $(".col-sm-4").fadeIn("slow");
        slideShow();
        initialLoad();
    });

    function slideShow() {
        $("#slides").slidesjs({
            width: 740, //Original 940
            height: 240, //Original 528
            play: {
                active: true,
                auto: true,
                interval: 4000,
                swap: true
            }
        });
    }

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
</script>
