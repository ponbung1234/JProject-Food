<!doctype html>
<html>
<head>
    <script src="../vendor/js/Chart.bundle.min.js"></script>
    <style>
        canvas {
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
        }
    </style>
</head>

<body>
<?php
require_once('navbar.php'); ?>

<script>
    var month = [];
    var quantity = [];
</script>

<?php $query = "select monthname(orderDate) as monthName, sum(quantity) as qty from orders group by monthname(orderDate) order by orderDate";
$result = mysqli_query($connect, $query);
if (mysqli_num_rows($result) > 0):
    while ($row = mysqli_fetch_array($result)): ?>
        <script>
            // month = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            month.push("<?= $row['monthName'] ?>");
            // data = [12, 19, 3, 5, 2, 3, 8, 20, 10, 11, 15, 22];
            quantity.push("<?= $row['qty'] ?>");
        </script>
    <?php endwhile;
endif;
?>
<br>
<div class="container">
    <div class="col-md-2 col-md-offset-1">
        <div class="chart-container" style="position: relative; height:40vh; width:60vw">
            <canvas id="myChart"></canvas>
        </div>
    </div>
</div>
</body>
</html>

<script>
    $('#menu4').addClass('active');
    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: month,
            datasets: [{
                label: '# of Sales',
                data: quantity,
                backgroundColor: 'rgb(64, 108, 249)',
                borderColor: 'rgb(64, 108, 249)',
                fill: false
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>
