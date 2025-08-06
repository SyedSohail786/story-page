<?php
$pageTitle = "Manage Events";
require_once 'includes/layout.php';
require_once '../includes/db.php';

// Handle delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
  $pdo->prepare("DELETE FROM events WHERE id = ?")->execute([$_GET['delete']]);
  header("Location: event.php");
  exit;
}

// Handle edit load
$editing = false;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
  $stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
  $stmt->execute([$_GET['edit']]);
  $event = $stmt->fetch();
  if ($event) $editing = true;
}

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $description = $_POST['description'];
  $location = $_POST['location'];
  $event_datetime = $_POST['event_datetime'];

  $image = $event['image'] ?? '';
  if (!empty($_FILES['image']['name'])) {
    $image = 'uploads/' . uniqid() . '_' . $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "../$image");
  }

  if ($editing) {
    $pdo->prepare("UPDATE events SET name=?, description=?, location=?, event_datetime=?, image=? WHERE id=?")
        ->execute([$name, $description, $location, $event_datetime, $image, $event['id']]);
  } else {
    $pdo->prepare("INSERT INTO events (name, description, location, event_datetime, image) VALUES (?, ?, ?, ?, ?)")
        ->execute([$name, $description, $location, $event_datetime, $image]);
  }

  header("Location: event.php");
  exit;
}

$events = $pdo->query("SELECT * FROM events ORDER BY event_datetime DESC")->fetchAll();
?>

<div class="container-fluid px-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Manage Events</h2>
    <?php if ($editing): ?>
      <a href="event.php" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to list
      </a>
    <?php endif; ?>
  </div>

  <div class="card shadow mb-4">
    <div class="card-header bg-white py-3">
      <h5 class="mb-0"><?= $editing ? 'Edit Event' : 'Create New Event' ?></h5>
    </div>
    <div class="card-body">
      <form method="POST" enctype="multipart/form-data">
        <div class="row g-3">
          <div class="col-md-6">
            <label for="name" class="form-label">Event Name</label>
            <input type="text" class="form-control" id="name" name="name" required 
                   value="<?= htmlspecialchars($event['name'] ?? '') ?>">
          </div>
          <div class="col-md-6">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" required 
                   value="<?= htmlspecialchars($event['location'] ?? '') ?>">
          </div>
          <div class="col-md-6">
            <label for="event_datetime" class="form-label">Date & Time</label>
            <input type="datetime-local" class="form-control" id="event_datetime" name="event_datetime" required
                   value="<?= isset($event['event_datetime']) ? str_replace(' ', 'T', $event['event_datetime']) : '' ?>">
          </div>
          <div class="col-md-6">
            <label for="image" class="form-label">Event Image</label>
            <input type="file" class="form-control" id="image" name="image">
            <?php if (!empty($event['image'])): ?>
              <div class="mt-3 d-flex align-items-center">
                <img src="../<?= $event['image'] ?>" class="img-thumbnail me-3" style="max-width:150px;">
                <a href="../<?= $event['image'] ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                  <i class="bi bi-eye me-1"></i> View Full Image
                </a>
              </div>
            <?php endif; ?>
          </div>
          <div class="col-12">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required><?= 
              htmlspecialchars($event['description'] ?? '') ?></textarea>
          </div>
          <div class="col-12">
            <button type="submit" class="btn btn-primary me-2">
              <i class="bi bi-save me-1"></i> <?= $editing ? 'Update' : 'Create' ?> Event
            </button>
            <?php if ($editing): ?>
              <a href="event.php" class="btn btn-outline-secondary">
                <i class="bi bi-x-circle me-1"></i> Cancel
              </a>
            <?php endif; ?>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="card shadow">
    <div class="card-header bg-white py-3">
      <h5 class="mb-0">Upcoming Events</h5>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead class="table-light">
            <tr>
              <th>Event</th>
              <th>Location</th>
              <th>Date/Time</th>
              <th>Image</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($events as $e): ?>
              <tr>
                <td>
                  <strong><?= htmlspecialchars($e['name']) ?></strong>
                  <?php if (!empty($e['description'])): ?>
                    <p class="text-muted small mb-0"><?= substr(htmlspecialchars($e['description']), 0, 50) ?>...</p>
                  <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($e['location']) ?></td>
                <td>
                  <?= date('M j, Y', strtotime($e['event_datetime'])) ?><br>
                  <small class="text-muted"><?= date('g:i A', strtotime($e['event_datetime'])) ?></small>
                </td>
                <td>
                  <?php if ($e['image']): ?>
                    <img src="../<?= $e['image'] ?>" class="img-thumbnail" style="max-width: 80px; height: auto;">
                  <?php else: ?>
                    <span class="text-muted">No image</span>
                  <?php endif; ?>
                </td>
                <td>
                  <div class="d-flex gap-2">
                    <a href="?edit=<?= $e['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <a href="?delete=<?= $e['id'] ?>" class="btn btn-sm btn-outline-danger" 
                       onclick="return confirm('Are you sure you want to delete this event?')" title="Delete">
                      <i class="bi bi-trash"></i>
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