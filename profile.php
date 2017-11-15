<!doctype html>
<html>
<head>
    <title>User profile</title>
    <?php require_once('menu.php');
    $cu_id = $_SESSION["cu_id"];
    $query = "SELECT * FROM customer where cu_id = $cu_id";
    $result = mysqli_query($connect, $query);
    $row = mysqli_fetch_array($result); ?>
</head>
<body>
<div class="container">
    <h1 class="page-header">Edit Profile</h1>
    <div class="row">
        <!-- left column -->
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="text-center">
                <img src="images/programmer.png" class="avatar img-circle img-thumbnail" alt="avatar">
                <!--<h6>Upload a different photo...</h6>
                <input type="file" class="text-center center-block well well-sm">-->
            </div>
        </div>
        <!-- edit form column -->
        <div class="col-md-8 col-sm-6 col-xs-12 personal-info">
            <!--<div class="alert alert-info alert-dismissable">
                <a class="panel-close close" data-dismiss="alert">×</a>
                <i class="fa fa-coffee"></i>
                This is an <strong>.alert</strong>. Use this to show important messages to the user.
            </div>-->
            <h3>Personal info</h3>
            <form id="profileForm" method="post" class="form-horizontal">
                <div class="form-group">
                    <label class="col-lg-3 control-label">Name:</label>
                    <div class="col-lg-8">
                        <input name="name" class="form-control" value="<?= $row['name'] ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Email:</label>
                    <div class="col-lg-8">
                        <input name="email" class="form-control" value="<?= $row['email'] ?>" type="email" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Address:</label>
                    <div class="col-lg-8"><textarea name="address" class="form-control"
                                                    rows="4"><?= $row['address'] ?></textarea></div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Password:</label>
                    <div class="col-md-8">
                        <input name="password" class="form-control" value="<?= $row['password'] ?>" type="password"
                               required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Confirm password:</label>
                    <div class="col-md-8">
                        <input class="form-control" value="<?= $row['password'] ?>" type="password" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                        <input name="save" class="btn btn-primary" value="Save Changes" type="submit">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>

<script>
    $(document).ready(function () {
        $("#profileForm").submit(function (event) {
            // Stop form from submitting normally
            event.preventDefault();

            var form_data = new FormData(document.getElementById("profileForm"));

            $.ajax({
                url: "php-action/update-profile.php",
                type: "POST",
                data: form_data,
                processData: false,  // tell jQuery not to process the data
                contentType: false   // tell jQuery not to set contentType
            }).done(function (data) {
                if (data == "success")
                    swal(
                        'Updated!',
                        'Your account profile has been updated!',
                        'success'
                    ).then(function () {
                        location.reload();
                    });
                else {
                    swal(data);
                }
            });
        });

        $("input[name='name']").bind('keyup blur', function () {
                var node = $(this);
                node.val(node.val().replace(/[^A-Za-z\s]/g, ''));
            }
        );
    });
</script>