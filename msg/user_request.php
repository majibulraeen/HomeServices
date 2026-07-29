<?php if (isset($_GET['msg'])): ?>
<div class="container" style="margin-top: 30px">
    <?php if ($_GET['msg'] == 'cancelled'): ?>
    <div class="alert alert-warning">
        <h4>Cancelled</h4>
        <p>Your booking has been cancelled.</p>
    </div>
    <?php elseif ($_GET['msg'] == 'rated'): ?>
    <div class="alert alert-success">
        <h4>Thank You!</h4>
        <p>Your rating has been submitted.</p>
    </div>
    <?php endif; ?>
</div>
<?php endif;
