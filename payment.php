<!doctype html>
<html>
<body>
<?php
require_once('menu.php');
?>
<div class="container">
    <div class="row">
        <?php
        $cu_id = $_SESSION["cu_id"];
        $query = "SELECT address FROM customer where cu_id = $cu_id";
        $result = mysqli_query($connect, $query);
        if ($connect->query($query) === FALSE)
            echo "failed!";
        $row = mysqli_fetch_array($result);
        ?>
        <form id="paymentForm" method="post" action="php-action/payment.php">
            <div class="col-xs-12 col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"> Payment Details </h3>
                        <div class="checkbox pull-right">
                            <input name="remem" type="checkbox" value="1">Remember
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="address">TO ADDRESS:</label>
                            <textarea class="form-control" rows="3" id="address" name="address"
                                      required><?= $row['address'] ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="cardNumber"> CARD NUMBER</label>
                            <div class="input-group">
                                <input onkeypress="return isNumber(event)" class="form-control" id="cardNumber"
                                       placeholder="Valid Card Number"
                                       required autofocus/>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-7 col-md-7">
                                <div class="form-group">
                                    <label for="expityMonth"> EXPIRY DATE</label>
                                    <div class="col-xs-6 col-lg-6 pl-ziro">
                                        <input onkeypress="return isNumber(event)" class="form-control" id="expityMonth"
                                               placeholder="MM"
                                               required maxlength="2"/>
                                    </div>
                                    <div class="col-xs-6 col-lg-6 pl-ziro">
                                        <input onkeypress="return isNumber(event)" class="form-control" id="expityYear"
                                               placeholder="YYYY"
                                               required maxlength="4"/></div>
                                </div>
                            </div>
                            <div class="col-xs-5 col-md-5 pull-right">
                                <div class="form-group">
                                    <label for="cvCode"> CV CODE</label>
                                    <input type="password" class="form-control" id="cvCode" placeholder="CV" required/>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <ul class="nav nav-pills nav-stacked">
                    <li class="active"><a href="#"><span class="badge pull-right">฿<?= $_GET['total']; ?></span>Total
                            Price</a>
                    </li>
                </ul>
                <br/>
                <button class="btn btn-success btn-lg btn-block">Pay</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
<script>
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>
<style>
    a {
        cursor: default;
    }

    .panel-title {
        display: inline;
        font-weight: bold;
    }

    .checkbox.pull-right {
        margin: 0;
    }

    .pl-ziro {
        padding-left: 0;
    }
</style>