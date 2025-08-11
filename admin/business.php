<?php
$pageTitle = "Manage Businesses";
require_once 'includes/layout.php';
require_once '../includes/db.php';

function generateSlug($text)
{
  $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
  $slug = strtolower($slug);
  $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
  return trim($slug, '-');
}

// Handle type management
if (isset($_POST['create_type'])) {
  $newType = trim($_POST['new_type']);
  if (!empty($newType)) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM business_types WHERE type_name = ?");
    $stmt->execute([$newType]);
    if ($stmt->fetchColumn() == 0) {
      $pdo->prepare("INSERT INTO business_types (type_name) VALUES (?)")->execute([$newType]);
    }
  }
  header("Location: business.php");
  exit;
}

if (isset($_GET['delete_type']) && is_numeric($_GET['delete_type'])) {
  $pdo->prepare("DELETE FROM business_types WHERE id = ?")->execute([$_GET['delete_type']]);
  header("Location: business.php");
  exit;
}

// Handle business delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
  $pdo->prepare("DELETE FROM businesses WHERE id = ?")->execute([$_GET['delete']]);
  header("Location: business.php");
  exit;
}

$editing = false;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
  $stmt = $pdo->prepare("SELECT * FROM businesses WHERE id = ?");
  $stmt->execute([$_GET['edit']]);
  $biz = $stmt->fetch();
  if ($biz)
    $editing = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
  $name = $_POST['name'];
  $slug = !empty($_POST['slug']) ? generateSlug($_POST['slug']) : generateSlug($name);
  $type = $_POST['type'];
  $description = $_POST['description'];
  $seo_title = $_POST['seo_title'];
  $meta_description = $_POST['meta_description'];
  $address = $_POST['address'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $website = trim($_POST['website']);
  if ($website && !preg_match('/^https?:\/\//i', $website)) {
    $website = 'https://' . $website;
  }


  $image = $biz['image'] ?? '';
  if (!empty($_FILES['image']['name'])) {
    if ($_FILES['image']['size'] > 512000) {
      $error = 'Image must be less than 500KB.';
    } else {
      $image = 'uploads/' . uniqid() . '_' . $_FILES['image']['name'];
      move_uploaded_file($_FILES['image']['tmp_name'], "../$image");
    }
  }

  if (!isset($error)) {
    if ($editing) {
      $pdo->prepare("UPDATE businesses SET name=?, slug=?, type=?, description=?, image=?, seo_title=?, meta_description=?, address=?, phone=?, email=?, website=? WHERE id=?")
        ->execute([$name, $slug, $type, $description, $image, $seo_title, $meta_description, $address, $phone, $email, $website, $biz['id']]);
    } else {
      $pdo->prepare("INSERT INTO businesses (name, slug, type, description, image, seo_title, meta_description, address, phone, email, website)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")
        ->execute([$name, $slug, $type, $description, $image, $seo_title, $meta_description, $address, $phone, $email, $website]);
    }
    header("Location: business.php");
    exit;
  }
}

$businessTypes = $pdo->query("SELECT * FROM business_types ORDER BY type_name")->fetchAll();
$businesses = $pdo->query("SELECT * FROM businesses ORDER BY created_at DESC")->fetchAll();
?>

<div class="container-fluid px-4">
  <h2 class="mb-4"><?= $editing ? 'Edit Business' : 'Add New Business' ?></h2>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data" class="card card-body mb-4">
    <div class="row g-3">
      <div class="col-md-6"><label>Name</label><input name="name" class="form-control" required
          value="<?= htmlspecialchars($biz['name'] ?? '') ?>"></div>
      <div class="col-md-6"><label>Slug</label><input name="slug" class="form-control"
          value="<?= htmlspecialchars($biz['slug'] ?? '') ?>"></div>
      <div class="col-md-6">
        <label>Type</label>
        <select name="type" class="form-select" required>
          <option value="">Select type</option>
          <?php foreach ($businessTypes as $t): ?>
            <option value="<?= $t['type_name'] ?>" <?= (isset($biz['type']) && $biz['type'] == $t['type_name']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($t['type_name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-6"><label>SEO Title</label><input name="seo_title" class="form-control" maxlength="70"
          value="<?= htmlspecialchars($biz['seo_title'] ?? '') ?>"></div>
      <div class="col-12"><label>Description</label><textarea name="description" class="form-control" rows="3"
          required><?= htmlspecialchars($biz['description'] ?? '') ?></textarea></div>
      <div class="col-12"><label>Meta Description</label><textarea name="meta_description" class="form-control"
          maxlength="160" rows="2"><?= htmlspecialchars($biz['meta_description'] ?? '') ?></textarea></div>

      <div class="col-md-6"><label>Address</label><input name="address" class="form-control"
          value="<?= htmlspecialchars($biz['address'] ?? '') ?>"></div>
      <div class="col-md-6"><label>Phone</label><input name="phone" class="form-control"
          value="<?= htmlspecialchars($biz['phone'] ?? '') ?>"></div>
      <div class="col-md-6"><label>Email</label><input type="email" name="email" class="form-control"
          value="<?= htmlspecialchars($biz['email'] ?? '') ?>"></div>
      <div class="col-md-6"><label>Website</label><input type="text" name="website" class="form-control"
          value="<?= htmlspecialchars($biz['website'] ?? '') ?>"></div>

      <div class="col-md-6">
        <label>Image (≤500KB)</label>
        <input type="file" name="image" class="form-control">
        <?php if (!empty($biz['image'])): ?>
          <img src="../<?= $biz['image'] ?>" class="img-thumbnail mt-2" style="max-width:150px;">
        <?php endif; ?>
      </div>
      <div class="col-12">
        <button class="btn btn-primary"><?= $editing ? 'Update' : 'Add' ?> Business</button>
        <?php if ($editing): ?><a href="business.php" class="btn btn-secondary ms-2">Cancel</a><?php endif; ?>
      </div>
    </div>
  </form>

  <!-- Add Business Type -->
  <div class="card mb-4">
    <div class="card-header">Add Business Type</div>
    <div class="card-body">
      <form method="POST" class="row g-3">
        <div class="col-md-6">
          <input type="text" name="new_type" class="form-control" placeholder="New type name" required>
        </div>
        <div class="col-md-2">
          <button type="submit" name="create_type" class="btn btn-success">Add Type</button>
        </div>
      </form>
      <hr>
      <div class="row">
        <?php foreach ($businessTypes as $t): ?>
          <div class="col-md-3 d-flex justify-content-between align-items-center mb-2">
            <?= htmlspecialchars($t['type_name']) ?>
            <a href="?delete_type=<?= $t['id'] ?>" class="text-danger" onclick="return confirm('Delete this type?')">
              <i class="bi bi-trash-fill"></i>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- Business Table -->
  <div class="card">
    <div class="card-header">Business List</div>
    <div class="card-body">
      <table class="table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($businesses as $b): ?>
            <tr>
              <td><?= htmlspecialchars($b['name']) ?></td>
              <td><?= htmlspecialchars($b['type']) ?></td>
              <td>
                <a href="?edit=<?= $b['id'] ?>" class="btn btn-sm btn-info">Edit</a>
                <a href="?delete=<?= $b['id'] ?>" class="btn btn-sm btn-danger"
                  onclick="return confirm('Delete this business?')">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>