<?php
require_once 'includes/db.php';
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM stories WHERE id = ?");
$stmt->execute([$id]);
$story = $stmt->fetch();
if (!$story) exit('Story not found.');
?>
<?php include 'includes/header.php'; ?>
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