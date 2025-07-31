<?php require_once 'includes/auth.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
    }
    .main-content {
      margin-left: 250px; /* width of sidebar */
      padding: 30px;
    }
  </style>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <?php include 'includes/sidebar.php'; ?>

  <div class="main-content">
    <?php
      require_once '../includes/db.php';
      $totalStories = $pdo->query("SELECT COUNT(*) FROM stories")->fetchColumn();
      $totalCategories = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
      $totalSubmissions = $pdo->query("SELECT COUNT(*) FROM submissions")->fetchColumn();
      $totalMessages = $pdo->query("SELECT COUNT(*) FROM messages")->fetchColumn();
    ?>
    <h2>Welcome to Admin Dashboard</h2>
    <div class="row mt-4">
      <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
          <div class="card-body">
            <h5>Total Stories</h5>
            <p class="card-text fs-4"><?= $totalStories ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-white bg-secondary mb-3">
          <div class="card-body">
            <h5>Total Categories</h5>
            <p class="card-text fs-4"><?= $totalCategories ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
          <div class="card-body">
            <h5>User Submissions</h5>
            <p class="card-text fs-4"><?= $totalSubmissions ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-white bg-danger mb-3">
          <div class="card-body">
            <h5>Contact Messages</h5>
            <p class="card-text fs-4"><?= $totalMessages ?></p>
          </div>
        </div>
      </div>
    </div>
    <div class="mt-5">
  <h4>System Overview</h4>
  <canvas id="dashboardChart" height="120"></canvas>
</div>

  </div>
</body>
<script>
  const ctx = document.getElementById('dashboardChart').getContext('2d');
  const chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Stories', 'Categories', 'Submissions', 'Messages'],
      datasets: [{
        label: 'Total Count',
        data: [<?= $totalStories ?>, <?= $totalCategories ?>, <?= $totalSubmissions ?>, <?= $totalMessages ?>],
        backgroundColor: ['#0d6efd', '#6c757d', '#198754', '#dc3545']
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          ticks: { precision: 0 }
        }
      }
    }
  });
</script>

</html>
