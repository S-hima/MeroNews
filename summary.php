<?php
require('./includes/nav.inc.php');

// Fetch data from the database for charts
$total_articles = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as count FROM article"))['count'];
$categories = mysqli_query($con, "SELECT category_name, COUNT(article_id) as count FROM article INNER JOIN category ON article.category_id = category.category_id GROUP BY article.category_id");
$authors = mysqli_query($con, "SELECT author_name, COUNT(article_id) as count FROM article INNER JOIN author ON article.author_id = author.author_id GROUP BY article.author_id ORDER BY count DESC LIMIT 5");
$articles_by_date = mysqli_query($con, "SELECT article_date, COUNT(article_id) as count FROM article GROUP BY article_date ORDER BY article_date ASC");

?>

<section id="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li><a href="./index.php">Dashboard</a></li>
      <li class="active">Summary</li>
    </ol>
  </div>
</section>

<section id="main">
  <div class="container">
    <div class="row">
      <?php require('./includes/quick-links.inc.php'); ?>
      <div class="col-md-9">
        <div class="panel panel-default">
          <div class="panel-heading main-color-bg">
            <h3 class="panel-title">Summary Dashboard</h3>
          </div>
          <div class="panel-body">
            <h4>Total Articles: <?php echo $total_articles; ?></h4>
            
            <!-- Chart Containers -->
            <div class="chart-container">
              <canvas id="categoryChart"></canvas>
            </div>

            <div class="chart-container">
              <canvas id="authorChart"></canvas>
            </div>

            <div class="chart-container">
              <canvas id="dateChart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Data for Category Chart
  const categoryData = {
    labels: [<?php while ($cat = mysqli_fetch_assoc($categories)) { echo '"' . $cat['category_name'] . '",'; } ?>],
    datasets: [{
      label: 'Number of Articles by Category',
      data: [<?php mysqli_data_seek($categories, 0); while ($cat = mysqli_fetch_assoc($categories)) { echo $cat['count'] . ','; } ?>],
      backgroundColor: 'rgba(54, 162, 235, 0.6)',
      borderColor: 'rgba(54, 162, 235, 1)',
      borderWidth: 1
    }]
  };

  // Data for Author Chart
  const authorData = {
    labels: [<?php while ($author = mysqli_fetch_assoc($authors)) { echo '"' . $author['author_name'] . '",'; } ?>],
    datasets: [{
      label: 'Top Authors by Article Count',
      data: [<?php mysqli_data_seek($authors, 0); while ($author = mysqli_fetch_assoc($authors)) { echo $author['count'] . ','; } ?>],
      backgroundColor: 'rgba(255, 99, 132, 0.6)',
      borderColor: 'rgba(255, 99, 132, 1)',
      borderWidth: 1
    }]
  };

  // Data for Articles by Date Chart
  const dateData = {
    labels: [<?php while ($date = mysqli_fetch_assoc($articles_by_date)) { echo '"' . $date['article_date'] . '",'; } ?>],
    datasets: [{
      label: 'Articles Posted Over Time',
      data: [<?php mysqli_data_seek($articles_by_date, 0); while ($date = mysqli_fetch_assoc($articles_by_date)) { echo $date['count'] . ','; } ?>],
      backgroundColor: 'rgba(75, 192, 192, 0.6)',
      borderColor: 'rgba(75, 192, 192, 1)',
      borderWidth: 1
    }]
  };

  // Configurations and Rendering for Charts
  const configCategory = {
    type: 'bar',
    data: categoryData,
    options: {
      scales: {
        y: { beginAtZero: true }
      }
    }
  };

  const configAuthor = {
    type: 'bar',
    data: authorData,
    options: {
      scales: {
        y: { beginAtZero: true }
      }
    }
  };

  const configDate = {
    type: 'line',
    data: dateData,
    options: {
      scales: {
        y: { beginAtZero: true }
      }
    }
  };

  // Initialize Charts
  new Chart(document.getElementById('categoryChart'), configCategory);
  new Chart(document.getElementById('authorChart'), configAuthor);
  new Chart(document.getElementById('dateChart'), configDate);
</script>

<?php require('./includes/footer.inc.php'); ?>
