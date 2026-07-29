<?php
    include_once "scripts/checklogin.php";
    include_once "scripts/DB.php";
    include_once "include/header.php";

    if (!check("admin")) {
        header('Location: logout.php');
        exit();
    }

    $sql = "SELECT b.*, p.name AS provider_name, p.commission_rate 
            FROM bookings AS b, providers AS p 
            WHERE b.provider_id = p.id 
            ORDER BY b.date DESC";
    $bookings = DB::query($sql)->fetchAll(PDO::FETCH_OBJ);

    include_once "msg/admin.php";
?>
<div class="container py-5" style="margin-bottom: 60px;">
    <div class="text-center mb-4">
        <h2 class="section-title">Admin Dashboard</h2>
        <p class="section-subtitle">Platform overview and commission tracking</p>
    </div>

    <?php
        $totalCommission = 0;
        $completedBookings = 0;
        $totalRevenue = 0;
        foreach ($bookings as $b) {
            $rate = $b->commission_rate ?? 5;
            $commission = $rate / 100 * $b->amount;
            $totalCommission += $commission;
            $totalRevenue += $b->amount;
            if ($b->status == 3) $completedBookings++;
        }
    ?>
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
                    <h3 class="font-weight-bold text-success mb-0"><?= $completedBookings ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center py-3">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Active Providers</h6>
                    <h3 class="font-weight-bold mb-0">
                        <?= DB::query("SELECT COUNT(*) FROM providers WHERE verified=1")->fetchColumn() ?>
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center py-3">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Total Commission Earned</h6>
                    <h3 class="font-weight-bold text-primary mb-0">Rs. <?= number_format($totalCommission, 2) ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Payment</th>
                            <th>Provider</th>
                            <th>Status</th>
                            <th>Commission</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($bookings) === 0): ?>
                        <tr><td colspan="9" class="text-center text-muted py-4">No bookings found.</td></tr>
                        <?php endif; ?>
                        <?php foreach ($bookings as $booking): 
                            $rate = $booking->commission_rate ?? 5;
                            $commission = $rate / 100 * $booking->amount;
                        ?>
                        <tr>
                            <td><strong>#<?= $booking->id ?></strong></td>
                            <td><?= htmlspecialchars($booking->name); ?></td>
                            <td><strong>Rs. <?= number_format($booking->amount, 2); ?></strong></td>
                            <td><?= $booking->date; ?></td>
                            <td><span class="badge badge-primary"><?= htmlspecialchars($booking->payment); ?></span></td>
                            <td><?= htmlspecialchars($booking->provider_name); ?></td>
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
                            <td>
                                <small class="text-muted"><?= $rate ?>%</small><br>
                                <strong>Rs. <?= number_format($commission, 2) ?></strong>
                            </td>
                            <td>
                                <a class="btn btn-danger btn-sm" href="deletebooking.php?id=<?= $booking->id; ?>">Remove</a>
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
