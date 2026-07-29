<?php
    include_once "scripts/checklogin.php";
    include_once "scripts/DB.php";
    include_once "include/header.php";

    if (!check()) {
        header('Location: logout.php');
        exit();
    }

    $user = $_SESSION['user'];
    $contact = $user->contact;

    $stmt = DB::query("SELECT b.*, p.name AS provider_name, p.photo AS provider_photo FROM bookings b, providers p WHERE b.provider_id = p.id AND b.contact=? ORDER BY b.id DESC", [$contact]);
    $bookings = $stmt->fetchAll(PDO::FETCH_OBJ);

    include_once "msg/user_request.php";
?>
<div class="container py-5" style="margin-bottom: 60px;">
    <div class="text-center mb-4">
        <h2 class="section-title">My Bookings</h2>
        <p class="section-subtitle">Track your service requests</p>
    </div>

    <?php if (count($bookings) === 0): ?>
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fa fa-calendar fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No bookings yet</h5>
            <a href="home.php" class="btn btn-primary mt-3">Find a Provider</a>
        </div>
    </div>
    <?php endif; ?>

    <?php foreach ($bookings as $booking): ?>
    <div class="card mb-3">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-2 text-center mb-3 mb-md-0">
                    <?php if ($booking->provider_photo): ?>
                    <img src="images/<?= $booking->provider_photo ?>" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                    <?php endif; ?>
                    <div class="mt-2"><strong><?= htmlspecialchars($booking->provider_name) ?></strong></div>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><strong>Booking #<?= $booking->id ?></strong> &middot; <?= $booking->date ?></p>
                    <p class="mb-1 text-muted"><?= htmlspecialchars($booking->adder) ?> &middot; Rs. <?= number_format($booking->amount, 2) ?></p>
                    <p class="mb-0 text-muted"><?= htmlspecialchars($booking->queries) ?></p>
                </div>
                <div class="col-md-4 text-md-right">
                    <div class="mb-2">
                        <?php if ($booking->status == 0): ?>
                            <span class="badge badge-warning badge-lg">Pending</span>
                        <?php elseif ($booking->status == 1): ?>
                            <span class="badge badge-info">Approved</span>
                        <?php elseif ($booking->status == 2): ?>
                            <span class="badge badge-primary">In Progress</span>
                        <?php elseif ($booking->status == 3): ?>
                            <span class="badge badge-success">Completed</span>
                        <?php elseif ($booking->status == 4): ?>
                            <span class="badge badge-danger">Cancelled</span>
                            <?php if ($booking->cancellation_reason): ?>
                                <br><small class="text-muted"><?= htmlspecialchars($booking->cancellation_reason) ?></small>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <?php if ($booking->status == 0 || $booking->status == 1): ?>
                    <a href="scripts/cancel_booking.php?id=<?= $booking->id ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Cancel this booking?')">Cancel</a>
                    <?php endif; ?>

                    <?php if ($booking->status == 3 && !$booking->rating): ?>
                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#rateModal<?= $booking->id ?>">Rate & Review</button>
                    <?php endif; ?>

                    <?php if ($booking->rating): ?>
                    <div class="text-warning">
                        <?= str_repeat('&#9733;', $booking->rating) . str_repeat('&#9734;', 5 - $booking->rating) ?>
                        <?php if ($booking->review): ?><br><small class="text-muted">"<?= htmlspecialchars($booking->review) ?>"</small><?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php if ($booking->status == 3 && !$booking->rating): ?>
    <div class="modal fade" id="rateModal<?= $booking->id ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="scripts/rate_provider.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title">Rate <?= htmlspecialchars($booking->provider_name) ?></h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="booking_id" value="<?= $booking->id ?>">
                        <div class="form-group">
                            <label>Rating</label>
                            <select name="rating" class="form-control" required>
                                <option value="5">5 - Excellent</option>
                                <option value="4">4 - Good</option>
                                <option value="3">3 - Average</option>
                                <option value="2">2 - Poor</option>
                                <option value="1">1 - Terrible</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Review (optional)</label>
                            <textarea name="review" class="form-control" rows="3" maxlength="500" placeholder="Share your experience..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="rate" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php endforeach; ?>
</div>

<?php include_once "./include/footer.php"; ?>
