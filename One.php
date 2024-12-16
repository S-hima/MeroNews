<?php
require("db.php");

?>
<!DOCTYPE html>
<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

<head>
<style>
   *{
     background-color: #d5dbe3;
     /* margin: 3px; */
     /* padding: 5px; */
     /* padding-right: 20px; */
    
   }
 </style>
</head>

<body>
    <h1 style="text-align:center; text-decoration:underline; "> REPORTING DASHBOARD</h1>
    <div id="wrapper">
        <div class="container mt-5 mb-5">
            <div class="col-lg-12">
                
            <div class="form-row">
                <div class="">
                    <!-- Chart 1 start -->
                    <div id="barchart-100" style="width: 430px; height: 380px;"></div>
                </div>
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                    google.charts.load('current', {
                        'packages': ['corechart']
                    });
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                            ['Category Name', 'Total Article'],
                            // sql data fetch start......

                            
                            <?php
                            
                            $sql = "select author.author_name AS name,count(article.article_id) AS total
                            from article,author where author.author_id=article.author_id GROUP BY author_name";
                            $fire = mysqli_query($con, $sql);
                            while ($result = mysqli_fetch_assoc($fire)) {
                                echo "['" . $result['name'] . "'," . $result['total'] . "],";
                            }
                            ?>
                            // sql data fetch ends......
                        ]);
                        var options = {
                            title: 'Total Article According to Category'
                        };
                        var chart = new google.visualization.PieChart(document.getElementById('barchart-100'));
                        chart.draw(data, options);
                    }
                </script>

                <!-- Chart 1 ends -->
                <!-- Chart 2 start -->
                <div class="form-group col-md-4">
                    <div id="piechart-100" style="width: 530px; height: 380px;"></div>
                </div>
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                    google.charts.load('current', {
                        'packages': ['corechart']
                    });
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                            ['Category', 'Total Article'],
                            // sql data fetch start......
                            <?php
                            
                            $sql = "select author.author_name AS name,count(article.article_id)
                             AS total from article,author where author.author_id=article.author_id GROUP BY author_name";
                            
                            $fire = mysqli_query($con, $sql);
                            while ($result = mysqli_fetch_assoc($fire)) {
                                echo "['" . $result['name'] . "'," . $result['total'] . "],";
                            }
                            ?>
                            // sql data fetch end......
                        ]);
                        var options = {
                            title: 'Total article of All Author',
                            is3D: true,
                        };
                        var chart = new google.visualization.ColumnChart(document.getElementById('piechart-100'));
                        chart.draw(data, options);
                    }
                </script>
                <!-- Chart 2 ends -->
               
            <!-- Chart 5 ends -->
            <!-- <script admin lte cdn for div row. you can use bootstrap start -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css" />
            <!-- <script cdn ends -->
</body>

</html>