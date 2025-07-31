<?php
require_once 'includes/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
  $stmt->execute([
    $_POST['name'],
    $_POST['email'],
    $_POST['subject'],
    $_POST['message']
  ]);
  $msg = "Thank you for contacting us!";
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

<!-- Main Content Area -->
<div class="container-fluid d-flex flex-column flex-grow-1 bg-light">
  <div class="container my-5 py-4 flex-grow-1">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card shadow-sm border-0">
          <div class="card-body p-4 p-md-5">
            <h3 class="mb-4 text-center" style="color: #fd7e14;">Contact Us</h3>
            <?php if (!empty($msg)) echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>$msg<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>"; ?>
            
            <form method="POST" class="needs-validation" novalidate>
              <div class="mb-4">
                <label for="name" class="form-label">Your Name</label>
                <input type="text" name="name" class="form-control form-control-lg" id="name" placeholder="John Doe" required>
                <div class="invalid-feedback">Please provide your name.</div>
              </div>
              
              <div class="mb-4">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control form-control-lg" id="email" placeholder="you@example.com" required>
                <div class="invalid-feedback">Please provide a valid email.</div>
              </div>

              <div class="mb-4">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" name="subject" class="form-control form-control-lg" id="subject" placeholder="Subject of your message" required>
                    <div class="invalid-feedback">Please provide a subject.</div>
               </div>

              
              <div class="mb-4">
                <label for="message" class="form-label">Your Message</label>
                <textarea name="message" class="form-control" id="message" rows="5" placeholder="How can we help you?" required></textarea>
                <div class="invalid-feedback">Please write your message.</div>
              </div>
              
              <div class="text-center">
                <button class="btn btn-lg px-5" style="background-color: #fd7e14; color: white;" type="submit">Send Message</button>
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
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }
  
  .card {
    border-radius: 10px;
    border: none;
  }
  
  .form-control:focus {
    border-color: #fd7e14;
    box-shadow: 0 0 0 0.25rem rgba(253, 126, 20, 0.25);
  }
  
  .btn:hover {
    background-color: #e67300 !important;
  }
</style>

<script>
// Form validation
(function () {
  'use strict'
  
  var forms = document.querySelectorAll('.needs-validation')
  
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