<?php
require_once 'includes/db.php';

// Only show stories marked as banner
$slides = $pdo->query("SELECT * FROM stories WHERE is_banner = 1 ORDER BY created_at DESC LIMIT 5")->fetchAll();
$latest = $pdo->query("SELECT * FROM stories WHERE is_latest=1 ORDER BY created_at DESC LIMIT 12")->fetchAll();
$popular = $pdo->query("SELECT * FROM stories WHERE is_popular=1 ORDER BY created_at DESC LIMIT 12")->fetchAll();
?>

<?php include 'includes/header.php'; ?>

<!-- LOGO and TOP ADS -->
<div class="container-fluid text-center py-4">
  <div class="row align-items-center">
    <div class="col-md-2 d-none d-md-block">
      <img src="assets/images/ad-left.jpg" class="img-fluid">
    </div>
    <div class="col-md-8">
      <img src="assets/images/logo.png" class="img-fluid" style="max-height: 80px;">
    </div>
    <div class="col-md-2 d-none d-md-block">
      <img src="assets/images/ad-right.jpg" class="img-fluid">
    </div>
  </div>
</div>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">StoryPortal</a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="category.php">Category</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
        <li class="nav-item"><a class="nav-link" href="list-story.php">List Your Story</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- SLIDESHOW -->
<div class="container my-4">
  <div id="mainSlider" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <?php foreach ($slides as $i => $s): ?>
        <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
          <img src="<?= $s['thumbnail'] ?>" class="d-block w-100" style="height: 420px; object-fit: cover; object-position: center;">
          <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
            <h5><?= htmlspecialchars($s['title']) ?></h5>
            <a href="story.php?id=<?= $s['id'] ?>" class="btn btn-light btn-sm mt-2">Read More</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#mainSlider" data-bs-slide="prev" style="width: 5%;">
      <span class="carousel-control-prev-icon" style="background-color: rgba(0,0,0,0.6); border-radius: 50%; padding: 10px;"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#mainSlider" data-bs-slide="next" style="width: 5%;">
      <span class="carousel-control-next-icon" style="background-color: rgba(0,0,0,0.6); border-radius: 50%; padding: 10px;"></span>
    </button>
  </div>
</div>

<!-- LATEST STORIES -->
<div class="container my-5">
  <h4 class="mb-3">Latest Stories</h4>
  <div class="row flex-nowrap overflow-auto">
    <?php foreach ($latest as $s): ?>
      <div class="col-md-3 col-10 mb-3">
        <div class="card h-100">
          <img src="<?= $s['thumbnail'] ?>" class="card-img-top" style="height:150px; object-fit:cover;">
          <div class="card-body">
            <h6 class="card-title"><?= htmlspecialchars($s['title']) ?></h6>
            <a href="story.php?id=<?= $s['id'] ?>" class="btn btn-sm btn-outline-primary">Read More</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- POPULAR STORIES -->
<div class="container my-5">
  <h4 class="mb-3">Popular Stories</h4>
  <div class="row flex-nowrap overflow-auto">
    <?php foreach ($popular as $s): ?>
      <div class="col-md-3 col-10 mb-3">
        <div class="card h-100">
          <img src="<?= $s['thumbnail'] ?>" class="card-img-top" style="height:150px; object-fit:cover;">
          <div class="card-body">
            <h6 class="card-title"><?= htmlspecialchars($s['title']) ?></h6>
            <a href="story.php?id=<?= $s['id'] ?>" class="btn btn-sm btn-outline-secondary">Read More</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- AD BANNER -->
<div class="container text-center my-5">
  <img src="assets/images/ad-banner.jpg" class="img-fluid w-100" style="max-height: 150px;">
</div>

<?php include 'includes/footer.php'; ?>
