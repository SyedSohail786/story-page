<?php
$pageTitle = "Contact Messages";
require_once 'includes/layout.php';
require_once '../includes/db.php';

// Fetch all messages
$messages = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC")->fetchAll();
?>

<h2 class="mb-4">Contact Messages</h2>

<?php if (count($messages) === 0): ?>
  <p>No messages received yet.</p>
<?php else: ?>
  <div class="table-responsive">
    <table class="table table-bordered">
      <thead class="table-light">
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Subject</th>
          <th>Message</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($messages as $msg): ?>
          <tr>
            <td><?= htmlspecialchars($msg['name']) ?></td>
            <td><?= htmlspecialchars($msg['email']) ?></td>
            <td><?= htmlspecialchars($msg['subject']) ?></td>
            <td><?= nl2br(htmlspecialchars($msg['message'])) ?></td>
            <td><?= isset($msg['created_at']) ? date('Y-m-d H:i', strtotime($msg['created_at'])) : '-' ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
