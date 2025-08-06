<?php
// Prevent double session_start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!-- Admin Sidebar Navigation -->
<div class="d-flex flex-column p-3 bg-dark text-white vh-100" style="width: 250px; position: fixed;">
    <div class="sidebar-header mb-4 d-flex align-items-center">
        <h4 class="mb-0 text-white">Admin Panel</h4>
        <small class="ms-2 text-muted">v1.0</small>
    </div>
    
    <hr class="my-2 bg-secondary">
    
    <div class="d-flex align-items-center mb-4">
        <div class="me-2">
            <i class="bi bi-person-circle fs-4"></i>
        </div>
        <div>
            <div class="fw-bold"><?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?></div>
            <!-- <small class="text-white">Last login: <?= date('M j, g:i a', $_SESSION['last_activity'] ?? time()) ?></small> -->
        </div>
    </div>
    
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="dashboard.php" class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : '' ?>">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="stories.php" class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) === 'stories.php' ? 'active' : '' ?>">
                <i class="bi bi-book me-2"></i>Manage Stories
            </a>
        </li>
        <li class="nav-item">
            <a href="categories.php" class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) === 'categories.php' ? 'active' : '' ?>">
                <i class="bi bi-tags me-2"></i>Manage Categories
            </a>
        </li>
        <li class="nav-item">
            <a href="submissions.php" class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) === 'submissions.php' ? 'active' : '' ?>">
                <i class="bi bi-upload me-2"></i>User Submissions
            </a>
        </li>
        <li class="nav-item">
            <a href="messages.php" class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) === 'messages.php' ? 'active' : '' ?>">
                <i class="bi bi-envelope me-2"></i>Messages
            </a>
        </li>
        <li class="nav-item">
    <a href="services.php" class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) === 'services.php' ? 'active' : '' ?>">
        <i class="bi bi-gear-wide-connected me-2"></i>Services
    </a>
</li>
    </ul>
    
    <hr class="my-2 bg-secondary">
    
    <ul class="nav nav-pills flex-column">
        <li class="nav-item">
            <a href="change-password.php" class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) === 'change-password.php' ? 'active' : '' ?>">
                <i class="bi bi-shield-lock me-2"></i>Change Password
            </a>
        </li>
        <li class="nav-item">
            <a href="logout.php" class="nav-link text-danger" onclick="return confirm('Are you sure you want to logout?');">
                <i class="bi bi-box-arrow-right me-2"></i>Logout
            </a>
        </li>
    </ul>
    
    <div class="mt-auto pt-3 border-top border-secondary">
        <small class="text-muted">© <?= date('Y') ?> Your Company</small>
    </div>
</div>

<!-- Include Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">

<style>
    .nav-link {
        transition: all 0.2s;
        border-radius: 4px;
        margin-bottom: 2px;
    }
    .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }
    .nav-link.active {
        background-color: rgba(255, 255, 255, 0.2);
        font-weight: 500;
    }
    .sidebar-header {
        padding-bottom: 0.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
</style>