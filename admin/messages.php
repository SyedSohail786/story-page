<?php
$pageTitle = "Contact Messages";
require_once 'includes/layout.php';
require_once '../includes/db.php';

// Fetch all messages
$messages = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC")->fetchAll();
?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0"><i class="bi bi-envelope me-2"></i>Contact Messages</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Messages</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <?php if (count($messages) === 0): ?>
                <div class="text-center py-5">
                    <i class="bi bi-inbox text-muted fs-1"></i>
                    <h4 class="mt-3">No messages yet</h4>
                    <p class="text-muted">All contact messages will appear here</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="180">Date & Time</th>
                                <th>Contact</th>
                                <th>Subject</th>
                                <th>Preview</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($messages as $msg): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold"><?= date('M j, Y', strtotime($msg['created_at'])) ?></span>
                                            <small class="text-muted"><?= date('h:i A', strtotime($msg['created_at'])) ?></small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold"><?= htmlspecialchars($msg['name']) ?></span>
                                            <small class="text-muted"><?= htmlspecialchars($msg['email']) ?></small>
                                        </div>
                                    </td>
                                    <td><?= htmlspecialchars($msg['subject']) ?></td>
                                    <td>
                                        <small class="text-truncate d-inline-block" style="max-width: 200px;">
                                            <?= nl2br(htmlspecialchars(substr($msg['message'], 0, 60))) ?>...
                                        </small>
                                    </td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-outline-primary rounded-pill px-3" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#messageModal<?= $msg['id'] ?>">
                                            <i class="bi bi-eye me-1"></i> View
                                        </button>
                                    </td>
                                </tr>

                                <!-- Message Modal -->
                                <div class="modal fade" id="messageModal<?= $msg['id'] ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><?= htmlspecialchars($msg['subject']) ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-4">
                                                    <h6>Contact Details</h6>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p class="mb-1"><strong>Name:</strong></p>
                                                            <p><?= htmlspecialchars($msg['name']) ?></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="mb-1"><strong>Email:</strong></p>
                                                            <p><?= htmlspecialchars($msg['email']) ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-12">
                                                            <p class="mb-1"><strong>Date:</strong></p>
                                                            <p><?= date('F j, Y \a\t h:i A', strtotime($msg['created_at'])) ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h6>Message</h6>
                                                    <div class="bg-light p-3 rounded">
                                                        <?= nl2br(htmlspecialchars($msg['message'])) ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <a href="mailto:<?= htmlspecialchars($msg['email']) ?>" class="btn btn-primary">
                                                    <i class="bi bi-reply me-1"></i> Reply
                                                </a>
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