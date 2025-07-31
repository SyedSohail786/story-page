<?php
$pageTitle = "Manage Categories";
require_once 'includes/layout.php';
require_once '../includes/db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $slug = strtolower(preg_replace('/[^a-z0-9]+/', '-', $name));
    if (!empty($_POST['id'])) {
        $stmt = $pdo->prepare("UPDATE categories SET name = ?, slug = ? WHERE id = ?");
        $stmt->execute([$name, $slug, $_POST['id']]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO categories (name, slug) VALUES (?, ?)");
        $stmt->execute([$name, $slug]);
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

// Load category to edit (if any)
$editCategory = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $editCategory = $stmt->fetch();
}
?>

<h2 class="mb-4">Manage Categories</h2>

<form method="POST" class="mb-4">
  <input type="hidden" name="id" value="<?= $editCategory['id'] ?? '' ?>">
  <div class="input-group">
    <input name="name" class="form-control" placeholder="Category Name" required
           value="<?= htmlspecialchars($editCategory['name'] ?? '') ?>">
    <button class="btn btn-primary">Save</button>
  </div>
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
