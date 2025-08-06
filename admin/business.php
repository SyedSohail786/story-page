<?php
$pageTitle = "Manage Businesses";
require_once 'includes/layout.php';
require_once '../includes/db.php';

// Delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
  $pdo->prepare("DELETE FROM businesses WHERE id = ?")->execute([$_GET['delete']]);
  header("Location: business.php");
  exit;
}

// Editing
$editing = false;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
  $stmt = $pdo->prepare("SELECT * FROM businesses WHERE id = ?");
  $stmt->execute([$_GET['edit']]);
  $biz = $stmt->fetch();
  if ($biz) $editing = true;
}

// Submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $type = $_POST['type'];
  $description = $_POST['description'];

  $image = $biz['image'] ?? '';
  if (!empty($_FILES['image']['name'])) {
    $image = 'uploads/' . uniqid() . '_' . $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "../$image");
  }

  if ($editing) {
    $pdo->prepare("UPDATE businesses SET name=?, type=?, description=?, image=? WHERE id=?")
        ->execute([$name, $type, $description, $image, $biz['id']]);
  } else {
    $pdo->prepare("INSERT INTO businesses (name, type, description, image) VALUES (?, ?, ?, ?)")
        ->execute([$name, $type, $description, $image]);
  }

  header("Location: business.php");
  exit;
}

$businesses = $pdo->query("SELECT * FROM businesses ORDER BY created_at DESC")->fetchAll();
?>

<div class="container-fluid px-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Manage Businesses</h2>
    <?php if ($editing): ?>
      <a href="manage-business.php" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back to list
      </a>
    <?php endif; ?>
  </div>

  <div class="card shadow mb-4">
    <div class="card-header bg-white py-3">
      <h5 class="mb-0"><?= $editing ? 'Edit Business' : 'Add New Business' ?></h5>
    </div>
    <div class="card-body">
      <form method="POST" enctype="multipart/form-data">
        <div class="row g-3">
          <div class="col-md-6">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required 
                   value="<?= htmlspecialchars($biz['name'] ?? '') ?>">
          </div>
          <div class="col-md-6">
            <label for="type" class="form-label">Type</label>
            <input type="text" class="form-control" id="type" name="type" required 
                   value="<?= htmlspecialchars($biz['type'] ?? '') ?>">
          </div>
          <div class="col-12">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required><?= 
              htmlspecialchars($biz['description'] ?? '') ?></textarea>
          </div>
          <div class="col-12">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image">
            <?php if (!empty($biz['image'])): ?>
              <div class="mt-3 d-flex align-items-center">
                <img src="../<?= $biz['image'] ?>" class="img-thumbnail me-3" style="max-width:150px;">
                <a href="../<?= $biz['image'] ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                  <i class="fas fa-external-link-alt me-1"></i> View Full Image
                </a>
              </div>
            <?php endif; ?>
          </div>
          <div class="col-12">
            <button type="submit" class="btn btn-primary me-2">
              <i class="fas fa-save me-1"></i> <?= $editing ? 'Update' : 'Add' ?> Business
            </button>
            <?php if ($editing): ?>
              <a href="business.php" class="btn btn-outline-secondary">
                <i class="fas fa-times me-1"></i> Cancel
              </a>
            <?php endif; ?>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="card shadow">
    <div class="card-header bg-white py-3">
      <h5 class="mb-0">Business List</h5>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead class="table-light">
            <tr>
              <th>Name</th>
              <th>Type</th>
              <th>Image</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($businesses as $b): ?>
              <tr>
                <td><?= htmlspecialchars($b['name']) ?></td>
                <td><?= htmlspecialchars($b['type']) ?></td>
                <td>
                  <?php if ($b['image']): ?>
                    <img src="../<?= $b['image'] ?>" class="img-thumbnail" style="max-width: 80px; height: auto;">
                  <?php else: ?>
                    <span class="text-muted">No image</span>
                  <?php endif; ?>
                </td>
                <td>
                  <div class="d-flex gap-2">
                    <a href="?edit=<?= $b['id'] ?>" class="btn btn-sm btn-outline-primary">
                      <i class="fas fa-edit">edit</i>
                    </a>
                    <a href="?delete=<?= $b['id'] ?>" class="btn btn-sm btn-outline-danger" 
                       onclick="return confirm('Are you sure you want to delete this business?')">
                      <i class="fas fa-trash-alt">delete</i>
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>