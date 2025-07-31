<?php
$pageTitle = "Change Password";
require_once 'includes/layout.php';
require_once '../includes/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE id = ?");
    $stmt->execute([$_SESSION['admin_id']]);
    $admin = $stmt->fetch();

    if ($admin && hash('sha256', $current) === $admin['password_hash']) {
        $stmt = $pdo->prepare("UPDATE admins SET password_hash = ? WHERE id = ?");
        $stmt->execute([hash('sha256', $new), $_SESSION['admin_id']]);
        $success = "Password changed successfully.";
    } else {
        $error = "Current password is incorrect.";
    }
}
?>

<h2 class="mb-4">Change Password</h2>

<form method="POST" class="col-md-6">
  <div class="mb-3">
    <label>Current Password</label>
    <input name="current_password" type="password" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>New Password</label>
    <input name="new_password" type="password" class="form-control" required>
  </div>
  <button class="btn btn-primary">Change Password</button>

  <?php if ($error): ?>
    <div class="alert alert-danger mt-3"><?= $error ?></div>
  <?php elseif ($success): ?>
    <div class="alert alert-success mt-3"><?= $success ?></div>
  <?php endif; ?>
</form>

<?php include 'includes/footer.php'; ?>
