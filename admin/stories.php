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

<h2 class="mb-4"><i class="bi bi-book me-2"></i>Manage Stories</h2>
<a href="story-form.php" class="btn btn-success mb-3">
    <i class="bi bi-plus-circle me-1"></i> Add New Story
</a>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="py-3 px-4">Title</th>
                        <th class="py-3 px-4">Category</th>
                        <th class="py-3 px-4 text-center">Latest</th>
                        <th class="py-3 px-4 text-center">Popular</th>
                        <th class="py-3 px-4 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stories as $s): ?>
                        <tr>
                            <td class="py-3 px-4 align-middle fw-semibold">
                                <?= htmlspecialchars($s['title']) ?>
                            </td>
                            <td class="py-3 px-4 align-middle">
                                <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                    <?= htmlspecialchars($s['category'] ?? 'Uncategorized') ?>
                                </span>
                            </td>
                            <td class="py-3 px-4 align-middle text-center">
                                <span class="badge bg-<?= $s['is_latest'] ? 'success' : 'secondary' ?> bg-opacity-10 text-<?= $s['is_latest'] ? 'success' : 'secondary' ?>">
                                    <?= $s['is_latest'] ? 'Yes' : 'No' ?>
                                </span>
                            </td>
                            <td class="py-3 px-4 align-middle text-center">
                                <span class="badge bg-<?= $s['is_popular'] ? 'warning' : 'secondary' ?> bg-opacity-10 text-<?= $s['is_popular'] ? 'warning' : 'secondary' ?>">
                                    <?= $s['is_popular'] ? 'Yes' : 'No' ?>
                                </span>
                            </td>
                            <td class="py-3 px-4 align-middle text-end">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="story-form.php?id=<?= $s['id'] ?>" class="btn btn-sm btn-primary rounded-pill px-3">
                                        <i class="bi bi-pencil me-1"></i> Edit
                                    </a>
                                    <a href="delete.php?type=story&id=<?= $s['id'] ?>" class="btn btn-sm btn-danger rounded-pill px-3" onclick="return confirm('Are you sure you want to delete this story?')">
                                        <i class="bi bi-trash me-1"></i> Delete
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

<?php include 'includes/footer.php'; ?>