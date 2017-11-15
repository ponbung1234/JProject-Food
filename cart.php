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
    <div class="col-xs-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="row">
                        <div class="col-xs-6">
                            <h5><span class="glyphicon glyphicon-shopping-cart"></span> Shopping Cart</h5>
                        </div>
                        <div class="col-xs-6">
                            <a href="food.php">
                                <button type="button" class="btn btn-primary btn-sm btn-block">
                                    <span class="glyphicon glyphicon-share-alt"></span> Continue shopping
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $cu_id = $_SESSION["cu_id"];
            $query = "SELECT foods.food_id, name, price, image, quantity FROM foods INNER JOIN cart on foods.food_id = cart.food_id where cu_id = $cu_id";
            $result = mysqli_query($connect, $query);
            $total = 0;
            if (mysqli_num_rows($result) > 0): ?>
            <form id="cartForm" method="post">
                <?php while ($row = mysqli_fetch_array($result)): ?>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-2"><img class="img-responsive" src="<?= $row["image"]; ?>">
                            </div>
                            <div class="col-xs-4">
                                <h4 class="product-name"><strong><?= $row["name"]; ?></strong></h4>
                                <h4>
                                    <small>Food description</small>
                                </h4>
                            </div>
                            <div class="col-xs-6">
                                <div class="col-xs-6 text-right">
                                    <h5><strong><?= $row["price"]; ?> <span class="text-muted">x</span></strong>
                                    </h5>
                                </div>

                                <div class="col-xs-4">
                                    <input name="foodID[]" type="hidden" value="<?= $row['food_id'] ?>">
                                    <input name="quantity[]" class="form-control input-md"
                                           value="<?= $row["quantity"]; ?>" min="1" type="number">
                                </div>
                                <div class="col-xs-2">
                                    <button name="removeButton" value="<?= $row['food_id'] ?>"
                                            class="btn btn-danger">
                                        <span class="glyphicon glyphicon-trash"> </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <?php
                    $total += $row['price'] * $row["quantity"];
                endwhile;
                ?>
                <input type="hidden" name="action" value="updateQty">
                <div class="panel-footer">
                    <div class="row text-center">
                        <div class="col-xs-9">
                            <h4 id="totalPrice" class="text-right">Total <strong>฿ <?= $total ?></strong></h4>
                            <input type="hidden" name="totalPrice" value="<?= $total; ?>">
                        </div>
                        <div class="col-xs-3">
                            <button name="updateTotal" class="btn btn-info btn-block">Update Total Price</button>
                            <button name="checkoutButton" class="btn btn-success btn-block">Checkout</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
    endif;
    ?>
</div>
</body>
</html>

<script>
    var actionSelector = $("input[name='action']");
    var foodID;

    $(document).ready(function () {
        // When user changes input quantity.
        $("input[name^='quantity']").change(function () {
            actionSelector.val("updateQty");
        });

        $('button[name="removeButton"]').click(function () {
            actionSelector.val("remove");
            foodID = $(this).val();
        });

        $('button[name="checkoutButton"]').click(function () {
            actionSelector.val("checkout");
        });

        $("#cartForm").submit(function (event) {
            // Stop form from submitting normally
            event.preventDefault();

            $('<input />').attr('type', 'hidden')
                .attr('name', "food_id")
                .attr('value', foodID)
                .appendTo('#cartForm');

            var form_data = new FormData(document.getElementById("cartForm"));

            $.ajax({
                url: "php-action/cart-action.php",
                type: "POST",
                data: form_data,
                processData: false,  // tell jQuery not to process the data
                contentType: false   // tell jQuery not to set contentType
            }).done(function (data) {
                if (actionSelector.val() === "checkout")
                window.location.replace("payment.php?total=" + <?= $total; ?>);
                else {
                    swal('Success!', data, 'success').then(function () {
                        location.reload();
                    });
                }
            });
        });
    });
</script>
