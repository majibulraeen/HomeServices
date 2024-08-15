<?php
    include_once "scripts/checklogin.php";
    include_once "include/header.php";
    include_once "scripts/DB.php";

    if (!check("admin")) {
        header('Location: logout.php');
        exit();
    }
    $id=intval($_GET['id']);
    $stmt = DB::query("SELECT * FROM bookings WHERE provider_id=$id");

    $bookings = $stmt->fetchAll(PDO::FETCH_OBJ);
?>
    <div class="container" style="margin-top: 30px; margin-bottom: 60px;">
    <h2 class="text-center"> Bookings </h2>
    <div class="table-responsive">
        <table class="table">
            <tr>
                <th>ID</th>
                <th>Provider ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Contact</th>
                <th>Address</th>
                <th>Date</th>
                <th>Payment</th>
                <th>Problem</th>
            </tr>
            <?php foreach ($bookings as $booking): ?>
            <tr><td>
                <?= $booking->id; ?>
                </td>
                <td>
                <?= $booking->provider_id; ?>
                </td>
                <td>
                    <?= $booking->fname; ?>
                </td>
                <td>
                    <?= $booking->lname; ?>
                </td>
                <td>
                    <?= $booking->contact; ?>
                </td>
                <td>
                    <?= $booking->adder; ?>
                </td>
                <td>
                    <?= $booking->date; ?>
                </td>
                <td>
                    <?= $booking->payment; ?>
                </td>
                <td>
                    <?= $booking->queries; ?>
                </td>
                
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<?php include_once "./include/footer.php";
