<?php
require_once 'includes/db.php';
$cat_id = $_GET['id'] ?? null;
$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();

if ($cat_id) {
  $cat = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
  $cat->execute([$cat_id]);
  $category = $cat->fetch();
  if (!$category) {
    echo "<div style='margin: 50px auto; text-align:center; font-size:20px;'>Category not found.</div>";
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
<div class="container my-5">
  <h3><?= isset($category) ? 'Category: ' . htmlspecialchars($category['name']) : 'All Stories' ?></h3>

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
      <button class="btn btn-outline-secondary" type="submit">Filter</button>
    </div>
  </form>

  <!-- Stories Grid -->
  <div class="row">
    <?php foreach ($stories as $s): ?>
      <div class="col-md-3 mb-4">
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
<?php include 'includes/footer.php'; ?>
