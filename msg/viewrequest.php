<?php if (isset($_GET['msg'])): ?>
<div class="container" style="margin-top: 30px">
    <?php if ($_GET['msg'] == 'approved'): ?>
    <div class="alert alert-success">
        <h4>Booking Approved</h4>
        <p>You have approved this booking. Start the work when you arrive.</p>
    </div>
    <?php elseif ($_GET['msg'] == 'started'): ?>
    <div class="alert alert-info">
        <h4>Work Started</h4>
        <p>Booking marked as in progress.</p>
    </div>
    <?php elseif ($_GET['msg'] == 'completed'): ?>
    <div class="alert alert-success">
        <h4>Work Completed</h4>
        <p>Booking marked as completed. The customer can now rate your service.</p>
    </div>
    <?php elseif ($_GET['msg'] == 'cancelled'): ?>
    <div class="alert alert-warning">
        <h4>Booking Cancelled</h4>
        <p>The booking has been cancelled.</p>
    </div>
    <?php endif; ?>
</div>
<?php endif;
