<?php
    include_once "scripts/checklogin.php";
    include_once "include/header.php";
    include_once "scripts/DB.php";

    if (!check()) {
        header('Location: logout.php');
        exit();
    }

    $user = $_SESSION['user'];
    $id = $user->id;
    $name = $user->name;

    $stmt = DB::query("SELECT * FROM bookings WHERE provider_id=? ORDER BY id DESC", [$id]);
    $bookings = $stmt->fetchAll(PDO::FETCH_OBJ);

    $totalEarnings = 0;
    $completedCount = 0;
    $pendingCount = 0;
    $cancelledCount = 0;
    foreach ($bookings as $b) {
        if ($b->status == 3) {
            $commission = ($user->commission_rate ?? 5) / 100 * $b->amount;
            $totalEarnings += $b->amount - $commission;
            $completedCount++;
        } elseif ($b->status == 4) {
            $cancelledCount++;
        } else {
            $pendingCount++;
        }
    }

    include_once "msg/viewrequest.php";
?>
<div class="container py-5" style="margin-bottom: 60px;">
    <div class="text-center mb-4">
        <h2 class="section-title">My Dashboard</h2>
        <p class="section-subtitle">Welcome back, <?= htmlspecialchars($name) ?></p>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center py-3">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Total Bookings</h6>
                    <h3 class="font-weight-bold mb-0"><?= count($bookings) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center py-3">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Completed</h6>
                    <h3 class="font-weight-bold text-success mb-0"><?= $completedCount ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center py-3">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Pending / Active</h6>
                    <h3 class="font-weight-bold text-warning mb-0"><?= $pendingCount ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center py-3">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Earnings (after <?= $user->commission_rate ?? 5 ?>% commission)</h6>
                    <h3 class="font-weight-bold text-primary mb-0">Rs. <?= number_format($totalEarnings, 2) ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header font-weight-bold">
            <i class="fa fa-list"></i> Booking Requests
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Contact</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($bookings) === 0): ?>
                        <tr><td colspan="8" class="text-center text-muted py-4">No booking requests yet.</td></tr>
                        <?php endif; ?>
                        <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><strong>#<?= $booking->id; ?></strong></td>
                            <td><?= htmlspecialchars($booking->name); ?></td>
                            <td><?= htmlspecialchars($booking->contact); ?></td>
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
                                    <?php if ($booking->rating): ?>
                                        <br><small class="text-warning"><?= str_repeat('&#9733;', $booking->rating) . str_repeat('&#9734;', 5 - $booking->rating) ?></small>
                                    <?php endif; ?>
                                <?php elseif ($booking->status == 4): ?>
                                    <span class="badge badge-danger">Cancelled</span>
                                    <?php if ($booking->cancellation_reason): ?>
                                        <br><small class="text-muted"><?= htmlspecialchars($booking->cancellation_reason) ?></small>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                            <td style="min-width: 110px;">
                                <?php if ($booking->status == 0): ?>
                                <a class="btn btn-success btn-sm btn-block" href="approvebooking.php?id=<?= $booking->id; ?>">Approve</a>
                                <?php elseif ($booking->status == 1): ?>
                                <a class="btn btn-primary btn-sm btn-block" href="scripts/start_booking.php?id=<?= $booking->id; ?>">Start Work</a>
                                <?php elseif ($booking->status == 2): ?>
                                <a class="btn btn-success btn-sm btn-block" href="scripts/complete_booking.php?id=<?= $booking->id; ?>">Complete</a>
                                <?php endif; ?>
                                <?php if ($booking->status == 0 || $booking->status == 1): ?>
                                <a class="btn btn-danger btn-sm btn-block mt-1" href="javascript:void(0)" onclick="cancelBooking(<?= $booking->id ?>)">Cancel</a>
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

<script>
function cancelBooking(id) {
    var reason = prompt('Reason for cancellation:');
    if (reason !== null) {
        window.location.href = 'scripts/cancel_booking.php?id=' + id + '&reason=' + encodeURIComponent(reason);
    }
}
</script>

<?php include_once "./include/footer.php"; ?>
