<?php
    include_once "scripts/checklogin.php";
    include_once "include/header.php";
    include_once "scripts/DB.php";

    if (!check("admin")) {
        header('Location: logout.php');
        exit();
    }
    $id = intval($_GET['id']);
    $stmt = DB::query("SELECT * FROM bookings WHERE provider_id=?", [$id]);
    $bookings = $stmt->fetchAll(PDO::FETCH_OBJ);
?>
<div class="container py-5" style="margin-bottom: 60px;">
    <div class="text-center mb-4">
        <h2 class="section-title">Provider Bookings</h2>
        <p class="section-subtitle">Viewing bookings for provider #<?= $id ?></p>
    </div>
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Payment</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($bookings) === 0): ?>
                        <tr><td colspan="8" class="text-center text-muted py-4">No bookings for this provider.</td></tr>
                        <?php endif; ?>
                        <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><strong>#<?= $booking->id; ?></strong></td>
                            <td><?= htmlspecialchars($booking->name); ?></td>
                            <td><?= htmlspecialchars($booking->contact); ?></td>
                            <td><?= htmlspecialchars($booking->adder); ?></td>
                            <td><strong>Rs. <?= number_format($booking->amount, 2); ?></strong></td>
                            <td><?= $booking->date; ?></td>
                            <td><span class="badge badge-primary"><?= htmlspecialchars($booking->payment); ?></span></td>
                            <td>
                                <?php if ($booking->status == 0): ?>
                                    <span class="badge badge-warning">Pending</span>
                                <?php elseif ($booking->status == 1): ?>
                                    <span class="badge badge-info">Approved</span>
                                <?php elseif ($booking->status == 2): ?>
                                    <span class="badge badge-primary">In Progress</span>
                                <?php elseif ($booking->status == 3): ?>
                                    <span class="badge badge-success">Completed</span>
                                <?php elseif ($booking->status == 4): ?>
                                    <span class="badge badge-danger">Cancelled</span>
                                <?php endif; ?>
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
