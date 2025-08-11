<?php
require_once 'includes/db.php';
$filterType = $_GET['type'] ?? '';
$query = "SELECT * FROM businesses";
$params = [];
if ($filterType) {
  $query .= " WHERE type = ?";
  $params[] = $filterType;
}
$businesses = $pdo->prepare($query);
$businesses->execute($params);
$types = $pdo->query("SELECT DISTINCT type FROM businesses")->fetchAll(PDO::FETCH_COLUMN);
$metaTitle = "Business Directory - StoryPortal";
$metaDesc = "Browse our directory of local businesses and services.";
include 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $metaTitle ?></title>
  <meta name="description" content="<?= $metaDesc ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">

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

<!-- Modern Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background: linear-gradient(135deg, #fd7e14 0%, #ff4500 100%); box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
  <div class="container">
    <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php">
      <span class="logo-icon me-2" style="width: 30px; height: 30px; background-color: white; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fd7e14" viewBox="0 0 16 16">
          <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
          <path d="m10.273 2.513-.921-.944.715-.698.622.637.89-.011a2.89 2.89 0 0 1 2.924 2.924l-.01.89.636.622a2.89 2.89 0 0 1 0 4.134l-.637.622.011.89a2.89 2.89 0 0 1-2.924 2.924l-.89-.01-.622.636a2.89 2.89 0 0 1-4.134 0l-.622-.637-.89.011a2.89 2.89 0 0 1-2.924-2.924l.01-.89-.636-.622a2.89 2.89 0 0 1 0-4.134l.637-.622-.011-.89a2.89 2.89 0 0 1 2.924-2.924l.89.01.622-.636a2.89 2.89 0 0 1 4.134 0l-.715.698a1.89 1.89 0 0 0-2.704 0l-.92.944-1.32-.016a1.89 1.89 0 0 0-1.911 1.912l.016 1.318-.944.921a1.89 1.89 0 0 0 0 2.704l.944.92-.016 1.32a1.89 1.89 0 0 0 1.912 1.911l1.318-.016.921.944a1.89 1.89 0 0 0 2.704 0l.92-.944 1.32.016a1.89 1.89 0 0 0 1.911-1.912l-.016-1.318.944-.921a1.89 1.89 0 0 0 0-2.704l-.944-.92.016-1.32a1.89 1.89 0 0 0-1.912-1.911l-1.318.016z"/>
        </svg>
      </span>
      StoryPortal
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link px-3" href="index.php">
            <span class="d-flex align-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door me-1" viewBox="0 0 16 16">
                <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z"/>
              </svg>
              Home
            </span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3" href="category.php">
            <span class="d-flex align-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-collection me-1" viewBox="0 0 16 16">
                <path d="M2.5 3.5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-11zm2-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM0 13a1.5 1.5 0 0 0 1.5 1.5h13A1.5 1.5 0 0 0 16 13V6a1.5 1.5 0 0 0-1.5-1.5h-13A1.5 1.5 0 0 0 0 6v7zm1.5.5A.5.5 0 0 1 1 13V6a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-13z"/>
              </svg>
              Category
            </span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3" href="events.php">
            <span class="d-flex align-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-collection me-1" viewBox="0 0 16 16">
                <path d="M2.5 3.5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-11zm2-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM0 13a1.5 1.5 0 0 0 1.5 1.5h13A1.5 1.5 0 0 0 16 13V6a1.5 1.5 0 0 0-1.5-1.5h-13A1.5 1.5 0 0 0 0 6v7zm1.5.5A.5.5 0 0 1 1 13V6a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-13z"/>
              </svg>
              Events
            </span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3 active" href="businesses.php">
            <span class="d-flex align-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shop me-1" viewBox="0 0 16 16">
                <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z"/>
              </svg>
              Business
            </span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3" href="about.php">
            <span class="d-flex align-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle me-1" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
              </svg>
              About
            </span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3" href="list-story.php">
            <span class="d-flex align-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square me-1" viewBox="0 0 16 16">
                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
              </svg>
              List Your Story
            </span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3" href="contact.php">
            <span class="d-flex align-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope me-1" viewBox="0 0 16 16">
                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741zM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
              </svg>
              Contact
            </span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<main class="container my-2">
<?php
// Get type filter from URL
$type = $_GET['type'] ?? '';

// Prepare query with type filter
if (!empty($type)) {
    $stmt = $pdo->prepare("SELECT * FROM businesses WHERE type = ? ORDER BY views DESC");
    $stmt->execute([$type]);
} else {
    $stmt = $pdo->query("SELECT * FROM businesses ORDER BY views DESC");
}

// Fetch all businesses (filtered or all)
$businessList = $stmt->fetchAll();

// Limit to top 4 for display
$businessList = array_slice($businessList, 0, 4);
?>
<div class="container my-5 p-0">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0" style="color: #fd7e14;">
      <?= !empty($type) ? htmlspecialchars($type) . ' Businesses' : 'Top Businesses' ?>
    </h2>
    <div class="dropdown">
      <button class="btn btn-outline-orange dropdown-toggle" type="button" id="typeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filter me-1" viewBox="0 0 16 16">
          <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
        </svg>
        Filter by Type
      </button>
      <ul class="dropdown-menu" aria-labelledby="typeDropdown">
        <li><a class="dropdown-item <?= !$filterType ? 'active' : '' ?>" href="businesses.php">All Types</a></li>
        <li><hr class="dropdown-divider"></li>
        <?php foreach ($types as $type): ?>
          <li>
            <a class="dropdown-item <?= ($type === $filterType) ? 'active' : '' ?>" href="businesses.php?type=<?= urlencode($type) ?>">
              <?= htmlspecialchars($type) ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>

  <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
    <?php 
    $rank = 1;
    foreach ($businessList as $biz): 
    ?>
    <div class="col">
      <div class="card h-100 border-0 shadow-sm position-relative">
        <!-- Rank Badge -->
        <div class="position-absolute bg-orange text-white px-2 py-1 rounded-end" 
             style="top:10px; left:0; font-size: 0.8rem; z-index:1;">
          #<?= $rank++ ?>
        </div>

        <img src="<?= htmlspecialchars($biz['image']) ?>" class="card-img-top" style="height: 180px; object-fit: cover;">
        <div class="card-body p-3">
          <h5 class="card-title fs-6 mb-1"><?= htmlspecialchars($biz['name']) ?></h5>
        </div>
        <div class="card-footer bg-transparent border-0 pt-0 px-3 pb-3">
          <a href="business/<?= urlencode($biz['slug']) ?>" class="btn btn-sm btn-orange w-100 py-2">View Details</a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>

</main>

<?php include 'includes/footer.php'; ?>

<style>
  body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    background-color: #f8f9fa;
  }
  
  .navbar {
    transition: all 0.3s ease;
  }
  
  .navbar.scrolled {
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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
    background-color: rgba(255,255,255,0.1);
    transform: translateY(-2px);
  }
  
  .nav-link.active {
    background-color: rgba(255,255,255,0.2);
    font-weight: 600;
  }
  
  .nav-link.active:before {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 20px;
    height: 3px;
    background-color: white;
    border-radius: 3px;
  }
  
  .bg-orange {
    background-color: #fd7e14 !important;
  }
  
  .btn-orange {
    background-color: #fd7e14;
    color: white;
  }
  
  .btn-orange:hover {
    background-color: #e67300;
    color: white;
  }
  
  .btn-outline-orange {
    border-color: #fd7e14;
    color: #fd7e14;
  }
  
  .btn-outline-orange:hover {
    background-color: #fd7e14;
    color: white;
  }
  
  .story-card {
    transition: all 0.3s ease;
    border-radius: 12px;
    overflow: hidden;
  }
  
  .story-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
  }
  
  .card-img-overlay .badge {
    opacity: 0;
    transition: opacity 0.3s ease;
  }
  
  .story-card:hover .card-img-overlay .badge {
    opacity: 1;
  }
  
  .text-truncate-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  
  @media (max-width: 992px) {
    .nav-link {
      margin: 2px 0;
      padding: 8px 12px !important;
    }
    
    .nav-link.active:before {
      display: none;
    }
  }
</style>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Close navbar when clicking a link
    const navLinks = document.querySelectorAll('.nav-link');
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (navbarCollapse.classList.contains('show')) {
                navbarToggler.click();
            }
        });
    });
});
</script>
</body>
</html>