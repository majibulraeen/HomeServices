<?php if (isset($_GET['msg'])): ?>
<div class="container" style="margin-top: 30px">

    <?php if ($_GET['msg'] == 'success'): ?>
    <div class="alert alert-success">
        <h4>Registration Submitted</h4>
        <p>Your account has been created. An admin will review your documents and verify your account shortly.</p>
        <p class="mb-0">You will only appear in customer searches once verified.</p>
    </div>

    <?php elseif ($_GET['msg'] == 'failed'): ?>
    <div class="alert alert-danger">
        <h4>Registration Failed</h4>
        <p>Problem while registering! Please try again later.</p>
    </div>

    <?php elseif ($_GET['msg'] == 'file'): ?>
    <div class="alert alert-danger">
        <h4>Upload Error</h4>
        <p>Problem uploading photo or license document. Allowed formats: JPG, PNG, GIF, PDF.</p>
    </div>
    <?php endif; ?>

</div>
<?php endif;
