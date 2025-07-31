<?php
session_start();
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if ($admin && hash('sha256', $password) === $admin['password_hash']) {
        $_SESSION['admin_id'] = $admin['id'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid credentials.";
    }
}
?>

<!-- Basic Bootstrap login form -->
<!DOCTYPE html>
<html>
<head><title>Admin Login</title>
<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
<h3>Admin Login</h3>
<form method="POST">
  <div class="mb-3"><input name="username" class="form-control" placeholder="Username" required></div>
  <div class="mb-3"><input name="password" type="password" class="form-control" placeholder="Password" required></div>
  <button type="submit" class="btn btn-primary">Login</button>
  <?php if (!empty($error)) echo "<div class='mt-2 text-danger'>$error</div>"; ?>
</form>
</body>
</html>
