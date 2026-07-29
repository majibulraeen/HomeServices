<?php
    include_once "scripts/checklogin.php";
    include_once "include/header.php";
    include_once "scripts/DB.php";

    if (!check("admin")) {
        header('Location: logout.php');
        exit();
    }

    $stmt = DB::query("SELECT * FROM services ORDER BY sort_order ASC, id DESC");
    $services = $stmt->fetchAll(PDO::FETCH_OBJ);

    include_once "msg/admin_services.php";
?>
<div class="container py-5" style="margin-bottom: 60px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="section-title mb-1">Manage Services</h2>
            <p class="section-subtitle mb-0">Manage service cards shown on the landing page</p>
        </div>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addServiceModal">
            <i class="fa fa-plus"></i> Add Service
        </button>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Profession</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($services) === 0): ?>
                        <tr><td colspan="7" class="text-center py-4 text-muted">No services yet. Click "Add Service" to create one.</td></tr>
                        <?php endif; ?>
                        <?php foreach ($services as $s): ?>
                        <tr>
                            <td>
                                <?php $img = 'images/' . $s->image; if (file_exists($img)): ?>
                                <img src="<?= $img ?>" style="width:100px;height:60px;object-fit:cover;border-radius:6px;" alt="">
                                <?php else: ?>
                                <span class="text-muted">No image</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($s->name) ?></td>
                            <td style="max-width:250px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?= htmlspecialchars($s->description ?? '-') ?></td>
                            <td><?= htmlspecialchars($s->profession ?? '-') ?></td>
                            <td><?= $s->sort_order ?></td>
                            <td>
                                <a href="scripts/toggle_service.php?id=<?= $s->id ?>" class="badge badge-pill <?= $s->active ? 'badge-success' : 'badge-secondary' ?>" style="font-size:0.8rem;">
                                    <?= $s->active ? 'Active' : 'Inactive' ?>
                                </a>
                            </td>
                            <td>
                                <a href="scripts/delete_service.php?id=<?= $s->id ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this service?')">
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

<!-- Add Service Modal -->
<div class="modal fade" id="addServiceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="scripts/add_service.php" method="post" enctype="multipart/form-data" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Service</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Service Name *</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Electronic Appliances" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Profession (for link)</label>
                            <input type="text" name="profession" class="form-control" placeholder="e.g. electrician">
                            <small class="text-muted">Maps to provider profession</small>
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
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Service description..."></textarea>
                </div>
                <div class="form-group">
                    <label>Background Image *</label>
                    <div class="custom-file">
                        <input type="file" name="image" class="custom-file-input" accept="image/*" required>
                        <label class="custom-file-label">Choose file...</label>
                    </div>
                    <small class="text-muted">Recommended: 600x400px. jpg, png, gif, webp</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" name="add_service" class="btn btn-success"><i class="fa fa-save"></i> Save Service</button>
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
