<?php
require_once 'includes/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
  $stmt->execute([
    $_POST['name'], $_POST['email'], $_POST['message']
  ]);
  $msg = "Thank you for contacting us!";
}
?>
<?php include 'includes/header.php'; ?>
<div class="container my-5">
  <h3>Contact / Help</h3>
  <?php if (!empty($msg)) echo "<div class='alert alert-success'>$msg</div>"; ?>
  <form method="POST">
    <div class="mb-3"><input name="name" class="form-control" placeholder="Your Name" required></div>
    <div class="mb-3"><input name="email" class="form-control" placeholder="Your Email" required></div>
    <div class="mb-3"><textarea name="message" class="form-control" rows="5" placeholder="Your Message" required></textarea></div>
    <button class="btn btn-primary">Send</button>
  </form>
</div>
<?php include 'includes/footer.php'; ?>
