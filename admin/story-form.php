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
    function generateSlug($title) {
    $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $title); // Convert accents to ASCII
    $slug = strtolower($slug);                         // Lowercase
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);  // Replace non-alphanum with -
    return trim($slug, '-');                           // Trim hyphens
}

$slug = generateSlug($title);

    $category_id = $_POST['category_id'];
    $content = $_POST['content'];
    $is_latest = isset($_POST['is_latest']) ? 1 : 0;
    $is_popular = isset($_POST['is_popular']) ? 1 : 0;
    $is_banner = isset($_POST['is_banner']) ? 1 : 0;

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
        $stmt = $pdo->prepare("UPDATE stories SET title=?, slug=?, category_id=?, thumbnail=?, gallery=?, content=?, is_latest=?, is_popular=?, is_banner=? WHERE id=?");
        $stmt->execute([$title, $slug, $category_id, $thumbnail, json_encode($gallery), $content, $is_latest, $is_popular, $is_banner, $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO stories (title, slug, category_id, thumbnail, gallery, content, is_latest, is_popular, is_banner) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $slug, $category_id, $thumbnail, json_encode($gallery), $content, $is_latest, $is_popular, $is_banner]);
    }

    header("Location: stories.php");
    exit;
}
?>

<h2 class="mb-4"><?= $editing ? 'Edit' : 'Add New' ?> Story</h2>

<form method="POST" enctype="multipart/form-data" class="col-lg-8">
  <div class="mb-3">
    <label class="form-label">Title</label>
    <input name="title" class="form-control" required value="<?= htmlspecialchars($story['title'] ?? '') ?>">
  </div>

  <div class="mb-3">
    <label class="form-label">Category</label>
    <select name="category_id" class="form-select" required>
      <?php foreach ($categories as $cat): ?>
        <option value="<?= $cat['id'] ?>" <?= ($story['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($cat['name']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label">Thumbnail</label>
    <input type="file" name="thumbnail" class="form-control">
    <?php if (!empty($story['thumbnail'])): ?>
      <img src="../<?= $story['thumbnail'] ?>" class="mt-2" style="max-height:100px;">
    <?php endif; ?>
  </div>

  <div class="mb-3">
    <label class="form-label">Gallery (Multiple Images)</label>
    <input type="file" name="gallery[]" class="form-control" multiple>
  </div>

  <div class="mb-3">
    <label class="form-label">Content</label>
    <textarea name="content" class="form-control" rows="6"><?= htmlspecialchars($story['content'] ?? '') ?></textarea>
  </div>

  <div class="form-check mb-2">
    <input class="form-check-input" type="checkbox" name="is_latest" <?= ($story['is_latest'] ?? false) ? 'checked' : '' ?>>
    <label class="form-check-label">Mark as Latest</label>
  </div>

  <div class="form-check mb-2">
    <input class="form-check-input" type="checkbox" name="is_popular" <?= ($story['is_popular'] ?? false) ? 'checked' : '' ?>>
    <label class="form-check-label">Mark as Popular</label>
  </div>

  <div class="form-check mb-4">
    <input class="form-check-input" type="checkbox" name="is_banner" <?= ($story['is_banner'] ?? false) ? 'checked' : '' ?>>
    <label class="form-check-label">Show in Banner Slider</label>
  </div>

  <button class="btn btn-primary">Save Story</button>
</form>

<?php include 'includes/footer.php'; ?>
