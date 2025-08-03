<?php require_once 'includes/auth.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f9fa;
    }
    .main-content {
      margin-left: 250px;
      padding: 30px;
      transition: all 0.3s;
    }
    .card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      overflow: hidden;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    .card-body {
      padding: 1.5rem;
    }
    .card-text {
      font-weight: 600;
    }
    h2 {
      color: #343a40;
      margin-bottom: 1.5rem;
      font-weight: 600;
      border-bottom: 2px solid #0d6efd;
      padding-bottom: 10px;
      display: inline-block;
    }
    h4 {
      color: #495057;
      margin-bottom: 1.5rem;
      font-weight: 500;
    }
    .bg-primary { background: linear-gradient(135deg, #0d6efd, #3b8cff) !important; }
    .bg-secondary { background: linear-gradient(135deg, #6c757d, #8e9a9d) !important; }
    .bg-success { background: linear-gradient(135deg, #198754, #20c997) !important; }
    .bg-danger { background: linear-gradient(135deg, #dc3545, #ff6b6b) !important; }
    .stat-icon {
      font-size: 2.5rem;
      opacity: 0.2;
      position: absolute;
      right: 20px;
      top: 20px;
    }
    .chart-container {
      background: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
    <h2><i class="bi bi-speedometer2 me-2"></i>Dashboard Overview</h2>
    
    <div class="row mt-4 g-4">
      <div class="col-md-3">
        <div class="card text-white bg-primary mb-3 position-relative">
          <div class="card-body">
            <i class="bi bi-journal-bookmark stat-icon"></i>
            <h5 class="card-title">Total Stories</h5>
            <p class="card-text fs-2 fw-bold"><?= $totalStories ?></p>
            <small class="opacity-75">All published stories</small>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-white bg-secondary mb-3 position-relative">
          <div class="card-body">
            <i class="bi bi-tags stat-icon"></i>
            <h5 class="card-title">Total Categories</h5>
            <p class="card-text fs-2 fw-bold"><?= $totalCategories ?></p>
            <small class="opacity-75">Story categories</small>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-white bg-success mb-3 position-relative">
          <div class="card-body">
            <i class="bi bi-send stat-icon"></i>
            <h5 class="card-title">User Submissions</h5>
            <p class="card-text fs-2 fw-bold"><?= $totalSubmissions ?></p>
            <small class="opacity-75">Pending reviews</small>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-white bg-danger mb-3 position-relative">
          <div class="card-body">
            <i class="bi bi-envelope stat-icon"></i>
            <h5 class="card-title">Contact Messages</h5>
            <p class="card-text fs-2 fw-bold"><?= $totalMessages ?></p>
            <small class="opacity-75">Customer inquiries</small>
          </div>
        </div>
      </div>
    </div>
    
    <div class="mt-5 chart-container">
      <h4><i class="bi bi-bar-chart-line me-2"></i>System Statistics</h4>
      <canvas id="dashboardChart" height="120"></canvas>
    </div>
  </div>

  <script>
    const ctx = document.getElementById('dashboardChart').getContext('2d');
    const chart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Stories', 'Categories', 'Submissions', 'Messages'],
        datasets: [{
          label: 'Total Count',
          data: [<?= $totalStories ?>, <?= $totalCategories ?>, <?= $totalSubmissions ?>, <?= $totalMessages ?>],
          backgroundColor: [
            'rgba(13, 110, 253, 0.7)',
            'rgba(108, 117, 125, 0.7)',
            'rgba(25, 135, 84, 0.7)',
            'rgba(220, 53, 69, 0.7)'
          ],
          borderColor: [
            'rgba(13, 110, 253, 1)',
            'rgba(108, 117, 125, 1)',
            'rgba(25, 135, 84, 1)',
            'rgba(220, 53, 69, 1)'
          ],
          borderWidth: 1,
          borderRadius: 6
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          },
          tooltip: {
            backgroundColor: 'rgba(0,0,0,0.7)',
            titleFont: { size: 14 },
            bodyFont: { size: 12 },
            padding: 12,
            cornerRadius: 6
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: { 
              precision: 0,
              font: {
                weight: 'bold'
              }
            },
            grid: {
              color: 'rgba(0,0,0,0.05)'
            }
          },
          x: {
            grid: {
              display: false
            },
            ticks: {
              font: {
                weight: 'bold'
              }
            }
          }
        }
      }
    });
  </script>
</body>
</html>