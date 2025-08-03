<?php
$pageTitle = "Manage Categories";
require_once 'includes/layout.php';
require_once '../includes/db.php';

function generateSlug($text) {
    $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}

// Load category to edit
$editCategory = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $editCategory = $stmt->fetch();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $slug = generateSlug($name);

    // Icon upload
    $iconFile = $_FILES['icon'] ?? null;
    $iconName = $editCategory['icon'] ?? null;

    if ($iconFile && $iconFile['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($iconFile['name'], PATHINFO_EXTENSION);
        $iconName = uniqid() . '.' . $ext;
        move_uploaded_file($iconFile['tmp_name'], "../uploads/icons/" . $iconName);
    }

    if (!empty($_POST['id'])) {
        // Update
        $stmt = $pdo->prepare("UPDATE categories SET name = ?, slug = ?, icon = ? WHERE id = ?");
        $stmt->execute([$name, $slug, $iconName, $_POST['id']]);
    } else {
        // Insert
        $stmt = $pdo->prepare("INSERT INTO categories (name, slug, icon) VALUES (?, ?, ?)");
        $stmt->execute([$name, $slug, $iconName]);
    }

    header("Location: categories.php");
    exit;
}

// Handle delete
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: categories.php");
    exit;
}

// Fetch all
$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();
?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0"><i class="bi bi-tags me-2"></i>Manage Categories</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Categories</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="card-title text-primary mb-4">
                        <i class="bi bi-<?= $editCategory ? 'pencil' : 'plus' ?>-circle me-2"></i>
                        <?= $editCategory ? 'Edit' : 'Add New' ?> Category
                    </h5>
                    
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $editCategory['id'] ?? '' ?>">

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Category Name <span class="text-danger">*</span></label>
                            <input name="name" class="form-control form-control-lg" placeholder="Enter category name" required
                                   value="<?= htmlspecialchars($editCategory['name'] ?? '') ?>">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Category Icon</label>
                            <input type="file" name="icon" class="form-control" accept=".png,.jpg,.jpeg">
                            <small class="text-muted">Recommended size: 64×64 pixels</small>

                            <?php if (!empty($editCategory['icon'])): ?>
                                <div class="mt-3 d-flex align-items-center">
                                    <img src="../uploads/icons/<?= $editCategory['icon'] ?>" class="img-thumbnail me-3" style="width: 64px; height: 64px;">
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save me-2"></i>Save
                            </button>
                            <?php if ($editCategory): ?>
                                <a href="categories.php" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle me-2"></i>Cancel
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title text-primary mb-4"><i class="bi bi-list-ul me-2"></i>Category List</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="60">Icon</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th width="150" class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($categories)): ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="bi bi-exclamation-circle fs-2"></i>
                                            <p class="mt-2 mb-0">No categories found</p>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($categories as $c): ?>
                                        <tr>
                                            <td>
                                                <?php if (!empty($c['icon'])): ?>
                                                    <img src="../uploads/icons/<?= $c['icon'] ?>" class="rounded" width="40" height="40">
                                                <?php else: ?>
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                        <i class="bi bi-tag text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td class="fw-semibold"><?= htmlspecialchars($c['name']) ?></td>
                                            <td><code><?= htmlspecialchars($c['slug']) ?></code></td>
                                            <td class="text-end">
                                                <div class="d-flex gap-2 justify-content-end">
                                                    <a href="?edit=<?= $c['id'] ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                        <i class="bi bi-pencil me-1"></i> Edit
                                                    </a>
                                                    <a href="?delete=<?= $c['id'] ?>" 
                                                       onclick="return confirm('Are you sure you want to delete this category?')" 
                                                       class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                                        <i class="bi bi-trash me-1"></i> Delete
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
