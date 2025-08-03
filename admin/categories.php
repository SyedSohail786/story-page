<?php
$pageTitle = "Manage Categories";
require_once 'includes/layout.php';
require_once '../includes/db.php';

// Load category to edit (if any)
$editCategory = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $editCategory = $stmt->fetch();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $slug = strtolower(preg_replace('/[^a-z0-9]+/', '-', $name));

    // Handle icon upload
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

// Fetch categories
$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();
?>

<h2 class="mb-4">Manage Categories</h2>

<form method="POST" class="mb-4" enctype="multipart/form-data">
  <input type="hidden" name="id" value="<?= $editCategory['id'] ?? '' ?>">

  <div class="input-group mb-2">
    <input name="name" class="form-control" placeholder="Category Name" required
           value="<?= htmlspecialchars($editCategory['name'] ?? '') ?>">
  </div>

  <div class="mb-3">
    <label>Category Icon (PNG/JPG)</label>
    <input type="file" name="icon" class="form-control">
    <?php if (!empty($editCategory['icon'])): ?>
      <img src="../uploads/icons/<?= $editCategory['icon'] ?>" style="height: 40px;" class="mt-2">
    <?php endif; ?>
  </div>

  <button class="btn btn-primary">Save</button>
</form>

<div class="table-responsive">
  <table class="table table-bordered">
    <thead class="table-light">
      <tr><th>Name</th><th>Actions</th></tr>
    </thead>
    <tbody>
      <?php foreach ($categories as $c): ?>
        <tr>
          <td><?= htmlspecialchars($c['name']) ?></td>
          <td>
            <a href="?edit=<?= $c['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
            <a href="?delete=<?= $c['id'] ?>" onclick="return confirm('Delete this category?')" class="btn btn-sm btn-danger">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include 'includes/footer.php'; ?>
