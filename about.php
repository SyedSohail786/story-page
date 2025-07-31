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
<!-- Full-height About Section -->
<div class="container-fluid d-flex flex-column" style="min-height: calc(100vh - 150px);">
  <div class="px-5 pt-5 flex-grow-1">
    <h3 class="mb-4">About Story Portal</h3>
    <p>
      Welcome to <strong>Story Portal</strong>, a place to discover and share inspiring stories from all walks of life.
      Our mission is to create a platform where storytellers and readers connect through authentic, heartfelt content.
      Whether you're seeking travel adventures, personal growth journeys, or stories of triumph, we've built a home for every narrative.
    </p>

    <p>
      All stories are curated by our editorial team and categorized to ensure quality and relevance.
      We believe in the power of storytelling to educate, entertain, and empower our readers.
    </p>

    <p>
      If you have a story to tell, head over to <a href="list-story.php">List Your Story</a> and let the world hear your voice.
    </p>
  </div>
</div>

<?php include 'includes/footer.php'; ?>