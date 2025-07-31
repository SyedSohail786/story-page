<?php
require_once 'includes/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
  $stmt->execute([
    $_POST['name'], $_POST['email'], $_POST['message']
  ]);
  $msg = "Thank you for contacting us!";
}
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
    <a class="navbar-brand" href="index.php">StoryPortal</a>
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

<!-- Full-height Contact Section -->
<div class="container-fluid d-flex flex-column" style="min-height: calc(100vh - 150px);">
  <div class="container my-5 flex-grow-1">
    <h3>Contact / Help</h3>
    <?php if (!empty($msg)) echo "<div class='alert alert-success'>$msg</div>"; ?>
    <form method="POST">
      <div class="mb-3"><input name="name" class="form-control" placeholder="Your Name" required></div>
      <div class="mb-3"><input name="email" class="form-control" placeholder="Your Email" required></div>
      <div class="mb-3"><textarea name="message" class="form-control" rows="5" placeholder="Your Message" required></textarea></div>
      <button class="btn btn-primary">Send</button>
    </form>
  </div>
</div>

<?php include 'includes/footer.php'; ?>