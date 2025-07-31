<?php
require_once 'includes/db.php';
$cat_id = $_GET['id'] ?? null;
$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();

if ($cat_id) {
  $cat = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
  $cat->execute([$cat_id]);
  $category = $cat->fetch();
  if (!$category) {
    echo "<div class='d-flex justify-content-center align-items-center flex-grow-1'><div class='alert alert-danger w-50 text-center'>Category not found.</div></div>";
    include 'includes/footer.php';
    exit;
  }
  $stmt = $pdo->prepare("SELECT * FROM stories WHERE category_id = ? ORDER BY created_at DESC");
  $stmt->execute([$cat_id]);
} else {
  $stmt = $pdo->query("SELECT * FROM stories ORDER BY created_at DESC");
}
$stories = $stmt->fetchAll();
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

<!-- Main Content - Flex Grow to push footer down -->
<div class="container-fluid d-flex flex-column min-vh-100">
  <div class="container py-4 flex-grow-1">
    <div class="row">
      <div class="col-12">
        <h3 class="mb-4" style="color: #fd7e14;">
          <?= isset($category) ? 'Category: ' . htmlspecialchars($category['name']) : 'All Stories' ?>
        </h3>
        
        <!-- Category Selector -->
        <form method="GET" class="mb-4">
          <div class="input-group" style="max-width: 400px;">
            <select name="id" class="form-select" onchange="this.form.submit()">
              <option value="">All Categories</option>
              <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $cat_id) ? 'selected' : '' ?>>
                  <?= htmlspecialchars($cat['name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <button class="btn text-white" style="background-color: #fd7e14;" type="submit">Filter</button>
          </div>
        </form>
        
        <!-- Stories Grid -->
        <?php if (count($stories) > 0): ?>
          <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php foreach ($stories as $s): ?>
              <div class="col">
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
        <?php else: ?>
          <div class="alert alert-info">No stories found in this category.</div>
        <?php endif; ?>
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
  
  .min-vh-100 {
    min-height: 100vh;
  }
  
  .navbar {
    margin-bottom: 2rem;
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
  
  .form-select:focus, .btn:focus {
    border-color: #fd7e14;
    box-shadow: 0 0 0 0.25rem rgba(253, 126, 20, 0.25);
  }
</style>