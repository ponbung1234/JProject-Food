<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../vendor/css/food.css">
    <link rel="stylesheet" type="text/css" href="../vendor/css/menu.css">
    <style>
        .col-item .options-cart-round {
            position: absolute;
            right: 55%;
            top: 17%;
            display: none;
        }

        .col-item .options-wishlist-round {
            position: absolute;
            left: 55%;
            top: 17%;
            display: none;
        }
    </style>
    <script>
        var products_JSON = [];
    </script>
</head>
<body>
<?php
require_once('navbar.php');

$query = "SELECT * FROM foods ORDER BY food_id";
$result = mysqli_query($connect, $query);
if (mysqli_num_rows($result) > 0):
    while ($row = mysqli_fetch_array($result)): ?>
        <script>products_JSON.push("<?php echo $row["name"]; ?>");</script>
        <?php
    endwhile;
endif;
?>

<div class="container">
    <form role="search" style="width:60%;" class="col-xs-offset-2 col-md-offset-2">
        <div class="input-group">
            <input class="form-control" placeholder="Search" id="foodSearch" data-provide="autocomplete"
                   autocomplete="off">
            <div class="input-group-btn">
                <button id="searchButton" class="btn btn-default"><i
                            class="glyphicon glyphicon-search"></i></button>
            </div>
        </div>
    </form>

    <h2 align="center">Select food to edit/remove</h2><br>
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
                                <button name="editButton" class="btn btn-default" title="Edit"
                                        data-toggle="tooltip" value="<?php echo $row["food_id"]; ?>">
                                    <span class="fa fa-pencil-square-o"></span>
                                </button>
                            </div>
                            <div class="options-wishlist-round">
                                <button name="removeButton" class="btn btn-default" title="Remove"
                                        data-toggle="tooltip" value="<?php echo $row["food_id"]; ?>">
                                    <span class="fa fa-trash"></span>
                                </button>
                            </div>
                            <img src="../<?php echo $row["image"]; ?>" class="img-responsive"
                                 alt="Product Image"/>
                        </div>
                        <div class="info">
                            <div class="row">
                                <div class="price-details col-md-6">
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

<script src="../vendor/js/jquery.autocomplete.min.js"></script>
<script>
    $('button[name="editButton"]').click(function (e) {
        var food_id = $(this).val();
        window.location.href = "edit-food.php?id=" + food_id;
    });

    $(document).ready(function () {
        $("#foodsForm").submit(function (event) {
            // Stop form from submitting normally
            event.preventDefault();
        });

        $('button[name="removeButton"]').click(function (e) {
            var food_id = $(this).val();

            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!'
            }).then(function () {
                var posting = $.post("php-action/remove-food.php", {food_id: food_id});
                posting.done(function (data) {
                    if (data === "success") {
                        swal(
                            'Deleted!',
                            'Your selected food has been deleted.',
                            'success'
                        ).then(function () {
                            location.reload();
                        });
                    }
                });
            })
        });
        initialLoad();
    });

    function initialLoad() {
        $('#menu3').addClass('active');
        $(".col-sm-4").fadeIn("slow");
        $('[data-toggle="tooltip"]').tooltip();

        var foodSearchSelector = $("#foodSearch");
        foodSearchSelector.autocomplete({lookup: products_JSON});

        // After user clicks the suggested one and hit 'enter' or 'search button'.
        var inputVal = foodSearchSelector.val();
        $("#searchButton").click(function (e) {
            e.preventDefault();
            inputVal = foodSearchSelector.val();
            window.location.href = "edit-menu.php?s=" + inputVal;
        });

        // When user types in the search box and hits the enter key.
        foodSearchSelector.keypress(function (event) {
            if (event.which == 13) {
                inputVal = foodSearchSelector.val();
                window.location.href = "edit-menu.php?s=" + inputVal;
            }
        });
    }
</script>
