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
<div class="container" style="margin-top: 30px; margin-bottom: 60px;">
    <h2 class="text-center"> Contact Us Information </h2>
    <div class="table-responsive">
        <table class="table">
            <tr>
                <th>Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Issues</th>
                <th>Queries</th>
            </tr>
            <?php foreach ($comments as $comment): ?>
            <tr>
                <td>
                    <?= $comment->fname; ?>
                </td>
                <td>
                    <?= $comment->mobile; ?>
                </td>
                <td>
                    <?= $comment->email; ?>
                </td>
                <td>
                    <?= $comment->issue; ?>
                </td>
                <td>
                    <?= $comment->comment; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<?php include_once "include/footer.php";
