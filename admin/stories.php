<?php
$pageTitle = "Manage Stories";
require_once 'includes/layout.php';
require_once '../includes/db.php';

// Fetch stories with category names
$stories = $pdo->query("
    SELECT s.*, c.name AS category 
    FROM stories s
    LEFT JOIN categories c ON s.category_id = c.id
    ORDER BY s.created_at DESC
")->fetchAll();
?>

<h2 class="mb-4">Manage Stories</h2>
<a href="story-form.php" class="btn btn-success mb-3">+ Add New Story</a>

<div class="table-responsive">
  <table class="table table-bordered">
    <thead class="table-light">
      <tr>
        <th>Title</th>
        <th>Category</th>
        <th>Latest</th>
        <th>Popular</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($stories as $s): ?>
        <tr>
          <td><?= htmlspecialchars($s['title']) ?></td>
          <td><?= htmlspecialchars($s['category'] ?? 'Uncategorized') ?></td>
          <td><?= $s['is_latest'] ? 'Yes' : 'No' ?></td>
          <td><?= $s['is_popular'] ? 'Yes' : 'No' ?></td>
          <td>
            <a href="story-form.php?id=<?= $s['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
            <a href="delete.php?type=story&id=<?= $s['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this story?')">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include 'includes/footer.php'; ?>
