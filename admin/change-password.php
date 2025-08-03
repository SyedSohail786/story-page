<?php
$pageTitle = "Change Password";
require_once 'includes/layout.php';
require_once '../includes/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE id = ?");
    $stmt->execute([$_SESSION['admin_id']]);
    $admin = $stmt->fetch();

    if ($new !== $confirm) {
        $error = "New passwords do not match.";
    } elseif (strlen($new) < 8) {
        $error = "Password must be at least 8 characters long.";
    } elseif ($admin && hash('sha256', $current) === $admin['password_hash']) {
        $stmt = $pdo->prepare("UPDATE admins SET password_hash = ? WHERE id = ?");
        $stmt->execute([hash('sha256', $new), $_SESSION['admin_id']]);
        $success = "Password changed successfully!";
    } else {
        $error = "Current password is incorrect.";
    }
}
?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 d-inline-block mb-3">
                            <i class="bi bi-shield-lock fs-2"></i>
                        </div>
                        <h2 class="h4">Change Password</h2>
                        <p class="text-muted">Update your account password</p>
                    </div>

                    <?php if ($error): ?>
                        <div class="alert alert-danger d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <?= $error ?>
                        </div>
                    <?php elseif ($success): ?>
                        <div class="alert alert-success d-flex align-items-center">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <?= $success ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Current Password</label>
                            <div class="input-group">
                                <input name="current_password" type="password" class="form-control form-control-lg" required>
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">New Password</label>
                            <div class="input-group">
                                <input name="new_password" type="password" class="form-control form-control-lg" required>
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <small class="text-muted">Minimum 8 characters</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Confirm New Password</label>
                            <div class="input-group">
                                <input name="confirm_password" type="password" class="form-control form-control-lg" required>
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button class="btn btn-primary btn-lg" type="submit">
                                <i class="bi bi-key me-2"></i> Change Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const icon = this.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    });
</script>

<?php include 'includes/footer.php'; ?>