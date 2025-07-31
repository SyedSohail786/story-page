<?php
$pageTitle = "User Story Submissions";
require_once 'includes/layout.php';
require_once '../includes/db.php';

// Mark as reviewed if requested
if (isset($_GET['review']) && is_numeric($_GET['review'])) {
    $stmt = $pdo->prepare("UPDATE submissions SET status = 'reviewed' WHERE id = ?");
    $stmt->execute([$_GET['review']]);
    header("Location: submissions.php");
    exit;
}

// Get all submissions
$submissions = $pdo->query("SELECT * FROM submissions ORDER BY submitted_at DESC")->fetchAll();
?>

<h2 class="mb-4">User Story Submissions</h2>

<?php if (count($submissions) === 0): ?>
  <p>No story submissions yet.</p>
<?php else: ?>
  <div class="table-responsive">
    <table class="table table-bordered">
      <thead class="table-light">
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Title</th>
          <th>Story</th>
          <th>Status</th>
          <th>Submitted At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($submissions as $sub): ?>
          <tr>
            <td><?= htmlspecialchars($sub['name']) ?></td>
            <td><?= htmlspecialchars($sub['email']) ?></td>
            <td><?= htmlspecialchars($sub['phone']) ?></td>
            <td><?= htmlspecialchars($sub['title']) ?></td>
            <td><?= nl2br(htmlspecialchars(substr($sub['story'], 0, 100))) ?>...</td>
            <td><?= ucfirst($sub['status']) ?></td>
            <td><?= date('Y-m-d H:i', strtotime($sub['submitted_at'])) ?></td>
            <td>
              <?php if ($sub['status'] === 'pending'): ?>
                <a href="?review=<?= $sub['id'] ?>" class="btn btn-sm btn-success">Mark Reviewed</a>
              <?php else: ?>
                <span class="text-muted">Reviewed</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
