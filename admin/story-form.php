<?php
$pageTitle = isset($_GET['id']) ? "Edit Story" : "Add New Story";
require_once 'includes/layout.php';
require_once '../includes/db.php';

$id = $_GET['id'] ?? null;
$editing = false;

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM stories WHERE id = ?");
    $stmt->execute([$id]);
    $story = $stmt->fetch();
    if ($story) $editing = true;
}

$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $category_id = $_POST['category_id'];
    $content = $_POST['content'];
    $is_latest = isset($_POST['is_latest']) ? 1 : 0;
    $is_popular = isset($_POST['is_popular']) ? 1 : 0;
    $is_banner = isset($_POST['is_banner']) ? 1 : 0;

    $user_name = $_POST['user_name'];
    $user_contact = $_POST['user_contact'];
    $user_address = $_POST['user_address'];

    $seo_title = $_POST['seo_title'];
    $meta_description = $_POST['meta_description'];

    function generateSlug($title) {
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $title);
        $slug = strtolower($slug);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        return trim($slug, '-');
    }

    $slug = !empty($_POST['slug']) ? generateSlug($_POST['slug']) : generateSlug($title);


    $thumbnail = $story['thumbnail'] ?? '';
    if (!empty($_FILES['thumbnail']['name'])) {
        $thumbnail = 'uploads/' . uniqid() . '_' . $_FILES['thumbnail']['name'];
        move_uploaded_file($_FILES['thumbnail']['tmp_name'], "../$thumbnail");
    }

    $gallery = [];
    if (!empty($_FILES['gallery']['name'][0])) {
        foreach ($_FILES['gallery']['tmp_name'] as $i => $tmp_name) {
            $filename = 'uploads/' . uniqid() . '_' . $_FILES['gallery']['name'][$i];
            move_uploaded_file($tmp_name, "../$filename");
            $gallery[] = $filename;
        }
    }

    if ($editing) {
        $stmt = $pdo->prepare("UPDATE stories SET title=?, slug=?, category_id=?, thumbnail=?, gallery=?, content=?, is_latest=?, is_popular=?, is_banner=?, user_name=?, user_contact=?, user_address=?, seo_title=?, meta_description=? WHERE id=?");
        $stmt->execute([
            $title, $slug, $category_id, $thumbnail, json_encode($gallery), $content,
            $is_latest, $is_popular, $is_banner,
            $user_name, $user_contact, $user_address,
            $seo_title, $meta_description,
            $id
        ]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO stories (title, slug, category_id, thumbnail, gallery, content, is_latest, is_popular, is_banner, user_name, user_contact, user_address, seo_title, meta_description)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $title, $slug, $category_id, $thumbnail, json_encode($gallery), $content,
            $is_latest, $is_popular, $is_banner,
            $user_name, $user_contact, $user_address,
            $seo_title, $meta_description
        ]);
    }

    header("Location: stories.php");
    exit;
}
?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0"><i class="bi bi-book me-2"></i><?= $editing ? 'Edit' : 'Add New' ?> Story</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="stories.php">Stories</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $editing ? 'Edit' : 'Add' ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <form method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="card-title text-primary mb-4"><i class="bi bi-info-circle me-2"></i>Story Content</h5>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                            
                            <input name="title" class="form-control form-control-lg" required value="<?= htmlspecialchars($story['title'] ?? '') ?>">
                        </div>
                        <div class="mb-4">
    <label class="form-label fw-semibold">Slug <small class="text-muted">(Optional)</small></label>
    <input name="slug" class="form-control" value="<?= htmlspecialchars($story['slug'] ?? '') ?>">
    <small class="text-muted">URL-friendly version (e.g., story-title-here). Leave blank to auto-generate.</small>
</div>


                        <div class="mb-4">
                            <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>" <?= ($story['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Content <span class="text-danger">*</span></label>
                            <textarea name="content" class="form-control" rows="8" id="editor"><?= htmlspecialchars($story['content'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="card-title text-primary mb-4"><i class="bi bi-image me-2"></i>Media</h5>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Thumbnail Image</label>
                            <input type="file" name="thumbnail" class="form-control">
                            <?php if (!empty($story['thumbnail'])): ?>
                                <div class="mt-3">
                                    <img src="../<?= $story['thumbnail'] ?>" class="img-thumbnail" style="max-height:150px;">
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" name="remove_thumbnail" id="remove_thumbnail">
                                        <label class="form-check-label text-danger" for="remove_thumbnail">Remove current thumbnail</label>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Gallery Images</label>
                            <input type="file" name="gallery[]" class="form-control" multiple>
                            <?php if (!empty($story['gallery'])): ?>
                                <div class="row mt-3">
                                    <?php foreach (json_decode($story['gallery']) as $image): ?>
                                        <div class="col-md-3 mb-3">
                                            <img src="../<?= $image ?>" class="img-thumbnail w-100">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="card-title text-primary mb-4"><i class="bi bi-tags me-2"></i>Story Settings</h5>
                        
                        <div class="mb-4">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="is_latest" id="is_latest" <?= ($story['is_latest'] ?? false) ? 'checked' : '' ?>>
                                <label class="form-check-label fw-semibold" for="is_latest">Featured as Latest Story</label>
                            </div>

                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="is_popular" id="is_popular" <?= ($story['is_popular'] ?? false) ? 'checked' : '' ?>>
                                <label class="form-check-label fw-semibold" for="is_popular">Mark as Popular Story</label>
                            </div>

                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_banner" id="is_banner" <?= ($story['is_banner'] ?? false) ? 'checked' : '' ?>>
                                <label class="form-check-label fw-semibold" for="is_banner">Show in Banner Slider</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="card-title text-primary mb-4"><i class="bi bi-person me-2"></i>Author Information</h5>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Author Name <span class="text-danger">*</span></label>
                            <input name="user_name" class="form-control" required value="<?= htmlspecialchars($story['user_name'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Contact Info <span class="text-danger">*</span></label>
                            <input name="user_contact" class="form-control" required value="<?= htmlspecialchars($story['user_contact'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Address</label>
                            <textarea name="user_address" class="form-control" rows="2"><?= htmlspecialchars($story['user_address'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="card-title text-primary mb-4"><i class="bi bi-search me-2"></i>SEO Settings</h5>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">SEO Title</label>
                            <input name="seo_title" class="form-control" maxlength="255" value="<?= htmlspecialchars($story['seo_title'] ?? '') ?>">
                            <small class="text-muted">Recommended: 50-60 characters</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Meta Description</label>
                            <textarea name="meta_description" class="form-control" maxlength="255" rows="3"><?= htmlspecialchars($story['meta_description'] ?? '') ?></textarea>
                            <small class="text-muted">Recommended: 150-160 characters</small>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-save me-2"></i>Save Story
                    </button>
                    <a href="stories.php" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-2"></i>Cancel
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#editor').summernote({
            height: 300,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>

<?php include 'includes/footer.php'; ?>