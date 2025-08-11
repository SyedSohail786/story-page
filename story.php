<?php
require_once 'includes/db.php';
$slug = $_GET['slug'] ?? '';
$stmt = $pdo->prepare("SELECT * FROM stories WHERE slug = ?");
$stmt->execute([$slug]);
$story = $stmt->fetch();

if (!$story) {
  exit('Story not found.');
}

$metaTitle = $story['seo_title'] ?: $story['title'];
$metaDesc = $story['meta_description'] ?: substr(strip_tags($story['content']), 0, 150);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($metaTitle) ?></title>
  <meta name="description" content="<?= htmlspecialchars($metaDesc) ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="bg-light">

  <?php include 'includes/header.php'; ?>

  <!-- Header with Logo and Ads -->
  <header class="bg-white shadow-sm">
    <div class="container-fluid py-3">
      <div class="row align-items-center">
        <div class="col-md-2 d-none d-md-block">
          <img src="assets/images/ad-left.jpg" class="img-fluid rounded" loading="lazy">
        </div>
        <div class="col-md-8 text-center">
          <img src="assets/images/logo.png" class="img-fluid" style="max-height: 80px;" alt="Site Logo">
        </div>
        <div class="col-md-2 d-none d-md-block">
          <img src="assets/images/ad-right.jpg" class="img-fluid rounded" loading="lazy">
        </div>
      </div>
    </div>
  </header>

  <!-- Modern Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark sticky-top"
    style="background: linear-gradient(135deg, #fd7e14 0%, #ff4500 100%); box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
    <div class="container">
      <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php">
        <span class="logo-icon me-2"
          style="width: 30px; height: 30px; background-color: white; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fd7e14" viewBox="0 0 16 16">
            <path
              d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
            <path
              d="m10.273 2.513-.921-.944.715-.698.622.637.89-.011a2.89 2.89 0 0 1 2.924 2.924l-.01.89.636.622a2.89 2.89 0 0 1 0 4.134l-.637.622.011.89a2.89 2.89 0 0 1-2.924 2.924l-.89-.01-.622.636a2.89 2.89 0 0 1-4.134 0l-.622-.637-.89.011a2.89 2.89 0 0 1-2.924-2.924l.01-.89-.636-.622a2.89 2.89 0 0 1 0-4.134l.637-.622-.011-.89a2.89 2.89 0 0 1 2.924-2.924l.89.01.622-.636a2.89 2.89 0 0 1 4.134 0l-.715.698a1.89 1.89 0 0 0-2.704 0l-.92.944-1.32-.016a1.89 1.89 0 0 0-1.911 1.912l.016 1.318-.944.921a1.89 1.89 0 0 0 0 2.704l.944.92-.016 1.32a1.89 1.89 0 0 0 1.912 1.911l1.318-.016.921.944a1.89 1.89 0 0 0 2.704 0l.92-.944 1.32.016a1.89 1.89 0 0 0 1.911-1.912l-.016-1.318.944-.921a1.89 1.89 0 0 0 0-2.704l-.944-.92.016-1.32a1.89 1.89 0 0 0-1.912-1.911l-1.318.016z" />
          </svg>
        </span>
        StoryPortal
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu"
        aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link px-3" href="index.php">
              <span class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                  class="bi bi-house-door me-1" viewBox="0 0 16 16">
                  <path
                    d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z" />
                </svg>
                Home
              </span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link px-3" href="category.php">
              <span class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                  class="bi bi-collection me-1" viewBox="0 0 16 16">
                  <path
                    d="M2.5 3.5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-11zm2-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM0 13a1.5 1.5 0 0 0 1.5 1.5h13A1.5 1.5 0 0 0 16 13V6a1.5 1.5 0 0 0-1.5-1.5h-13A1.5 1.5 0 0 0 0 6v7zm1.5.5A.5.5 0 0 1 1 13V6a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-13z" />
                </svg>
                Category
              </span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link px-3" href="events.php">
              <span class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                  class="bi bi-collection me-1" viewBox="0 0 16 16">
                  <path
                    d="M2.5 3.5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-11zm2-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM0 13a1.5 1.5 0 0 0 1.5 1.5h13A1.5 1.5 0 0 0 16 13V6a1.5 1.5 0 0 0-1.5-1.5h-13A1.5 1.5 0 0 0 0 6v7zm1.5.5A.5.5 0 0 1 1 13V6a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-13z" />
                </svg>
                Events
              </span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link px-3" href="businesses.php">
              <span class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                  class="bi bi-collection me-1" viewBox="0 0 16 16">
                  <path
                    d="M2.5 3.5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-11zm2-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM0 13a1.5 1.5 0 0 0 1.5 1.5h13A1.5 1.5 0 0 0 16 13V6a1.5 1.5 0 0 0-1.5-1.5h-13A1.5 1.5 0 0 0 0 6v7zm1.5.5A.5.5 0 0 1 1 13V6a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-13z" />
                </svg>
                Business
              </span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link px-3" href="about.php">
              <span class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                  class="bi bi-info-circle me-1" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                  <path
                    d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                </svg>
                About
              </span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link px-3" href="list-story.php">
              <span class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                  class="bi bi-pencil-square me-1" viewBox="0 0 16 16">
                  <path
                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                  <path fill-rule="evenodd"
                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                </svg>
                List Your Story
              </span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link px-3" href="contact.php">
              <span class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                  class="bi bi-envelope me-1" viewBox="0 0 16 16">
                  <path
                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741zM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                </svg>
                Contact
              </span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="container my-4">
    <!-- Story Content - Left Image Layout -->
    <article class="bg-white rounded-4 shadow-sm p-4 p-md-5 mb-4 border-0">
      <div class="row g-4">
        <!-- Left Column - Image -->
        <div class="col-md-4">
          <?php if (!empty($story['thumbnail'])): ?>
            <figure class="mb-0 overflow-hidden rounded-3">
              <img src="<?= htmlspecialchars($story['thumbnail']) ?>" class="img-fluid w-100"
                alt="<?= htmlspecialchars($story['title']) ?>" style="height: 250px; object-fit: cover;" loading="lazy">
            </figure>
          <?php endif; ?>
        </div>

        <!-- Right Column - Content -->
        <div class="col-md-8">
          <!-- Story Header -->
          <header class="mb-4">
            <div class="d-flex align-items-center gap-3 mb-3">
              <span
                class="badge bg-orange text-white"><?= htmlspecialchars($story['category_name'] ?? 'General') ?></span>
              <span class="text-muted small d-flex align-items-center">
                <i class="bi bi-calendar me-1"></i>
                <?= date('F j, Y', strtotime($story['created_at'])) ?>
              </span>
            </div>
            <h1 class="display-5 fw-bold mb-3"><?= htmlspecialchars($story['title']) ?></h1>
          </header>

          <!-- Story Content -->
          <div class="content lh-base">
            <?php
            $paragraphs = preg_split('/\r\n|\r|\n/', trim($story['content']));
            foreach ($paragraphs as $para) {
              if (trim($para) !== '') {
                echo '<p class="mb-3">' . htmlspecialchars($para) . '</p>';
              }
            }
            ?>
          </div>
        </div>
      </div>
    </article>

    <!-- Gallery Section -->
    <?php if (!empty($story['gallery'])):
      $gallery = json_decode($story['gallery']); ?>
      <section class="bg-white rounded-4 shadow-sm p-4 p-md-5 mb-4 border-0">
        <h2 class="h4 mb-4 pb-2 border-bottom d-flex align-items-center">
          <i class="bi bi-images text-orange me-2"></i>
          Gallery
        </h2>
        <div class="row g-3">
          <?php foreach ($gallery as $index => $img): ?>
            <div class="col-6 col-md-4 col-lg-3">
              <div class="gallery-item overflow-hidden rounded-3 shadow-sm">
                <img src="<?= htmlspecialchars($img) ?>" class="img-fluid w-100 h-100 gallery-image"
                  style="height: 120px; object-fit: cover; cursor: zoom-in; transition: transform 0.3s ease;" loading="lazy"
                  data-bs-toggle="modal" data-bs-target="#galleryModal" data-index="<?= $index ?>"
                  onclick="openGalleryModal(<?= $index ?>)">
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </section>

      <!-- Gallery Modal -->
      <div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content bg-transparent border-0">
            <div class="modal-header border-0">
              <button type="button" class="btn-close btn-close-black bg-white opacity-100 rounded-circle p-2 ms-auto"
                data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-0">
              <img id="modalImage" src="" class="img-fluid rounded-3" style="max-height: 80vh;">
            </div>
            <div class="modal-footer border-0 justify-content-between">
              <button class="btn btn-dark rounded-circle p-2" onclick="prevImage()">
                <i class="bi bi-chevron-left"></i>
              </button>
              <span id="imageCounter" class="text-white"></span>
              <button class="btn btn-dark rounded-circle p-2" onclick="nextImage()">
                <i class="bi bi-chevron-right"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

      <script>
        let currentGallery = <?= json_encode($gallery) ?>;
        let currentIndex = 0;

        function openGalleryModal(index) {
          currentIndex = index;
          updateModalImage();
        }

        function updateModalImage() {
          const modalImage = document.getElementById('modalImage');
          modalImage.src = currentGallery[currentIndex];
          document.getElementById('imageCounter').textContent = `${currentIndex + 1} / ${currentGallery.length}`;
        }

        function nextImage() {
          if (currentIndex < currentGallery.length - 1) {
            currentIndex++;
            updateModalImage();
          }
        }

        function prevImage() {
          if (currentIndex > 0) {
            currentIndex--;
            updateModalImage();
          }
        }

        // Keyboard navigation
        document.addEventListener('keydown', function (e) {
          const modal = document.getElementById('galleryModal');
          if (modal.classList.contains('show')) {
            if (e.key === 'ArrowRight') {
              nextImage();
            } else if (e.key === 'ArrowLeft') {
              prevImage();
            } else if (e.key === 'Escape') {
              bootstrap.Modal.getInstance(modal).hide();
            }
          }
        });

        // Swipe support for mobile
        let touchStartX = 0;
        let touchEndX = 0;

        document.getElementById('modalImage').addEventListener('touchstart', e => {
          touchStartX = e.changedTouches[0].screenX;
        }, false);

        document.getElementById('modalImage').addEventListener('touchend', e => {
          touchEndX = e.changedTouches[0].screenX;
          handleSwipe();
        }, false);

        function handleSwipe() {
          if (touchEndX < touchStartX - 50) {
            nextImage(); // Swipe left
          }
          if (touchEndX > touchStartX + 50) {
            prevImage(); // Swipe right
          }
        }
      </script>
    <?php endif; ?>

    <!-- Author Section -->
    <section class="bg-white rounded-4 shadow-sm p-4 p-md-5 mb-4 border-0">
      <h2 class="h4 mb-4 pb-2 border-bottom d-flex align-items-center">
        <i class="bi bi-person-circle text-orange me-2"></i>
        Submitted By
      </h2>
      <div class="row">
        <div class="col-md-8">
          <div class="d-flex flex-column gap-3">
            <div class="d-flex align-items-start">
              <i class="bi bi-person-fill text-muted me-3 mt-1"></i>
              <div>
                <h5 class="h6 mb-1 text-muted">Name</h5>
                <p class="mb-0"><?= htmlspecialchars($story['user_name']) ?></p>
              </div>
            </div>
            <div class="d-flex align-items-start">
              <i class="bi bi-telephone-fill text-muted me-3 mt-1"></i>
              <div>
                <h5 class="h6 mb-1 text-muted">Contact</h5>
                <p class="mb-0"><?= htmlspecialchars($story['user_contact']) ?></p>
              </div>
            </div>
            <div class="d-flex align-items-start">
              <i class="bi bi-geo-alt-fill text-muted me-3 mt-1"></i>
              <div>
                <h5 class="h6 mb-1 text-muted">Address</h5>
                <p class="mb-0"><?= nl2br(htmlspecialchars($story['user_address'])) ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Related Services -->
    <?php
    $services = $pdo->query("SELECT * FROM services ORDER BY id DESC")->fetchAll();
    if (!empty($services)): ?>
      <section class="my-4">
        <h2 class="h4 mb-4 pb-2 border-bottom">Related Services</h2>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
          <?php foreach ($services as $service): ?>
            <div class="col">
              <div class="card h-100 shadow-sm border-0">
                <?php if (!empty($service['image'])): ?>
                  <img src="<?= htmlspecialchars($service['image']) ?>" class="card-img-top"
                    style="height: 180px; object-fit: cover;" loading="lazy">
                <?php endif; ?>
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title"><?= htmlspecialchars($service['name']) ?></h5>
                  <p class="card-text small text-muted"><?= htmlspecialchars($service['short_description']) ?></p>
                  <a href="contact.php" class="btn btn-sm btn-primary mt-auto">Get Service</a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </section>
    <?php endif; ?>
  </main>



  <?php include 'includes/footer.php'; ?>

  <!-- Custom Styles -->
  <style>
    .navbar {
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
    }

    .navbar.scrolled {
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
      background-color: rgba(255, 255, 255, 0.1);
      transform: translateY(-2px);
    }

    .content p {
      margin-bottom: 1.5rem;
      line-height: 1.7;
    }

    .content img {
      max-width: 100%;
      height: auto;
      border-radius: 8px;
      margin: 1.5rem 0;
    }

    .gallery-zoomable {
      transition: transform 0.3s ease;
    }

    .gallery-zoomable:hover {
      transform: scale(1.03);
    }

    @media (max-width: 768px) {
      .content {
        font-size: 1rem;
      }
    }
  </style>

  <!-- JavaScript -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script>
    // Navbar scroll effect
    window.addEventListener('scroll', function () {
      const navbar = document.querySelector('.navbar');
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });

    // Simple image zoom functionality
    document.querySelectorAll('.gallery-zoomable').forEach(img => {
      img.addEventListener('click', function () {
        this.classList.toggle('zoomed');
      });
    });
  </script>
</body>

</html>