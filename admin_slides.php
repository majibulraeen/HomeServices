<?php
    include_once "scripts/checklogin.php";
    include_once "include/header.php";
    include_once "scripts/DB.php";

    if (!check("admin")) {
        header('Location: logout.php');
        exit();
    }

    $stmt = DB::query("SELECT * FROM slides ORDER BY sort_order ASC, id DESC");
    $slides = $stmt->fetchAll(PDO::FETCH_OBJ);

    include_once "msg/admin_slides.php";
?>
<div class="container py-5" style="margin-bottom: 60px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="section-title mb-1">Manage Slides</h2>
            <p class="section-subtitle mb-0">Manage landing page carousel slides</p>
        </div>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addSlideModal">
            <i class="fa fa-plus"></i> Add Slide
        </button>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Subtitle</th>
                            <th>Link</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($slides) === 0): ?>
                        <tr><td colspan="7" class="text-center py-4 text-muted">No slides yet. Click "Add Slide" to create one.</td></tr>
                        <?php endif; ?>
                        <?php foreach ($slides as $s): ?>
                        <tr>
                            <td>
                                <?php $img = 'images/' . $s->image; if (file_exists($img)): ?>
                                <img src="<?= $img ?>" style="width:120px;height:70px;object-fit:cover;border-radius:6px;" alt="">
                                <?php else: ?>
                                <span class="text-muted">No image</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($s->title ?? '-') ?></td>
                            <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?= htmlspecialchars($s->subtitle ?? '-') ?></td>
                            <td><?= htmlspecialchars($s->link ?? '-') ?></td>
                            <td><?= $s->sort_order ?></td>
                            <td>
                                <a href="scripts/toggle_slide.php?id=<?= $s->id ?>" class="badge badge-pill <?= $s->active ? 'badge-success' : 'badge-secondary' ?>" style="font-size:0.8rem;">
                                    <?= $s->active ? 'Active' : 'Inactive' ?>
                                </a>
                            </td>
                            <td>
                                <a href="scripts/delete_slide.php?id=<?= $s->id ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this slide?')">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Slide Modal -->
<div class="modal fade" id="addSlideModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="scripts/add_slide.php" method="post" enctype="multipart/form-data" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Slide</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Slide heading">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Link (optional)</label>
                            <input type="text" name="link" class="form-control" placeholder="e.g. home.php">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="0">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Subtitle</label>
                    <textarea name="subtitle" class="form-control" rows="2" placeholder="Slide description"></textarea>
                </div>
                <div class="form-group">
                    <label>Image *</label>
                    <div class="custom-file">
                        <input type="file" name="image" class="custom-file-input" accept="image/*" required>
                        <label class="custom-file-label">Choose file...</label>
                    </div>
                    <small class="text-muted">Recommended: 1920x800px. jpg, png, gif, webp</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" name="add_slide" class="btn btn-success"><i class="fa fa-save"></i> Save Slide</button>
            </div>
        </form>
    </div>
</div>

<script>
$('.custom-file-input').on('change', function() {
    $(this).next('.custom-file-label').text($(this)[0].files[0].name);
});
</script>

<?php include_once "include/footer.php"; ?>
