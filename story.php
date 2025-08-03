<?php
require_once 'includes/db.php';
$slug = $_GET['slug'] ?? '';
$stmt = $pdo->prepare("SELECT * FROM stories WHERE slug = ?");
$stmt->execute([$slug]);
$story = $stmt->fetch();

if (!$story) {
    exit('Story not found.');
}

$metaTitle = $story['seo_title'] ?: $story['title'];
$metaDesc = $story['meta_description'] ?: substr(strip_tags($story['content']), 0, 150);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($metaTitle) ?></title>
  <meta name="description" content="<?= htmlspecialchars($metaDesc) ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">

<?php include 'includes/header.php'; ?>

<!-- Header with Logo and Ads -->
<header class="bg-white shadow-sm">
  <div class="container-fluid py-3">
    <div class="row align-items-center">
      <div class="col-md-2 d-none d-md-block">
        <img src="assets/images/ad-left.jpg" class="img-fluid rounded" loading="lazy">
      </div>
      <div class="col-md-8 text-center">
        <img src="assets/images/logo.png" class="img-fluid" style="max-height: 80px;" alt="Site Logo">
      </div>
      <div class="col-md-2 d-none d-md-block">
        <img src="assets/images/ad-right.jpg" class="img-fluid rounded" loading="lazy">
      </div>
    </div>
  </div>
</header>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background: linear-gradient(135deg, #fd7e14 0%, #ff4500 100%);">
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
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link px-3" href="index.php">
            <i class="bi bi-house-door me-1"></i> Home
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3" href="category.php">
            <i class="bi bi-collection me-1"></i> Category
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3" href="about.php">
            <i class="bi bi-info-circle me-1"></i> About
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3" href="list-story.php">
            <i class="bi bi-pencil-square me-1"></i> List Your Story
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3" href="contact.php">
            <i class="bi bi-envelope me-1"></i> Contact
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Main Content -->
<main class="container my-4">
  <!-- Back Button -->
  <div class="mb-4">
    <a href="index.php" class="btn btn-outline-primary rounded-pill px-4 py-2">
      <i class="bi bi-arrow-left me-2"></i> Back to Home
    </a>
  </div>

  <!-- Story Content -->
  <article class="bg-white rounded-3 shadow-sm p-4 p-md-5 mb-4">
    <!-- Story Header -->
    <header class="mb-4">
      <h1 class="display-5 fw-bold mb-3"><?= htmlspecialchars($story['title']) ?></h1>
      <div class="d-flex align-items-center text-muted mb-3">
        <i class="bi bi-calendar me-2"></i>
        <span>Posted on <?= date('F j, Y', strtotime($story['created_at'])) ?></span>
      </div>
    </header>

    <!-- Featured Image -->
    <?php if (!empty($story['thumbnail'])): ?>
      <figure class="mb-4">
        <img src="<?= htmlspecialchars($story['thumbnail']) ?>" 
             class="img-fluid rounded w-100" 
             alt="<?= htmlspecialchars($story['title']) ?>"
             style="max-height: 500px; object-fit: cover;"
             loading="lazy">
      </figure>
    <?php endif; ?>

    <!-- Story Content -->
    <div class="content fs-5 lh-base">
      <?php
      $paragraphs = preg_split('/\r\n|\r|\n/', trim($story['content']));
      foreach ($paragraphs as $para) {
        if (trim($para) !== '') {
          echo '<p>' . htmlspecialchars($para) . '</p>';
        }
      }
      ?>
    </div>
  </article>

  <!-- Gallery Section -->
  <?php if (!empty($story['gallery'])): 
    $gallery = json_decode($story['gallery']); ?>
    <section class="bg-white rounded-3 shadow-sm p-4 p-md-5 mb-4">
      <h2 class="h4 mb-4 pb-2 border-bottom">Gallery</h2>
      <div class="row g-3">
        <?php foreach ($gallery as $img): ?>
          <div class="col-6 col-md-4 col-lg-3">
            <img src="<?= htmlspecialchars($img) ?>" 
                 class="img-fluid rounded shadow-sm gallery-zoomable" 
                 style="cursor: zoom-in; height: 200px; width: 100%; object-fit: cover;"
                 loading="lazy">
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endif; ?>

  <!-- Author Section -->
  <section class="bg-white rounded-3 shadow-sm p-4 p-md-5 mb-4">
    <h2 class="h4 mb-4 pb-2 border-bottom">Submitted By</h2>
    <div class="row">
      <div class="col-md-8">
        <p><strong class="text-dark">Name:</strong> <?= htmlspecialchars($story['user_name']) ?></p>
        <p><strong class="text-dark">Contact:</strong> <?= htmlspecialchars($story['user_contact']) ?></p>
        <p><strong class="text-dark">Address:</strong> <?= nl2br(htmlspecialchars($story['user_address'])) ?></p>
      </div>
    </div>
  </section>

  <!-- Related Services -->
  <?php
  $services = $pdo->query("SELECT * FROM services ORDER BY id DESC")->fetchAll();
  if (!empty($services)): ?>
    <section class="mb-4">
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
                <a href="contact.php" class="btn btn-sm btn-primary mt-auto">Learn More</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>

<!-- Custom Styles -->
<style>
  .navbar {
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
  }
  
  .navbar.scrolled {
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    background: rgba(253, 126, 20, 0.95) !important;
    backdrop-filter: blur(10px);
  }
  
  .nav-link {
    position: relative;
    font-weight: 500;
    transition: all 0.3s ease;
    border-radius: 8px;
    margin: 0 2px;
  }
  
  .nav-link:hover {
    background-color: rgba(255,255,255,0.1);
    transform: translateY(-2px);
  }
  
  .content p {
    margin-bottom: 1.5rem;
    line-height: 1.7;
  }
  
  .content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1.5rem 0;
  }
  
  .gallery-zoomable {
    transition: transform 0.3s ease;
  }
  
  .gallery-zoomable:hover {
    transform: scale(1.03);
  }
  
  @media (max-width: 768px) {
    .content {
      font-size: 1rem;
    }
  }
</style>

<!-- JavaScript -->
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script>
// Navbar scroll effect
window.addEventListener('scroll', function() {
  const navbar = document.querySelector('.navbar');
  if (window.scrollY > 50) {
    navbar.classList.add('scrolled');
  } else {
    navbar.classList.remove('scrolled');
  }
});

// Simple image zoom functionality
document.querySelectorAll('.gallery-zoomable').forEach(img => {
  img.addEventListener('click', function() {
    this.classList.toggle('zoomed');
  });
});
</script>
</body>
</html>