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
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="category.php">Category</a></li>
        <li class="nav-item"><a class="nav-link active" href="about.php">About</a></li>
        <li class="nav-item"><a class="nav-link" href="list-story.php">List Your Story</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Full-height About Section -->
<div class="container-fluid d-flex flex-column flex-grow-1 bg-light">
  <div class="container my-5 py-4 flex-grow-1">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card shadow-sm border-0">
          <div class="card-body p-4 p-md-5">
            <h3 class="mb-4" style="color: #fd7e14;">About Story Portal</h3>
            <p class="lead">
              Welcome to <strong>Story Portal</strong>, a place to discover and share inspiring stories from all walks of life.
            </p>
            
            <p>
              Our mission is to create a platform where storytellers and readers connect through authentic, heartfelt content.
              Whether you're seeking travel adventures, personal growth journeys, or stories of triumph, we've built a home for every narrative.
            </p>

            <p>
              All stories are curated by our editorial team and categorized to ensure quality and relevance.
              We believe in the power of storytelling to educate, entertain, and empower our readers.
            </p>

            <div class="mt-4">
              <a href="list-story.php" class="btn text-white" style="background-color: #fd7e14;">Share Your Story</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>

<style>
  body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    background-color: #f8f9fa;
  }
  
  .container-fluid.flex-grow-1 {
    flex: 1 0 auto;
  }
  
  .navbar {
    margin-bottom: 2rem;
    box-shadow: 0 2px 10px rgba(253, 126, 20, 0.3);
  }
  
  .card {
    border-radius: 10px;
  }
  
  .nav-link.active {
    font-weight: bold;
    text-decoration: underline;
    text-underline-offset: 5px;
  }
  
  .btn:hover {
    background-color: #e67300 !important;
  }
</style>