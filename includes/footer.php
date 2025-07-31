<?php
require_once 'includes/db.php';
$categories_result = $pdo->query("SELECT * FROM categories ORDER BY name");
?>
</main>
<footer class="bg-dark text-white py-5 mt-auto">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-6 mb-4">
        <h5>Quick Links</h5>
        <ul class="list-unstyled">
          <li><a href="index.php" class="text-white-50">Home</a></li>
          <li><a href="about.php" class="text-white-50">About</a></li>
          <li><a href="contact.php" class="text-white-50">Contact</a></li>
          <li><a href="list-story.php" class="text-white-50">Submit Story</a></li>
        </ul>
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
        <h5>Categories</h5>
        <ul class="list-unstyled">
          <?php foreach ($categories_result as $category): ?>
            <li><a href="category.php?id=<?= $category['id'] ?>" class="text-white-50"><?= htmlspecialchars($category['name']) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
        <h5>Social Media</h5>
        <div class="social-links">
          <a href="#" class="text-white me-3"><img src="assets/images/facebook.png" alt="Facebook" width="24"></a>
          <a href="#" class="text-white me-3"><img src="assets/images/twitter.png" alt="Twitter" width="24"></a>
          <a href="#" class="text-white me-3"><img src="assets/images/instagram.png" alt="Instagram" width="24"></a>
          <a href="#" class="text-white"><img src="assets/images/youtube.png" alt="YouTube" width="24"></a>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
        <h5>Enquiry</h5>
        <p class="text-white-50">Have a story to share?</p>
        <a href="list-story.php" class="btn btn-primary">Submit Your Story</a>
      </div>
    </div>
    <hr class="my-4">
    <div class="row">
      <div class="col-12 text-center">
        <p class="mb-0">&copy; <?= date('Y') ?> Story Portal. All Rights Reserved.</p>
      </div>
    </div>
  </div>
</footer>
<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>