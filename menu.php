<link rel="stylesheet" type="text/css" href="vendor/bootstrap-3.3.7-dist/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="vendor/css/sweetalert2.min.css">
<link rel="stylesheet" type="text/css" href="vendor/css/menu.css">
<style>
    #foodSearch {
        width: 410px !important;
    }
</style>

<script src="vendor/js/jquery-3.2.1.min.js"></script>
<script src="vendor/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>

<script src="vendor/js/jquery.autocomplete.min.js"></script>
<script src="vendor/js/sweetalert2.min.js"></script>
<script>
    var products_JSON = [];
</script>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">Thai Food Delivery</a>
        </div>
        <ul class="nav navbar-nav">
            <li id="menu1"><a href="food.php">Select Food</a></li>
            <li>
                <form class="navbar-form" role="search">
                    <div class="input-group">
                        <input class="form-control" placeholder="Search" id="foodSearch" data-provide="autocomplete"
                               autocomplete="off">
                        <div class="input-group-btn">
                            <button id="searchButton" class="btn btn-default"><i
                                        class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </div>
                </form>
            </li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
            <?php
            session_start();
            include_once 'dbconfig.php';

            $query = "SELECT * FROM foods ORDER BY food_id";
            $result = mysqli_query($connect, $query);
            if (mysqli_num_rows($result) > 0):
                while ($row = mysqli_fetch_array($result)): ?>
                    <script>products_JSON.push("<?php echo $row["name"]; ?>");</script>
                    <?php
                endwhile;
            endif;

            if (!isset($_SESSION["cu_id"])): ?>
                <script>var isLogin = false;</script>
                <li><a href="signup.php">Register</a></li>
                <li class="dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown">Log In <span
                                class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-lr" role="menu">
                        <div class="col-lg-12">
                            <div class="text-center"><h3><b>Log In</b></h3></div>
                            <form id="loginForm" method="post">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input name="email" type="email" tabindex="1" class="form-control"
                                           placeholder="Email" value="" autocomplete="off" required>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" tabindex="2"
                                           class="form-control" placeholder="Password" autocomplete="off" required>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <!--<div class="col-xs-7">
                                            <input type="checkbox" tabindex="3" name="remember" id="remember">
                                            <label for="remember"> Remember Me</label>
                                        </div>-->
                                        <div class="col-xs-5 pull-right">
                                            <input type="submit" id="login-submit" tabindex="4"
                                                   class="form-control btn btn-success" value="Log In">
                                        </div>
                                    </div>
                                </div>

                                <!--<div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="text-center">
                                                <a href="http://phpoll.com/recover" tabindex="5"
                                                   class="forgot-password">Forgot Password?</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>-->
                            </form>
                        </div>
                    </ul>
                </li>
            <?php
            // If a user has logged in.
            else: ?>
                <script>var isLogin = true;</script>
                <li>
                    <button id="wishBtn" class="btn btn-default btn-lg btn-link">
                        <span class="glyphicon glyphicon-heart"></span>
                    </button>
                </li>
                <li>
                    <button id="cartBtn" class="btn btn-default btn-lg btn-link">
                        <span class="glyphicon glyphicon-shopping-cart"></span>
                    </button>
                    <span class="badge badge-notify"><?php
                        $cu_id = $_SESSION["cu_id"];
                        $query = "select COUNT(cart_id) from cart where cu_id = $cu_id";
                        $result = mysqli_query($connect, $query);
                        $row = mysqli_fetch_array($result);
                        $items_count = $row['COUNT(cart_id)'];
                        echo $items_count ?>
                </span>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-user"></span> 
                        <strong><?= $_SESSION['name']; ?></strong>
                        <span class="glyphicon glyphicon-chevron-down"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <div class="navbar-login">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <p class="text-center">
                                            <span class="glyphicon glyphicon-user icon-size"></span>
                                        </p>
                                    </div>
                                    <div class="col-lg-8">
                                        <p class="text-left"><strong><?= $_SESSION['name']; ?></strong></p>
                                        <p class="text-left small"><?= $_SESSION['email'] ?></p>
                                        <p class="text-left">
                                            <button name="logoutButton" class="btn btn-primary btn-block btn-sm">Logout
                                            </button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="navbar-login navbar-login-session">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <p>
                                            <a href="profile.php" class="btn btn-primary btn-block">My Profile</a>
                                            <a href="profile.php" class="btn btn-danger btn-block">Change Password</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<script>
    $("#loginForm").on("submit", function (event) {
        event.preventDefault();
        $.post("php-action/login.php", $(this).serialize(), function (data) {
            if (data !== "login success")
                swal('Oops!', 'Incorrect email or password', 'error');
            else
                window.location.href = "food.php";
        });
    });

    $('#cartBtn').click(function () {
        window.location.replace("cart.php");
    });

    $('#wishBtn').click(function () {
        window.location.replace("wishlist.php");
    });

    $("button[name=logoutButton]").click(function () {
        $.post("php-action/logout.php", function (data) {
            window.location.href = "food.php";
        });
    });

    var foodSearchSelector = $("#foodSearch");
    foodSearchSelector.autocomplete({lookup: products_JSON});

    // After user clicks the suggested one and hit 'enter' or 'search button'.
    var inputVal = foodSearchSelector.val();
    $("#searchButton").click(function (e) {
        e.preventDefault();
        inputVal = foodSearchSelector.val();
        window.location.href = "food.php?s=" + inputVal;
    });

    // When user types in the search box and hits the enter key.
    foodSearchSelector.keypress(function (event) {
        if (event.which == 13) {
            inputVal = foodSearchSelector.val();
            window.location.href = "food.php?s=" + inputVal;
        }
    });
</script>