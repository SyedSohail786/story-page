<?php
require_once 'includes/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("INSERT INTO submissions (name, email, phone, title, story) VALUES (?, ?, ?, ?, ?)");
  $stmt->execute([
    $_POST['name'], $_POST['email'], $_POST['phone'], $_POST['title'], $_POST['story']
  ]);
  $msg = "Your story has been submitted! Our team will review it shortly.";
}
?>
<?php include 'includes/header.php'; ?>

<!-- LOGO and TOP ADS -->
<div class="container-fluid text-center py-4 bg-light">
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

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
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
        <li class="nav-item"><a class="nav-link active" href="list-story.php">List Your Story</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Main Content Area -->
<div class="container-fluid d-flex flex-column flex-grow-1 bg-light">
  <div class="container my-5 py-4 flex-grow-1">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card shadow-sm border-0">
          <div class="card-body p-4 p-md-5">
            <h3 class="mb-4 text-center text-primary">Share Your Story</h3>
            <?php if (!empty($msg)) echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>$msg<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>"; ?>
            
            <form method="POST" class="needs-validation" novalidate>
              <div class="row g-3">
                <div class="col-md-6 mb-3">
                  <label for="name" class="form-label">Your Name</label>
                  <input type="text" name="name" class="form-control" id="name" placeholder="John Doe" required>
                  <div class="invalid-feedback">Please provide your name.</div>
                </div>
                
                <div class="col-md-6 mb-3">
                  <label for="email" class="form-label">Email Address</label>
                  <input type="email" name="email" class="form-control" id="email" placeholder="you@example.com" required>
                  <div class="invalid-feedback">Please provide a valid email.</div>
                </div>
                
                <div class="col-12 mb-3">
                  <label for="phone" class="form-label">Phone Number (Optional)</label>
                  <input type="tel" name="phone" class="form-control" id="phone" placeholder="+1 (123) 456-7890">
                </div>
                
                <div class="col-12 mb-3">
                  <label for="title" class="form-label">Story Title</label>
                  <input type="text" name="title" class="form-control" id="title" placeholder="My Amazing Journey" required>
                  <div class="invalid-feedback">Please provide a title for your story.</div>
                </div>
                
                <div class="col-12 mb-4">
                  <label for="story" class="form-label">Your Story</label>
                  <textarea name="story" class="form-control" id="story" rows="6" placeholder="Tell us your inspiring story..." required></textarea>
                  <div class="invalid-feedback">Please write your story.</div>
                  <div class="form-text">Minimum 300 characters. HTML tags are not allowed.</div>
                </div>
                
                <div class="col-12 text-center">
                  <button class="btn btn-primary btn-lg px-5" type="submit">Submit Story</button>
                </div>
              </div>
            </form>
          </div>
        </div>
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
  
  .container-fluid.flex-grow-1 {
    flex: 1 0 auto;
  }
  
  .navbar {
    margin-bottom: 2rem;
  }
  
  textarea.form-control {
    min-height: 200px;
  }
  
  .card {
    border-radius: 10px;
  }
</style>

<script>
// Form validation example
(function () {
  'use strict'
  
  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')
  
  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }
        
        form.classList.add('was-validated')
      }, false)
    })
})()
</script>