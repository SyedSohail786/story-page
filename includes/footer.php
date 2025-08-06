<?php
require_once 'includes/db.php';
$categories_result = $pdo->query("SELECT * FROM categories ORDER BY name");
?>
</main>

<footer class="bg-dark text-white py-5 mt-auto">
  <div class="container">
    <div class="row g-4">
      <!-- Quick Links -->
      <div class="col-lg-3 col-md-6">
        <h5 class="text-orange mb-4">Quick Links</h5>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="index.php" class="text-white-50 hover-orange d-inline-block transition">Home</a></li>
          <li class="mb-2"><a href="about.php" class="text-white-50 hover-orange d-inline-block transition">About</a></li>
          <li class="mb-2"><a href="contact.php" class="text-white-50 hover-orange d-inline-block transition">Contact</a></li>
          <li class="mb-2"><a href="list-story.php" class="text-white-50 hover-orange d-inline-block transition">Submit Story</a></li>
        </ul>
      </div>

      <!-- Categories -->
      <div class="col-lg-3 col-md-6">
        <h5 class="text-orange mb-4">Categories</h5>
        <ul class="list-unstyled">
          <?php if ($categories_result): ?>
            <?php foreach ($categories_result as $category): ?>
              <li class="mb-2"><a href="<?= $category['slug'] ?>" class="text-white-50 hover-orange d-inline-block transition"><?= htmlspecialchars($category['name']) ?></a></li>
            <?php endforeach; ?>
          <?php else: ?>
            <li class="text-white-50">No categories available</li>
          <?php endif; ?>
        </ul>
      </div>

      <!-- Social Media -->
      <div class="col-lg-3 col-md-6">
        <h5 class="text-orange mb-4">Connect With Us</h5>
        <div class="social-links d-flex gap-3 mb-4">
          <a href="#" class="d-inline-block transition hover-scale">
            <img src="assets/images/facebook.png" alt="Facebook" width="32" class="filter-orange">
          </a>
          <a href="#" class="d-inline-block transition hover-scale">
            <img src="assets/images/twitter.png" alt="Twitter" width="32" class="filter-orange">
          </a>
          <a href="#" class="d-inline-block transition hover-scale">
            <img src="assets/images/instagram.png" alt="Instagram" width="32" class="filter-orange">
          </a>
          <a href="#" class="d-inline-block transition hover-scale">
            <img src="assets/images/youtube.png" alt="YouTube" width="32" class="filter-orange">
          </a>
        </div>
        <p class="text-white-50 small">Follow us for the latest stories and updates</p>
      </div>

      <!-- Contact Us -->
      <div class="col-lg-3 col-md-6">
        <h5 class="text-orange mb-4">Contact Us</h5>
        <div class="mb-3">
          <p class="text-white-50 mb-4">Have questions or feedback? We'd love to hear from you!</p>
          <a href="contact.php" class="btn btn-orange w-100 transition">Get In Touch</a>
        </div>
        <p class="text-white-50 small">Our team is ready to assist you</p>
      </div>
    </div>

    <hr class="my-4 border-secondary">
    <div class="text-center pt-3">
      <p class="mb-0 text-white-50 small">&copy; <?= date('Y') ?> Digisnare. All Rights Reserved.</p>
    </div>
  </div>
</footer>

<!-- Add this to your CSS file or in a style tag -->
<style>
  .text-orange {
    color: #fd7e14;
  }
  
  .btn-orange {
    background-color: #fd7e14;
    color: white;
    border: none;
  }
  
  .btn-orange:hover {
    background-color: #e67312;
    color: white;
  }
  
  .hover-orange:hover {
    color: #fd7e14 !important;
  }

  .transition {
    transition: all 0.3s ease;
  }
  
  .hover-scale:hover {
    transform: scale(1.1);
  }
  
  .border-secondary {
    border-color: #444 !important;
  }
</style>

<script src="assets/js/bootstrap.bundle.min.js"></script>
<script>
  document.getElementById('loadMoreLatest')?.addEventListener('click', function () {
    const hiddenCards = document.querySelectorAll('.latest-card.d-none');
    for (let i = 0; i < 4 && i < hiddenCards.length; i++) {
      hiddenCards[i].classList.remove('d-none');
    }
    if (document.querySelectorAll('.latest-card.d-none').length === 0) {
      this.remove();
    }
  });

  document.getElementById('loadMorePopular')?.addEventListener('click', function () {
    const hiddenCards = document.querySelectorAll('.popular-card.d-none');
    for (let i = 0; i < 4 && i < hiddenCards.length; i++) {
      hiddenCards[i].classList.remove('d-none');
    }
    if (document.querySelectorAll('.popular-card.d-none').length === 0) {
      this.remove();
    }
  });
</script>
<!-- Image Zoom Modal -->
<div class="modal fade" id="zoomModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-transparent border-0">
      <img id="zoomedImage" class="img-fluid rounded shadow">
    </div>
  </div>
</div>
<script>
  document.querySelectorAll('.gallery-zoomable').forEach(img => {
    img.addEventListener('click', function () {
      document.getElementById('zoomedImage').src = this.src;
      const zoomModal = new bootstrap.Modal(document.getElementById('zoomModal'));
      zoomModal.show();
    });
  });
</script>

</body>
</html>