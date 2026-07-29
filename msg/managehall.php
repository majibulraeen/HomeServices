<?php if (isset($_GET['msg'])): ?>
<div class="container" style="margin-top: 30px">
    <?php if ($_GET['msg'] == 'success'): ?>
    <div class="alert alert-success">
        <h3>Success</h3>
        <p>Provider deleted successfully.</p>
    </div>
    <?php elseif ($_GET['msg'] == 'failed'): ?>
    <div class="alert alert-danger">
        <h3>Failure</h3>
        <p>Problem while deleting provider data! Please try again later!</p>
    </div>
    <?php elseif ($_GET['msg'] == 'verified'): ?>
    <div class="alert alert-success">
        <h3>Verified!</h3>
        <p>Provider has been verified and will now appear in customer searches.</p>
    </div>
    <?php elseif ($_GET['msg'] == 'unverified'): ?>
    <div class="alert alert-warning">
        <h3>Verification Revoked</h3>
        <p>Provider verification has been revoked.</p>
    </div>
    <?php endif; ?>
</div>
<?php endif;
