<?php
    include_once "scripts/checklogin.php";
    include_once "include/header.php";
    include_once "scripts/DB.php";

    if (!check()) {
        header('Location: logout.php');
        exit();
    }

     $_SESSION['user'];
     $id= $_SESSION['user']->id;
     $name= $_SESSION['user']->name;
    $stmt = DB::query("SELECT * FROM bookings WHERE provider_id=$id");

    $bookings = $stmt->fetchAll(PDO::FETCH_OBJ);
?>
    <div class="container" style="margin-top: 30px; margin-bottom: 60px;">
    <h2 class="text-center"> Booking Request for You <?= $name ?></h2><br>
    <div class="table-responsive">
        <table class="table">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Contact</th>
                <th>Address</th>
                <th>Date</th>
                <th>Payment</th>
                <th>Problem</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php foreach ($bookings as $booking): ?>
            <tr><td>
                <?= $booking->id; ?>
                </td>
                <td>
                    <?= $booking->name; ?>
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
                <td>
                    <?= $booking->status == 0 ? "Active" : "Complete"; ?>
                </td>
                <td>
                    <a class="btn btn-success col-sm-12"
                        href="approvebooking.php?id=<?= $booking->id; ?>">Approve</a>
                        <br>
                    <a class="btn btn-danger mt-3 col-sm-12"
                        href="deletebook.php?id=<?= $booking->id; ?>">Remove</a>

                </td>
                
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<?php include_once "./include/footer.php";
