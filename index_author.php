<?php
require("db.php");

?>
<!DOCTYPE html>
<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

<head>
    <!-- <script>
        function okey() {
            var select = document.getElementById('select');
            var display = select.options[select.selectedIndex].text;
            console.log(display);

        }
    </script> -->
    <style>
   *{
     background-color: #d5dbe3;
     /* padding-right: 20px; */
   }
 </style>
    <style>

    </style>
</head>

<body>
    <div id="wrapper">
        <div class="container mt-5 mb-5">
            <div class="col-lg-12">
                <h3 style="text-align:center; text-decoration:underline;">VIEW REPORT ACCORDING TO SPECIFIC AUTHOR</h3>
            </div>
            <div class="select">
                <h5 style="text-align:center; text-decoration:underline; text-decoration-style: dotted; padding:5px;">Please select the author </h5>

                <form action="" method="post">

                    <select name="opt" style="display: block;
   margin: auto;">
                        <option> --Select Name--</option>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                                $name = $row['name'];
                                echo "<option><br>$name<br></option>";
                            }
                        }
                        ?>
                    </select>
                    <input type="submit" name="submit" value="submit" style="display: block;
   margin: auto; margin-top:5px;">
                </form>
                <?php
                if (isset($_POST['submit'])) {
                    if (!empty($_POST['opt'])) {
                        $selected = $_POST['opt'];
                       ?> <h5 style="text-align:center; margin-top: 5px; color:#AF4501 ;" > You have selected  <?php echo $selected;?></53><?php
                    } else {
                        echo $selected = 'sunita';
                    }
                }

                ?>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <!-- Chart 1 start -->
                    <div id="barchart-1" style="width: 430px; height: 280px;"></div>
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

                            $sql = "select  category.category_name as news, COUNT(article.article_id) as total  
                            from article,category,author where author.author_id=article.author_id and 
                            category.category_id=article.category_id and author.author_name='$selected' GROUP BY author_name,category_name ";
                            $fire = mysqli_query($con, $sql);
                            while ($result = mysqli_fetch_assoc($fire)) {
                                echo "['" . $result['news'] . "'," . $result['total'] . "],";
                            }
                            ?>
                            // sql data fetch ends......
                        ]);
                        var options = {
                            title: 'Total Article According to Category',

                        };
                        var chart = new google.visualization.BarChart(document.getElementById('barchart-1'));
                        chart.draw(data, options);
                    }
                </script>

                <!-- Chart 1 ends -->
                <!-- Chart 2 start -->
                <div class="form-group col-md-4">
                    <div id="piechart-6" style="width: 430px; height: 280px; "></div>
                </div>
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                    google.charts.load('current', {
                        'packages': ['corechart']
                    });
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                            ['Category', 'No of Article'],
                            // sql data fetch start......
                            <?php

                            $sql = "select  category.category_name as news, COUNT(article.article_id) as total 
                             from article,category,author where author.author_id=article.author_id 
                            and category.category_id=article.category_id and author.author_name='$selected' GROUP BY author_name,category_name ";

                            $fire = mysqli_query($con, $sql);
                            while ($result = mysqli_fetch_assoc($fire)) {
                                echo "['" . $result['news'] . "'," . $result['total'] . "],";
                            }
                            ?>
                            // sql data fetch end......
                        ]);
                        var options = {
                            title: 'Presentation of chart No 1 to Pie-chart',
                            is3D: true,
                        };
                        var chart = new google.visualization.PieChart(document.getElementById('piechart-6'));
                        chart.draw(data, options);
                    }
                </script>
                <!-- Chart 2 ends -->
                <!-- Chart 3 start -->
                <div class="form-group col-md-4">
                    <div id="piechart-3" style="width:430px; height: 280px;"></div>
                </div>
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                    google.charts.load('current', {
                        'packages': ['corechart']
                    });
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                            ['Trending ', 'Trending'],
                            <?php
                            $sql =  "select category.category_name as name , count(article.article_id) as total 
                             from article,category,author where author.author_id=article.author_id and
                             category.category_id=article.category_id and author.author_name='$selected' and article.article_trend='1' GROUP BY category.category_name";
                            $fire = mysqli_query($con, $sql);
                            while ($result = mysqli_fetch_assoc($fire)) {
                                echo "['" . $result['name'] . "'," . $result['total'] . "],";
                            }
                            ?>
                        ]);
                        var options = {
                            title: 'Trending Article',
                            pieHole: 0.4,
                        };
                        var chart = new google.visualization.PieChart(document.getElementById('piechart-3'));
                        chart.draw(data, options);
                    }
                </script>
            </div>
            <!-- Chart 3 end -->
            <br><br>
            <!-- Chart 4 starts -->
            <div class="form-row">
                
                <!-- Chart 4 ends -->

                <!-- Chart 5 Start -->
                <div class="form-group col-md-4">
                    <div id="columnchart" style="width: 600px; height: 400px;"></div>
                </div>
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                    google.charts.load('current', {
                        'packages': ['corechart']
                    });
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                            ['Category', 'No of Article'],
                            // sql data fetch start......
                            <?php
                            $sql = "select category.category_name as name , count(article.article_id) as total  
                            from article,category,author where author.author_id=article.author_id and category.category_id=article.category_id and
                             author.author_name='$selected' and article.article_active='0' GROUP BY category.category_name";
                            $fire = mysqli_query($con, $sql);
                            while ($result = mysqli_fetch_assoc($fire)) {
                                echo "['" . $result['name'] . "'," . $result['total'] . "],";
                            }
                            ?>
                            // sql data fetch end......
                        ]);
                        var options = {
                            title: 'Total In-Active Article',
                            // is3D: true,
                            pieHole: 0.4,
                        };
                        var chart = new google.visualization.PieChart(document.getElementById('columnchart'));
                        chart.draw(data, options);
                    }
                </script>
            </div>
            <!-- Chart 5 ends -->
            <!-- <script admin lte cdn for div row. you can use bootstrap start -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css" />
            <!-- <script cdn ends -->
</body>

</html>