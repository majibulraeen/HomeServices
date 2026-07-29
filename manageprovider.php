<?php
    include_once "scripts/checklogin.php";
    include_once "include/header.php";
    include_once "scripts/DB.php";

    if (!check("admin")) {
        header('Location: logout.php');
        exit();
    }

    $stmt = DB::query("SELECT * FROM providers ORDER BY verified ASC, id DESC");
    $providers = $stmt->fetchAll(PDO::FETCH_OBJ);

    include_once "msg/managehall.php";
?>
<div class="container py-5" style="margin-bottom: 60px;">
    <div class="text-center mb-4">
        <h2 class="section-title">Manage Providers</h2>
        <p class="section-subtitle">Verify provider licenses and manage all registered service providers</p>
    </div>

    <?php
        $pending = array_filter($providers, function($p) { return $p->verified == 0; });
        $pendingCount = count($pending);
    ?>
    <?php if ($pendingCount > 0): ?>
    <div class="alert alert-warning">
        <i class="fa fa-exclamation-triangle"></i> <strong><?= $pendingCount ?> provider(s)</strong> pending verification.
        Review their license documents below.
    </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th>Profession</th>
                            <th>Status</th>
                            <th>Commission</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($providers) === 0): ?>
                        <tr><td colspan="9" class="text-center text-muted py-4">No providers registered yet.</td></tr>
                        <?php endif; ?>
                        <?php foreach ($providers as $provider): ?>
                        <tr class="<?= $provider->verified == 0 ? 'table-warning' : '' ?>">
                            <td>
                                <img style="height: 60px; width: 60px; border-radius: 8px; object-fit: cover;"
                                    src="images/<?= $provider->photo; ?>" alt="photo">
                            </td>
                            <td><strong>#<?= $provider->id; ?></strong></td>
                            <td><?= $provider->name; ?>
                                <?php if (!empty($provider->license_doc)): ?>
                                <a href="images/<?= $provider->license_doc ?>" target="_blank" class="text-primary" title="View License">
                                    <i class="fa fa-file"></i>
                                </a>
                                <?php endif; ?>
                            </td>
                            <td><?= $provider->contact; ?></td>
                            <td><?= $provider->adder; ?>,<br><?= $provider->city; ?></td>
                            <td><span class="badge badge-primary"><?= $provider->profession; ?></span></td>
                            <td>
                                <?php if ($provider->verified == 1): ?>
                                    <span class="badge badge-success">Verified</span>
                                <?php else: ?>
                                    <span class="badge badge-warning">Pending</span>
                                <?php endif; ?>
                                <?php if ($provider->is_online == 1): ?>
                                    <br><small class="text-success"><i class="fa fa-circle"></i> Online</small>
                                <?php endif; ?>
                            </td>
                            <td><?= $provider->commission_rate ?? 5 ?>%</td>
                            <td>
                                <form action="editprovider.php" method="post" class="mb-1">
                                    <input type="hidden" name="id" value="<?= $provider->id ;?>">
                                    <button type="submit" name="editprovider" class="btn btn-info btn-sm btn-block">View</button>
                                </form>
                                <?php if ($provider->verified == 0): ?>
                                <a href="scripts/verify_provider.php?id=<?= $provider->id ?>&action=verify"
                                    class="btn btn-success btn-sm btn-block">Verify</a>
                                <?php else: ?>
                                <a href="scripts/verify_provider.php?id=<?= $provider->id ?>&action=unverify"
                                    class="btn btn-warning btn-sm btn-block">Revoke</a>
                                <?php endif; ?>
                                <form action="deleteprovider.php" method="post">
                                    <input type="hidden" name="id" value="<?= $provider->id ;?>">
                                    <button type="submit" name="remove" class="btn btn-danger btn-sm btn-block mt-1">Remove</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once "include/footer.php"; ?>
