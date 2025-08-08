<?php
require_once 'includes/db.php';
$slug = $_GET['slug'] ?? '';
$stmt = $pdo->prepare("SELECT * FROM businesses WHERE slug = ?");
$stmt->execute([$slug]);
$biz = $stmt->fetch();
if (!$biz) { header("HTTP/1.0 404 Not Found"); exit; }

$metaTitle = htmlspecialchars($biz['seo_title'] ?: $biz['name']);
$metaDesc  = htmlspecialchars($biz['meta_description'] ?: substr(strip_tags($biz['description']), 0, 150));

// Fetch related services
$services = $pdo->query("SELECT * FROM services ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $metaTitle ?></title>
  <meta name="description" content="<?= $metaDesc ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <style>
    .service-card {
      transition: all 0.3s ease;
      border-radius: 0.5rem;
      overflow: hidden;
    }
    .service-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .service-img {
      height: 180px;
      object-fit: cover;
      transition: transform 0.5s ease;
    }
    .service-card:hover .service-img {
      transform: scale(1.05);
    }
    .btn-service {
      background-color: #fd7e14;
      border-color: #fd7e14;
    }
    .btn-service:hover {
      background-color: #e67312;
      border-color: #e67312;
    }
  </style>
</head>
<body class="bg-light">
  <?php include 'includes/header.php'; ?>
  
  <main class="container my-4 my-lg-5">
    <!-- Back button -->
    <a href="businesses.php" class="btn btn-outline-secondary mb-4 d-inline-flex align-items-center">
      <i class="bi bi-arrow-left me-2"></i> Back to Businesses
    </a>
    
    <!-- Business Details -->
    <div class="row g-4 mb-5">
      <div class="col-lg-4">
        <?php if ($biz['image']): ?>
          <img src="<?= $biz['image'] ?>" 
               alt="<?= htmlspecialchars($biz['name']) ?>" 
               class="img-fluid rounded-3 shadow mb-3 w-100">
        <?php endif; ?>
        <div class="bg-white p-4 rounded-3 shadow-sm">
          <h2 class="h4">Business Details</h2>
          <ul class="list-unstyled">
            <li class="mb-2"><strong>Type:</strong> <?= htmlspecialchars($biz['type']) ?></li>
            <?php if ($biz['address']): ?>
              <li class="mb-2"><strong>Address:</strong> <?= htmlspecialchars($biz['address']) ?></li>
            <?php endif; ?>
            <?php if ($biz['phone']): ?>
              <li class="mb-2"><strong>Phone:</strong> <?= htmlspecialchars($biz['phone']) ?></li>
            <?php endif; ?>
            <?php if ($biz['email']): ?>
              <li class="mb-2"><strong>Email:</strong> <?= htmlspecialchars($biz['email']) ?></li>
            <?php endif; ?>
            <?php if ($biz['website']): ?>
              <li class="mb-2"><strong>Website:</strong> <a href="<?= htmlspecialchars($biz['website']) ?>" target="_blank">Visit Site</a></li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
      <div class="col-lg-8">
        <h1 class="display-5 fw-bold mb-3"><?= htmlspecialchars($biz['name']) ?></h1>
        <div class="bg-white p-4 rounded-3 shadow-sm">
          <?= nl2br(htmlspecialchars($biz['description'])) ?>
        </div>
      </div>
    </div>

    <!-- Services Section - Mobile Optimized -->
    <?php if (!empty($services)): ?>
      <section class="mb-5">
        <h2 class="h4 mb-4 pb-2 border-bottom d-flex align-items-center">
          <i class="bi bi-stars me-2 text-orange"></i>
          Related Services
        </h2>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
          <?php foreach ($services as $service): ?>
            <div class="col">
              <div class="card h-100 border-0 shadow-sm service-card">
                <?php if (!empty($service['image'])): ?>
                  <img src="<?= htmlspecialchars($service['image']) ?>" 
                       class="card-img-top service-img" 
                       alt="<?= htmlspecialchars($service['name']) ?>"
                       loading="lazy">
                <?php endif; ?>
                <div class="card-body p-3 d-flex flex-column">
                  <h5 class="card-title fs-6 mb-2"><?= htmlspecialchars($service['name']) ?></h5>
                  <p class="card-text small text-muted mb-3 flex-grow-1"><?= htmlspecialchars($service['short_description']) ?></p>
                  <a href="contact.php" class="btn btn-sm btn-primary mt-auto">Get Service</a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </section>
    <?php endif; ?>
  </main>

  <?php include 'includes/footer.php'; ?>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>