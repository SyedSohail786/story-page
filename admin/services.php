<?php
// Security and session checks
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
$pageTitle = "Manage Services";
require_once 'includes/layout.php';
require_once '../includes/db.php';

// Initialize variables
$errors = [];
$success = '';
$editService = null;

// Load service to edit
if (isset($_GET['edit'])) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM services WHERE id = ?");
        $stmt->execute([$_GET['edit']]);
        $editService = $stmt->fetch();
        
        if (!$editService) {
            $errors[] = "Service not found";
        }
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        $errors[] = "Database error occurred";
    }
}

// Slug generator with improved handling
function generateSlug($text) {
    $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
    $text = preg_replace('/[^a-zA-Z0-9]+/', '-', $text);
    $text = strtolower(trim($text, '-'));
    return $text;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate inputs
    $name = trim($_POST['name'] ?? '');
    $short_description = trim($_POST['short_description'] ?? '');
    $id = $_POST['id'] ?? null;
    
    if (empty($name)) {
        $errors[] = "Service name is required";
    }
    
    if (empty($short_description)) {
        $errors[] = "Short description is required";
    }
    
    $slug = generateSlug($name);
    
    // Handle file upload
    $image = $editService['image'] ?? null;
    if (!empty($_FILES['image']['name'])) {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        
        if (!in_array($fileExtension, $allowedExtensions)) {
            $errors[] = "Only JPG, JPEG, PNG, GIF, and WEBP files are allowed";
        } elseif ($_FILES['image']['size'] > 5 * 1024 * 1024) { // 5MB limit
            $errors[] = "File size must be less than 5MB";
        } else {
            $uploadDir = '../uploads/services/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $newFilename = uniqid() . '.' . $fileExtension;
            $destination = $uploadDir . $newFilename;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                // Delete old image if exists
                if (!empty($editService['image']) && file_exists('../' . $editService['image'])) {
                    unlink('../' . $editService['image']);
                }
                $image = 'uploads/services/' . $newFilename;
            } else {
                $errors[] = "Failed to upload image";
            }
        }
    }
    
    // Process if no errors
    if (empty($errors)) {
        try {
            if (!empty($id)) {
                $stmt = $pdo->prepare("UPDATE services SET name = ?, slug = ?, short_description = ?, image = ?, updated_at = NOW() WHERE id = ?");
                $stmt->execute([$name, $slug, $short_description, $image, $id]);
                $success = "Service updated successfully";
            } else {
                $stmt = $pdo->prepare("INSERT INTO services (name, slug, short_description, image, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
                $stmt->execute([$name, $slug, $short_description, $image]);
                $success = "Service added successfully";
            }
            
            // Redirect to prevent form resubmission
            header("Location: services.php?success=" . urlencode($success));
            exit;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            $errors[] = "Database error occurred while saving";
        }
    }
}

// Handle delete with CSRF protection
if (isset($_GET['delete']) && isset($_GET['csrf_token']) && $_GET['csrf_token'] === $_SESSION['csrf_token']) {
    try {
        // First get the service to delete its image
        $stmt = $pdo->prepare("SELECT image FROM services WHERE id = ?");
        $stmt->execute([$_GET['delete']]);
        $service = $stmt->fetch();
        
        if ($service) {
            // Delete the record
            $stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
            $stmt->execute([$_GET['delete']]);
            
            // Delete the associated image
            if (!empty($service['image']) && file_exists('../' . $service['image'])) {
                unlink('../' . $service['image']);
            }
            
            $success = "Service deleted successfully";
        }
        
        header("Location: services.php?success=" . urlencode($success));
        exit;
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        $errors[] = "Database error occurred while deleting";
    }
}

// Generate CSRF token if not exists
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Display success message if redirected with one
if (isset($_GET['success'])) {
    $success = htmlspecialchars($_GET['success']);
}

// Fetch all services with pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

try {
    // Get total count for pagination
    $totalServices = $pdo->query("SELECT COUNT(*) FROM services")->fetchColumn();
    $totalPages = ceil($totalServices / $limit);
    
    // Get paginated services
    $stmt = $pdo->prepare("SELECT * FROM services ORDER BY created_at DESC LIMIT ? OFFSET ?");
    $stmt->bindValue(1, $limit, PDO::PARAM_INT);
    $stmt->bindValue(2, $offset, PDO::PARAM_INT);
    $stmt->execute();
    $services = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $errors[] = "Failed to load services";
}
?>

<div class="container-fluid">
    <!-- Success/Error Messages -->
    <?php if (!empty($success)): ?>
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <?= $success ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0"><i class="bi bi-gear-wide-connected me-2"></i>Manage Services</h2>
                <!-- <a href="services.php" class="btn btn-outline-primary">
                    <i class="bi bi-plus-lg me-1"></i> Add New Service
                </a> -->
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Form Column -->
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title text-primary mb-3">
                        <i class="bi bi-pencil-square me-1"></i>
                        <?= $editService ? 'Edit' : 'Add New' ?> Service
                    </h5>

                    <form method="POST" enctype="multipart/form-data" id="serviceForm">
                        <input type="hidden" name="id" value="<?= $editService['id'] ?? '' ?>">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                        <div class="mb-3">
                            <label class="form-label">Service Name *</label>
                            <input type="text" name="name" class="form-control" required
                                   value="<?= htmlspecialchars($editService['name'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Short Description *</label>
                            <textarea name="short_description" rows="3" class="form-control" required><?= htmlspecialchars($editService['short_description'] ?? '') ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <?php if (!empty($editService['image'])): ?>
                                <div class="mt-2">
                                    <img src="../<?= $editService['image'] ?>" class="img-thumbnail" style="max-height: 150px;">
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" name="remove_image" id="removeImage">
                                        <label class="form-check-label" for="removeImage">Remove current image</label>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <small class="text-muted">Max size: 5MB. Allowed: JPG, PNG, GIF, WEBP</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Save Service
                            </button>
                            <?php if ($editService): ?>
                                <a href="services.php" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-lg me-1"></i> Cancel
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- List Column -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title text-primary mb-0">
                            <i class="bi bi-list-ul me-1"></i> All Services
                        </h5>
                        <div class="d-flex">
                            <input type="text" id="searchInput" class="form-control form-control-sm me-2" placeholder="Search services...">
                            <select id="itemsPerPage" class="form-select form-select-sm" style="width: 80px;">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="servicesTable">
                            <thead class="table-light">
                                <tr>
                                    <th width="80">Image</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Created</th>
                                    <th width="120">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($services)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">No services found</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($services as $s): ?>
                                        <tr>
                                            <td>
                                                <?php if (!empty($s['image'])): ?>
                                                    <img src="../<?= $s['image'] ?>" width="60" height="60" style="object-fit: cover;" class="rounded">
                                                <?php else: ?>
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="bi bi-image text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <strong><?= htmlspecialchars($s['name']) ?></strong>
                                                <div class="text-muted small">/<?= htmlspecialchars($s['slug']) ?></div>
                                            </td>
                                            <td>
                                                <?= htmlspecialchars(mb_strimwidth($s['short_description'], 0, 100, '...')) ?>
                                            </td>
                                            <td>
                                                <small class="text-muted"><?= date('M j, Y', strtotime($s['created_at'])) ?></small>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="?edit=<?= $s['id'] ?>" class="btn btn-outline-primary" title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <a href="?delete=<?= $s['id'] ?>&csrf_token=<?= $_SESSION['csrf_token'] ?>" 
                                                       class="btn btn-outline-danger" 
                                                       title="Delete"
                                                       onclick="return confirm('Are you sure you want to delete this service?')">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <?php if ($totalPages > 1): ?>
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center mt-3">
                                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>
                                
                                <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript Enhancements -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#servicesTable tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }
    
    // Items per page selector
    const itemsPerPage = document.getElementById('itemsPerPage');
    if (itemsPerPage) {
        itemsPerPage.addEventListener('change', function() {
            // In a real implementation, this would reload the page with new limit
            // For now just showing an alert
            alert('Items per page changed to ' + this.value);
        });
    }
    
    // Form validation
    const serviceForm = document.getElementById('serviceForm');
    if (serviceForm) {
        serviceForm.addEventListener('submit', function(e) {
            const name = this.elements['name'].value.trim();
            const description = this.elements['short_description'].value.trim();
            
            if (!name || !description) {
                e.preventDefault();
                alert('Please fill in all required fields');
            }
        });
    }
});
</script>

<?php include 'includes/footer.php'; ?>