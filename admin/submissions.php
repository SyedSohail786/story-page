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

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0"><i class="bi bi-collection me-2"></i>User Story Submissions</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Submissions</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <?php if (count($submissions) === 0): ?>
                <div class="text-center py-5">
                    <i class="bi bi-check-circle-fill text-success fs-1"></i>
                    <h4 class="mt-3">No pending submissions</h4>
                    <p class="text-muted">All user stories have been reviewed</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Submitted</th>
                                <th>User</th>
                                <th>Contact</th>
                                <th>Story</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($submissions as $sub): ?>
                                <tr>
                                    <td width="150">
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold"><?= date('M j, Y', strtotime($sub['submitted_at'])) ?></span>
                                            <small class="text-muted"><?= date('h:i A', strtotime($sub['submitted_at'])) ?></small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold"><?= htmlspecialchars($sub['name']) ?></span>
                                            <small class="text-muted"><?= htmlspecialchars($sub['email']) ?></small>
                                        </div>
                                    </td>
                                    <td>
                                        <?= !empty($sub['phone']) ? htmlspecialchars($sub['phone']) : '<span class="text-muted">N/A</span>' ?>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold"><?= htmlspecialchars($sub['title']) ?></span>
                                            <small class="text-muted"><?= nl2br(htmlspecialchars(substr($sub['story'], 0, 100))) ?>...</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= $sub['status'] === 'pending' ? 'warning' : 'success' ?> bg-opacity-10 text-<?= $sub['status'] === 'pending' ? 'warning' : 'success' ?> rounded-pill px-3 py-1">
                                            <?= ucfirst($sub['status']) ?>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex gap-2 justify-content-end">
                                            <?php if ($sub['status'] === 'pending'): ?>
                                                <a href="?review=<?= $sub['id'] ?>" class="btn btn-sm btn-success rounded-pill px-3">
                                                    <i class="bi bi-check-circle me-1"></i> Review
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted small">Reviewed</span>
                                            <?php endif; ?>
                                            <button class="btn btn-sm btn-outline-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#storyModal<?= $sub['id'] ?>">
                                                <i class="bi bi-eye me-1"></i> View
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Story Modal -->
                                <div class="modal fade" id="storyModal<?= $sub['id'] ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><?= htmlspecialchars($sub['title']) ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-4">
                                                    <h6>User Details</h6>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <p class="mb-1"><strong>Name:</strong></p>
                                                            <p><?= htmlspecialchars($sub['name']) ?></p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <p class="mb-1"><strong>Email:</strong></p>
                                                            <p><?= htmlspecialchars($sub['email']) ?></p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <p class="mb-1"><strong>Phone:</strong></p>
                                                            <p><?= !empty($sub['phone']) ? htmlspecialchars($sub['phone']) : 'N/A' ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h6>Story Content</h6>
                                                    <div class="bg-light p-3 rounded">
                                                        <?= nl2br(htmlspecialchars($sub['story'])) ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <?php if ($sub['status'] === 'pending'): ?>
                                                    <a href="?review=<?= $sub['id'] ?>" class="btn btn-success">
                                                        <i class="bi bi-check-circle me-1"></i> Mark as Reviewed
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>