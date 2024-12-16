<?php
$con = mysqli_connect("localhost", "root", "", "meronews");
if ($con) {
   // echo "database";
}
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$selectQuery = "select DISTINCT author.author_name as name  from article,category,author where author.author_id=article.author_id and category.category_id=article.category_id GROUP BY author_name,category_name";
$result = mysqli_query($con, $selectQuery);
?>