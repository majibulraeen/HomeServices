<?php
    include_once "scripts/checklogin.php";
    include_once "scripts/DB.php";
    include_once "include/header.php";

    if (!check("admin")) {
        header('Location: logout.php');
        exit();
    }

    $sql = "SELECT * FROM comments";
    $comments = DB::query($sql)->fetchAll(PDO::FETCH_OBJ);

    include_once "msg/admin.php";
?>
<div class="container py-5" style="margin-bottom: 60px;">
    <div class="text-center mb-4">
        <h2 class="section-title">Contact Messages</h2>
        <p class="section-subtitle">Messages received from the contact form</p>
    </div>
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Issue</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($comments) === 0): ?>
                        <tr><td colspan="5" class="text-center text-muted py-4">No messages yet.</td></tr>
                        <?php endif; ?>
                        <?php foreach ($comments as $comment): ?>
                        <tr>
                            <td><strong><?= $comment->fname; ?></strong></td>
                            <td><?= $comment->mobile; ?></td>
                            <td><?= $comment->email; ?></td>
                            <td><span class="badge badge-primary"><?= $comment->issue; ?></span></td>
                            <td><?= $comment->comment; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once "include/footer.php"; ?>
