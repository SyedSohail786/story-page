<?php
$pageTitle = "Manage Events";
require_once 'includes/layout.php';
require_once '../includes/db.php';

function generateSlug($text) {
    $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
    $slug = strtolower($slug);
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    return trim($slug, '-');
}

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $pdo->prepare("DELETE FROM events WHERE id = ?")->execute([$_GET['delete']]);
    header("Location: event.php"); exit;
}

$editing = false;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $event = $stmt->fetch();
    if ($event) $editing = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $slug = !empty($_POST['slug']) ? generateSlug($_POST['slug']) : generateSlug($name);
    $description = $_POST['description'];
    $location = $_POST['location'];
    $event_datetime = $_POST['event_datetime'];
    $seo_title = $_POST['seo_title'];
    $meta_description = $_POST['meta_description'];

    $image = $event['image'] ?? '';
    if (!empty($_FILES['image']['name']) && $_FILES['image']['size'] <= 512000) {
        $image = 'uploads/' . uniqid() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../$image");
    }

    if ($editing) {
        $pdo->prepare("UPDATE events SET name=?, slug=?, description=?, location=?, event_datetime=?, image=?, seo_title=?, meta_description=? WHERE id=?")
            ->execute([$name, $slug, $description, $location, $event_datetime, $image, $seo_title, $meta_description, $event['id']]);
    } else {
        $pdo->prepare("INSERT INTO events (name, slug, description, location, event_datetime, image, seo_title, meta_description)
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?)")
            ->execute([$name, $slug, $description, $location, $event_datetime, $image, $seo_title, $meta_description]);
    }

    header("Location: event.php"); exit;
}

$events = $pdo->query("SELECT * FROM events ORDER BY event_datetime DESC")->fetchAll();
?>

<div class="container-fluid px-4">
  <h2 class="mb-4"><?= $editing ? 'Edit Event' : 'Create New Event' ?></h2>
  <form method="POST" enctype="multipart/form-data" class="card card-body mb-4">
    <div class="row g-3">
      <div class="col-md-6"><label>Name</label><input name="name" class="form-control" required value="<?= htmlspecialchars($event['name'] ?? '') ?>"></div>
      <div class="col-md-6"><label>Slug</label><input name="slug" class="form-control" value="<?= htmlspecialchars($event['slug'] ?? '') ?>"></div>
      <div class="col-md-6"><label>Date & Time</label><input type="datetime-local" name="event_datetime" class="form-control" required value="<?= isset($event['event_datetime']) ? str_replace(' ', 'T', $event['event_datetime']) : '' ?>"></div>
      <div class="col-md-6"><label>Location</label><input name="location" class="form-control" required value="<?= htmlspecialchars($event['location'] ?? '') ?>"></div>
      <div class="col-12"><label>Description</label><textarea name="description" class="form-control" rows="3" required><?= htmlspecialchars($event['description'] ?? '') ?></textarea></div>
      <div class="col-md-6"><label>SEO Title</label><input name="seo_title" class="form-control" maxlength="70" value="<?= htmlspecialchars($event['seo_title'] ?? '') ?>"></div>
      <div class="col-md-6"><label>Meta Description</label><textarea name="meta_description" class="form-control" maxlength="160" rows="2"><?= htmlspecialchars($event['meta_description'] ?? '') ?></textarea></div>
      <div class="col-md-6">
        <label>Image (≤500 KB)</label>
        <input type="file" name="image" class="form-control">
        <?php if (!empty($event['image'])): ?>
          <img src="../<?= $event['image'] ?>" class="img-thumbnail mt-2" style="max-width:150px;">
        <?php endif; ?>
      </div>
      <div class="col-12">
        <button class="btn btn-primary"><?= $editing ? 'Update' : 'Create' ?> Event</button>
        <?php if ($editing): ?><a href="event.php" class="btn btn-secondary ms-2">Cancel</a><?php endif; ?>
      </div>
    </div>
  </form>

  <div class="card">
    <div class="card-header">Existing Events</div>
    <div class="card-body">
      <table class="table">
        <thead><tr><th>Name</th><th>Date</th><th>Location</th><th>Actions</th></tr></thead>
        <tbody>
          <?php foreach ($events as $e): ?>
            <tr>
              <td><?= htmlspecialchars($e['name']) ?></td>
              <td><?= date('M j, Y g:i A', strtotime($e['event_datetime'])) ?></td>
              <td><?= htmlspecialchars($e['location']) ?></td>
              <td>
                <a href="?edit=<?= $e['id'] ?>" class="btn btn-sm btn-info">Edit</a>
                <a href="?delete=<?= $e['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this event?')">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
