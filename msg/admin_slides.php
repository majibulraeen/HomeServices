<?php if (isset($_GET['msg'])): ?>
<div class="container" style="margin-top: 30px">
    <?php if ($_GET['msg'] == 'added'): ?>
    <div class="alert alert-success">Slide added successfully.</div>
    <?php elseif ($_GET['msg'] == 'deleted'): ?>
    <div class="alert alert-success">Slide deleted successfully.</div>
    <?php elseif ($_GET['msg'] == 'toggled'): ?>
    <div class="alert alert-success">Slide status updated.</div>
    <?php elseif ($_GET['msg'] == 'failed'): ?>
    <div class="alert alert-danger">Something went wrong.</div>
    <?php endif; ?>
</div>
<?php endif;
