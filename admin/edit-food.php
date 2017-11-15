<html lang="en">
<body>
<?php
require_once('navbar.php');

$food_id = $_GET['id'];
$query = "SELECT * FROM foods where food_id = 2 ";
$result = mysqli_query($connect, $query);

if (mysqli_num_rows($result) > 0)
    $row = $result->fetch_array();
?>

<div class="container">
    <form id="editFood" method="post" class="form-horizontal" role="form">
        <div class="form-group">
            <label class="col-sm-3 control-label">Food Name</label>
            <div class="col-sm-9">
                <input name="foodName" value="<?= $row['name'] ?>" placeholder="Food Name" class="form-control"
                       autofocus>
                <span class="help-block">For example, Thai Chicken Basil</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Price</label>
            <div class="col-sm-9">
                <input name="foodPrice" value="<?= $row['price'] ?>" placeholder="Price" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Image File</label>
            <div class="col-sm-9 col-sm-offset-3">
                <div id="image_preview"><img id="previewing" src="../<?= $row['image'] ?>" height="200"></div>
                <div id="message"></div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-9 col-sm-offset-3">
                <button class="btn btn-primary btn-block">Update Food</button>
            </div>
        </div>
        <input name="foodID" value="<?= $row['food_id'] ?>" type="hidden">
    </form> <!-- /form -->
</div> <!-- ./container -->

</body>
</html>

<script>
    $("#editFood").on('submit', (function (e) {
        e.preventDefault();
        $.ajax({
            url: "php-action/editFoodSQL.php", // Url to which the request is send
            type: "POST",             // Type of request to be send, called as method
            data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData: false,        // To send DOMDocument or non processed data file it is set to false
            success: function (data)   // A function to be called if request succeeds
            {
                swal('Updated!', data, 'success');
            }
        });
    }));
</script>