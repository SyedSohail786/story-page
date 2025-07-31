<?php
require_once 'includes/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("INSERT INTO submissions (name, email, phone, title, story) VALUES (?, ?, ?, ?, ?)");
  $stmt->execute([
    $_POST['name'], $_POST['email'], $_POST['phone'], $_POST['title'], $_POST['story']
  ]);
  $msg = "Your story has been submitted!";
}
?>
<?php include 'includes/header.php'; ?>
<div class="container my-5">
  <h3>List Your Story</h3>
  <?php if (!empty($msg)) echo "<div class='alert alert-success'>$msg</div>"; ?>
  <form method="POST">
    <div class="mb-3"><input name="name" class="form-control" placeholder="Your Name" required></div>
    <div class="mb-3"><input name="email" class="form-control" placeholder="Your Email" required></div>
    <div class="mb-3"><input name="phone" class="form-control" placeholder="Phone Number"></div>
    <div class="mb-3"><input name="title" class="form-control" placeholder="Story Title" required></div>
    <div class="mb-3"><textarea name="story" class="form-control" rows="6" placeholder="Your Story" required></textarea></div>
    <button class="btn btn-primary">Submit</button>
  </form>
</div>
<?php include 'includes/footer.php'; ?>