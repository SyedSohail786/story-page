<?php
require_once 'includes/db.php';

// Only show stories marked as banner
$slides = $pdo->query("SELECT * FROM stories WHERE is_banner = 1 ORDER BY created_at DESC LIMIT 5")->fetchAll();
$latest = $pdo->query("SELECT * FROM stories WHERE is_latest=1 ORDER BY created_at DESC LIMIT 12")->fetchAll();
$popular = $pdo->query("SELECT * FROM stories WHERE is_popular=1 ORDER BY created_at DESC LIMIT 12")->fetchAll();
?>

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

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #fd7e14;">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">StoryPortal</a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="category.php">Category</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
        <li class="nav-item"><a class="nav-link" href="list-story.php">List Your Story</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Main Content Area -->
<div class="container-fluid bg-light">
  <!-- SLIDESHOW -->
  <div class="container my-4">
    <div id="mainSlider" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner rounded">
        <?php foreach ($slides as $i => $s): ?>
          <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
            <img src="<?= $s['thumbnail'] ?>" class="d-block w-100" style="height: 420px; object-fit: cover; object-position: center;">
            <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-75 rounded p-3">
              <h5><?= htmlspecialchars($s['title']) ?></h5>
              <a href="story.php?id=<?= $s['id'] ?>" class="btn btn-sm text-white mt-2" style="background-color: #fd7e14;">Read More</a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#mainSlider" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" style="background-color: rgba(0,0,0,0.6); border-radius: 50%; padding: 10px;"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#mainSlider" data-bs-slide="next">
        <span class="carousel-control-next-icon" style="background-color: rgba(0,0,0,0.6); border-radius: 50%; padding: 10px;"></span>
      </button>
    </div>
  </div>

  <!-- LATEST STORIES -->
  <div class="container my-5">
    <h4 class="mb-3" style="color: #fd7e14;">Latest Stories</h4>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4" id="latestStories">
      <?php foreach ($latest as $i => $s): ?>
        <div class="col latest-card <?= $i >= 8 ? 'd-none' : '' ?>">
          <div class="card h-100 shadow-sm">
            <img src="<?= $s['thumbnail'] ?>" class="card-img-top" style="height:180px; object-fit:cover;">
            <div class="card-body d-flex flex-column">
              <h6 class="card-title"><?= htmlspecialchars($s['title']) ?></h6>
              <div class="mt-auto">
                <a href="story.php?id=<?= $s['id'] ?>" class="btn btn-sm text-white" style="background-color: #fd7e14;">Read More</a>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <?php if (count($latest) > 8): ?>
      <div class="text-center mt-4">
        <button class="btn text-white" style="background-color: #fd7e14;" id="loadMoreLatest">Load More</button>
      </div>
    <?php endif; ?>
  </div>

  <!-- POPULAR STORIES -->
  <div class="container my-5">
    <h4 class="mb-3" style="color: #fd7e14;">Popular Stories</h4>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4" id="popularStories">
      <?php foreach ($popular as $i => $s): ?>
        <div class="col popular-card <?= $i >= 8 ? 'd-none' : '' ?>">
          <div class="card h-100 shadow-sm">
            <img src="<?= $s['thumbnail'] ?>" class="card-img-top" style="height:180px; object-fit:cover;">
            <div class="card-body d-flex flex-column">
              <h6 class="card-title"><?= htmlspecialchars($s['title']) ?></h6>
              <div class="mt-auto">
                <a href="story.php?id=<?= $s['id'] ?>" class="btn btn-sm text-white" style="background-color: #fd7e14;">Read More</a>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <?php if (count($popular) > 8): ?>
      <div class="text-center mt-4">
        <button class="btn text-white" style="background-color: #fd7e14;" id="loadMorePopular">Load More</button>
      </div>
    <?php endif; ?>
  </div>

  <!-- AD BANNER -->
  <div class="container text-center my-5">
    <img src="assets/images/ad-banner.jpg" class="img-fluid w-100 rounded" style="max-height: 150px; object-fit: cover;">
  </div>
</div>

<?php include 'includes/footer.php'; ?>

<style>
  body {
    background-color: #f8f9fa;
  }
  
  .navbar {
    box-shadow: 0 2px 10px rgba(253, 126, 20, 0.3);
  }
  
  .card {
    border-radius: 8px;
    transition: transform 0.2s;
    border: none;
  }
  
  .card:hover {
    transform: translateY(-5px);
  }
  
  .nav-link.active {
    font-weight: bold;
    text-decoration: underline;
    text-underline-offset: 5px;
  }
  
  .btn:hover {
    background-color: #e67300 !important;
  }
  
  .carousel-control-prev, .carousel-control-next {
    width: 5%;
  }
</style>

<script>
// Load More functionality
document.addEventListener('DOMContentLoaded', function() {
  // Latest Stories
  const loadMoreLatest = document.getElementById('loadMoreLatest');
  if (loadMoreLatest) {
    loadMoreLatest.addEventListener('click', function() {
      document.querySelectorAll('#latestStories .latest-card.d-none').forEach((el, i) => {
        if (i < 4) el.classList.remove('d-none');
      });
      if (document.querySelectorAll('#latestStories .latest-card.d-none').length === 0) {
        loadMoreLatest.classList.add('d-none');
      }
    });
  }

  // Popular Stories
  const loadMorePopular = document.getElementById('loadMorePopular');
  if (loadMorePopular) {
    loadMorePopular.addEventListener('click', function() {
      document.querySelectorAll('#popularStories .popular-card.d-none').forEach((el, i) => {
        if (i < 4) el.classList.remove('d-none');
      });
      if (document.querySelectorAll('#popularStories .popular-card.d-none').length === 0) {
        loadMorePopular.classList.add('d-none');
      }
    });
  }
});
</script>