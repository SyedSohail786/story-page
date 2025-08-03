<?php
session_start();
require_once '../includes/db.php';

// Security headers
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("X-XSS-Protection: 1; mode=block");

// Initialize variables
$error = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Basic input validation
    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password.";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
            $stmt->execute([$username]);
            $admin = $stmt->fetch();

            if ($admin && hash('sha256', $password) === $admin['password_hash']) {
                // Regenerate session ID to prevent session fixation
                session_regenerate_id(true);
                
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                $_SESSION['last_activity'] = time();
                
                // Redirect to dashboard
                header("Location: dashboard.php");
                exit;
            } else {
                // Generic error message to avoid revealing which field was wrong
                $error = "Invalid credentials.";
                // Small delay to slow down brute force attempts
                sleep(1);
            }
        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            $error = "A system error occurred. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .login-container {
            max-width: 400px;
            margin: 0 auto;
            padding-top: 5rem;
        }
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-form {
            background-color: #f8f9fa;
            padding: 2rem;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h3>Admin Login</h3>
        </div>
        
        <div class="login-form">
            <form method="POST" autocomplete="off">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" 
                           placeholder="Username" required autofocus
                           value="<?php echo htmlspecialchars($username, ENT_QUOTES); ?>">
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" 
                           class="form-control" placeholder="Password" required>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
                
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger mt-3">
                        <?php echo htmlspecialchars($error, ENT_QUOTES); ?>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>