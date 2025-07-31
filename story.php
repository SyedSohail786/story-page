<?php
require_once 'includes/db.php';
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM stories WHERE id = ?");
$stmt->execute([$id]);
$story = $stmt->fetch();
if (!$story) exit('Story not found.');
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
        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
        <li class="nav-item"><a class="nav-link" href="list-story.php">List Your Story</a></li>
        <li class="nav-item"><a class="nav-link active" href="contact.php">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container my-5">
     <div class="text-left mt-4">
  <a href="index.php" class="btn btn-secondary">← Back to Home</a>
</div>

  <h2><?= htmlspecialchars($story['title']) ?></h2>
  <img src="<?= $story['thumbnail'] ?>" class="img-fluid mb-3" style="max-height: 300px;">
  <div><?= nl2br($story['content']) ?></div>
  <?php if (!empty($story['gallery'])): $gallery = json_decode($story['gallery']); ?>
    <div class="row mt-4">
      <?php foreach ($gallery as $img): ?>
        <div class="col-md-3 mb-2">
          <img src="<?= $img ?>" class="img-fluid rounded">
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>