<?php
require_once 'includes/db.php';

$slug = $_GET['slug'] ?? '';
$stmt = $pdo->prepare("SELECT * FROM businesses WHERE slug = ?");
$stmt->execute([$slug]);
$biz = $stmt->fetch();

if (!$biz) { 
    header("HTTP/1.0 404 Not Found");
    exit;
}

$metaTitle = htmlspecialchars($biz['seo_title'] ?: $biz['name']);
$metaDesc  = htmlspecialchars($biz['meta_description'] ?: substr(strip_tags($biz['description']), 0, 150));

// Increment views right here
$pdo->prepare("UPDATE businesses SET views = views + 1 WHERE id = ?")
    ->execute([$biz['id']]);

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
  <!-- LOGO and TOP ADS -->
<div class="container-fluid text-center py-4 bg-white">
  <div class="row align-items-center">
    <div class="col-md-2 d-none d-md-block">
      <img src="assets/images/ad-left.jpg" class="img-fluid rounded">
    </div>
    <div class="col-md-8">
      <img src="assets/images/logo.png" class="img-fluid" style="max-height: 80px;">
    </div>
    <div class="col-md-2 d-none d-md-block">
      <img src="assets/images/ad-right.jpg" class="img-fluid rounded">
    </div>
  </div>
</div>

<!-- Modern Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background: linear-gradient(135deg, #fd7e14 0%, #ff4500 100%); box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
  <div class="container">
    <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php">
      <span class="logo-icon me-2" style="width: 30px; height: 30px; background-color: white; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fd7e14" viewBox="0 0 16 16">
          <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
          <path d="m10.273 2.513-.921-.944.715-.698.622.637.89-.011a2.89 2.89 0 0 1 2.924 2.924l-.01.89.636.622a2.89 2.89 0 0 1 0 4.134l-.637.622.011.89a2.89 2.89 0 0 1-2.924 2.924l-.89-.01-.622.636a2.89 2.89 0 0 1-4.134 0l-.622-.637-.89.011a2.89 2.89 0 0 1-2.924-2.924l.01-.89-.636-.622a2.89 2.89 0 0 1 0-4.134l.637-.622-.011-.89a2.89 2.89 0 0 1 2.924-2.924l.89.01.622-.636a2.89 2.89 0 0 1 4.134 0l-.715.698a1.89 1.89 0 0 0-2.704 0l-.92.944-1.32-.016a1.89 1.89 0 0 0-1.911 1.912l.016 1.318-.944.921a1.89 1.89 0 0 0 0 2.704l.944.92-.016 1.32a1.89 1.89 0 0 0 1.912 1.911l1.318-.016.921.944a1.89 1.89 0 0 0 2.704 0l.92-.944 1.32.016a1.89 1.89 0 0 0 1.911-1.912l-.016-1.318.944-.921a1.89 1.89 0 0 0 0-2.704l-.944-.92.016-1.32a1.89 1.89 0 0 0-1.912-1.911l-1.318.016z"/>
        </svg>
      </span>
      StoryPortal
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link px-3" href="index.php">
            <span class="d-flex align-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door me-1" viewBox="0 0 16 16">
                <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z"/>
              </svg>
              Home
            </span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3" href="category.php">
            <span class="d-flex align-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-collection me-1" viewBox="0 0 16 16">
                <path d="M2.5 3.5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-11zm2-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM0 13a1.5 1.5 0 0 0 1.5 1.5h13A1.5 1.5 0 0 0 16 13V6a1.5 1.5 0 0 0-1.5-1.5h-13A1.5 1.5 0 0 0 0 6v7zm1.5.5A.5.5 0 0 1 1 13V6a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-13z"/>
              </svg>
              Category
            </span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3" href="events.php">
            <span class="d-flex align-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-collection me-1" viewBox="0 0 16 16">
                <path d="M2.5 3.5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-11zm2-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM0 13a1.5 1.5 0 0 0 1.5 1.5h13A1.5 1.5 0 0 0 16 13V6a1.5 1.5 0 0 0-1.5-1.5h-13A1.5 1.5 0 0 0 0 6v7zm1.5.5A.5.5 0 0 1 1 13V6a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-13z"/>
              </svg>
              Events
            </span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3" href="category.php">
            <span class="d-flex align-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-collection me-1" viewBox="0 0 16 16">
                <path d="M2.5 3.5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-11zm2-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM0 13a1.5 1.5 0 0 0 1.5 1.5h13A1.5 1.5 0 0 0 16 13V6a1.5 1.5 0 0 0-1.5-1.5h-13A1.5 1.5 0 0 0 0 6v7zm1.5.5A.5.5 0 0 1 1 13V6a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-13z"/>
              </svg>
              Business
            </span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3" href="about.php">
            <span class="d-flex align-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle me-1" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
              </svg>
              About
            </span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3" href="list-story.php">
            <span class="d-flex align-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square me-1" viewBox="0 0 16 16">
                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
              </svg>
              List Your Story
            </span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3" href="contact.php">
            <span class="d-flex align-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope me-1" viewBox="0 0 16 16">
                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
              </svg>
              Contact
            </span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
  
  <main class="container my-4 my-lg-5">
    <div class="row g-4 mb-5">
      <!-- Mobile Layout - Image, Name, Description, then Business Details -->
      <div class="col-12 d-lg-none">
        <?php if ($biz['image']): ?>
          <img src="<?= $biz['image'] ?>" 
               alt="<?= htmlspecialchars($biz['name']) ?>" 
               class="img-fluid rounded-3 shadow mb-3 w-100">
        <?php endif; ?>
        
        <h1 class="display-5 fw-bold mb-3"><?= htmlspecialchars($biz['name']) ?></h1>
        
        <div class="bg-white p-4 rounded-3 shadow-sm mb-4">
          <?= nl2br(htmlspecialchars($biz['description'])) ?>
        </div>
        
        <!-- Business Details for Mobile -->
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
              <li class="mb-2"><strong>Website:</strong> <a target="_blank" href="<?= htmlspecialchars($biz['website']) ?>">Visit Site</a></li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
      
      <!-- Desktop Layout - Unchanged -->
      <div class="col-lg-4 d-none d-lg-block">
        <?php if ($biz['image']): ?>
          <img src="<?= $biz['image'] ?>" 
               alt="<?= htmlspecialchars($biz['name']) ?>" 
               class="img-fluid rounded-3 shadow mb-3 w-100">
        <?php endif; ?>
        
        <!-- Business details -->
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
              <li class="mb-2"><strong>Website:</strong> <a target="_blank" href="<?= htmlspecialchars($biz['website']) ?>">Visit Site</a></li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
      
      <div class="col-lg-8 d-none d-lg-block">
        <h1 class="display-5 fw-bold mb-3"><?= htmlspecialchars($biz['name']) ?></h1>
        <div class="bg-white p-4 rounded-3 shadow-sm">
          <?= nl2br(htmlspecialchars($biz['description'])) ?>
        </div>
      </div>
    </div>
    
    <!-- Services Section - Mobile Optimized -->
    <?php if (!empty($services)): ?>
      <section class="my-4">
        <h2 class="h4 mb-4 pb-2 border-bottom">Related Services</h2>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
          <?php foreach ($services as $service): ?>
            <div class="col">
              <div class="card h-100 shadow-sm border-0">
                <?php if (!empty($service['image'])): ?>
                  <img src="<?= htmlspecialchars($service['image']) ?>" 
                       class="card-img-top" 
                       style="height: 180px; object-fit: cover;"
                       loading="lazy">
                <?php endif; ?>
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title"><?= htmlspecialchars($service['name']) ?></h5>
                  <p class="card-text small text-muted"><?= htmlspecialchars($service['short_description']) ?></p>
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