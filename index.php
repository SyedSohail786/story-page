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
          <a class="nav-link px-3 active" href="index.php">
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
                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741zM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
              </svg>
              Contact
            </span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Main Content Area -->
<div class="container-fluid bg-light">

<!-- SEARCH BAR -->
<div class="container my-4">
  <form action="search.php" method="get" class="d-flex justify-content-center">
    <div class="input-group" style="max-width: 800px; height: 50px;">
      <input 
        type="text" 
        class="form-control shadow-sm rounded-start border-orange" 
        name="q" 
        placeholder="Search stories..." 
        required>
      <button class="btn btn-orange rounded-end px-4" type="submit">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search me-1" viewBox="0 0 16 16">
          <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001l3.85 3.85a1 1 0 0 0 1.415-1.415l-3.85-3.85zm-5.242.656a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11z"/>
        </svg>
        Search
      </button>
    </div>
  </form>
</div>

  <!-- Hero Slider -->
  <div class="container my-4">
    <div id="mainSlider" class="carousel slide carousel-fade shadow-lg rounded-4 overflow-hidden" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <?php foreach ($slides as $i => $s): ?>
          <button type="button" data-bs-target="#mainSlider" data-bs-slide-to="<?= $i ?>" <?= $i === 0 ? 'class="active"' : '' ?>></button>
        <?php endforeach; ?>
      </div>
      <div class="carousel-inner rounded-4">
        <?php foreach ($slides as $i => $s): ?>
          <div class="carousel-item <?= $i === 0 ? 'active' : '' ?> position-relative" >
            <img src="<?= $s['thumbnail'] ?>" class="d-block w-100 position-relative" style="height: 500px; object-fit: cover; object-position: center;" >
            <div class="carousel-caption d-flex flex-column justify-content-center h-100 text-start p-4">
              <div class="container py-2 px-5 rounded-2 position-absolute bottom-0" style="background: rgba(0, 0, 0, 0.2);">
                <h2 class="display-5 fw-bold mb-3"><?= htmlspecialchars($s['title']) ?></h2>
                <p class="d-none d-md-block mb-4"><?= htmlspecialchars(substr(strip_tags($s['content']), 0, 150)) ?>...</p>
                <a href="story/<?= urlencode($s['slug']) ?>" class="btn btn-orange btn-lg px-4 align-self-start">
                  Read Story
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right ms-2" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                  </svg>
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#mainSlider" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bg-black rounded" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#mainSlider" data-bs-slide="next">
        <span class="carousel-control-next-icon bg-black rounded" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>

  <!-- LATEST STORIES -->
  <div class="container my-5 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="mb-0" style="color: #fd7e14;">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-clock-history me-2" viewBox="0 0 16 16">
          <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z"/>
          <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z"/>
          <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"/>
        </svg>
        Latest Stories
      </h2>
      <a href="category.php" class="btn btn-outline-orange">
        View All
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right ms-1" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
        </svg>
      </a>
    </div>
    
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4" id="latestStories">
      <?php foreach ($latest as $i => $s): ?>
        <div class="col latest-card <?= $i >= 8 ? 'd-none' : '' ?>">
          <div class="card h-100 border-0 shadow-sm story-card">
            <div class="position-relative overflow-hidden" style="height: 200px;">
              <img src="<?= $s['thumbnail'] ?>" class="card-img-top h-100 w-100" style="object-fit: cover; transition: transform 0.3s ease;">
              <div class="card-img-overlay d-flex align-items-end p-0">
                <span class="badge bg-orange text-white mb-2 ms-2">New</span>
              </div>
            </div>
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($s['title']) ?></h5>
              <p class="card-text text-muted small">
                <?= date('F j, Y', strtotime($s['created_at'])) ?>
              </p>
              <p class="card-text text-truncate-3"><?= htmlspecialchars(substr(strip_tags($s['content']), 0, 100)) ?>...</p>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
              <a href="story/<?= urlencode($s['slug']) ?>" class="btn btn-sm btn-orange w-100">
                Read Story
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right ms-1" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                </svg>
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    
    <?php if (count($latest) > 8): ?>
      <div class="text-center mt-4">
        <button class="btn btn-orange px-4" id="loadMoreLatest">
          Load More Stories
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down ms-2" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
          </svg>
        </button>
      </div>
    <?php endif; ?>
  </div>

  <!-- POPULAR STORIES -->
  <div class="container my-5 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="mb-0" style="color: #fd7e14;">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-fire me-2" viewBox="0 0 16 16">
          <path d="M8 16c3.314 0 6-2 6-5.5 0-1.5-.5-4-2.5-6 .25 1.5-1.25 2-1.25 2C11 4 9 .5 6 0c.357 2 .5 4-2 6-1.25 1-2 2.729-2 4.5C2 14 4.686 16 8 16Zm0-1c-1.657 0-3-1-3-2.75 0-.75.25-2 1.25-3C6.125 10 7 10.5 7 10.5c-.375-1.25.5-3.25 2-3.5-.179 1-.25 2 1 3 .625.5 1 1.364 1 2.25C11 14 9.657 15 8 15Z"/>
        </svg>
        Popular Stories
      </h2>
      <a href="category.php?popular=1" class="btn btn-outline-orange">
        View All
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right ms-1" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
        </svg>
      </a>
    </div>
    
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4" id="popularStories">
      <?php foreach ($popular as $i => $s): ?>
        <div class="col popular-card <?= $i >= 8 ? 'd-none' : '' ?>">
          <div class="card h-100 border-0 shadow-sm story-card">
            <div class="position-relative overflow-hidden" style="height: 200px;">
              <img src="<?= $s['thumbnail'] ?>" class="card-img-top h-100 w-100" style="object-fit: cover; transition: transform 0.3s ease;">
              <div class="card-img-overlay d-flex align-items-end p-0">
                <span class="badge bg-orange text-white mb-2 ms-2">Trending</span>
              </div>
            </div>
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($s['title']) ?></h5>
              <p class="card-text text-muted small">
                <?= date('F j, Y', strtotime($s['created_at'])) ?>
              </p>
              <p class="card-text text-truncate-3"><?= htmlspecialchars(substr(strip_tags($s['content']), 0, 100)) ?>...</p>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
              <a href="story/<?= urlencode($s['slug']) ?>" class="btn btn-sm btn-orange w-100">
                Read Story
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right ms-1" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                </svg>
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    
    <?php if (count($popular) > 8): ?>
      <div class="text-center mt-4">
        <button class="btn btn-orange px-4" id="loadMorePopular">
          Load More Stories
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down ms-2" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
          </svg>
        </button>
      </div>
    <?php endif; ?>
  </div>

  <!-- ADS SECTION -->
  <div class="container my-5">
    <div class="row">
      <div class="col-12">
        <img src="assets/images/ad-banner.jp" class="img-fluid rounded-3 shadow-sm w-100" alt="Advertisement">
      </div>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>

<style>
  body {
    background-color: #f8f9fa;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  
  .navbar {
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
  
  .nav-link.active {
    background-color: rgba(255,255,255,0.2);
    font-weight: 600;
  }
  
  .nav-link.active:before {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 20px;
    height: 3px;
    background-color: white;
    border-radius: 3px;
  }
  
  .bg-orange {
    background-color: #fd7e14 !important;
  }
  
  .btn-orange {
    background-color: #fd7e14;
    color: white;
    transition: all 0.3s ease;
    border: none;
  }
  
  .btn-orange:hover {
    background-color: #e67300;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(253, 126, 20, 0.3);
  }
  
  .btn-outline-orange {
    border-color: #fd7e14;
    color: #fd7e14;
    transition: all 0.3s ease;
  }
  
  .btn-outline-orange:hover {
    background-color: #fd7e14;
    color: white;
  }
  
  .story-card {
    transition: all 0.3s ease;
    border-radius: 12px;
    overflow: hidden;
  }
  
  .story-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
  }
  
  .story-card:hover img {
    transform: scale(1.05);
  }
  
  .card-img-overlay .badge {
    opacity: 0;
    transition: opacity 0.3s ease;
  }
  
  .story-card:hover .card-img-overlay .badge {
    opacity: 1;
  }
  
  .text-truncate-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  
  .carousel-item {
    transition: transform 0.6s ease-in-out;
  }
  
  .carousel-fade .carousel-item {
    opacity: 0;
    transition-property: opacity;
    transform: none;
  }
  
  .carousel-fade .carousel-item.active,
  .carousel-fade .carousel-item-next.carousel-item-start,
  .carousel-fade .carousel-item-prev.carousel-item-end {
    opacity: 1;
  }
  
  .carousel-fade .active.carousel-item-start,
  .carousel-fade .active.carousel-item-end {
    opacity: 0;
  }
  
  .carousel-indicators button {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    margin: 0 5px;
    border: none;
    background-color: rgba(255,255,255,0.5);
  }
  
  .carousel-indicators button.active {
    background-color: #fd7e14;
  }
  
  @media (max-width: 992px) {
    .nav-link {
      margin: 2px 0;
      padding: 8px 12px !important;
    }
    
    .nav-link.active:before {
      display: none;
    }
    
    .carousel-caption {
      padding: 1rem !important;
    }
    
    .carousel-caption h2 {
      font-size: 1.5rem !important;
    }
  }

  .border-orange {
  border-color: #fd7e14;
}
.input-group input:focus {
  box-shadow: 0 0 0 0.2rem rgba(253, 126, 20, 0.25);
  border-color: #fd7e14;
}

</style>

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
  
  // Initialize carousel with interval
  const myCarousel = document.querySelector('#mainSlider');
  if (myCarousel) {
    const carousel = new bootstrap.Carousel(myCarousel, {
      interval: 5000,
      ride: 'carousel'
    });
  }
});
</script>