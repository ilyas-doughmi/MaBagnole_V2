<?php
require_once "../../../Classes/db.php";
require_once "../../../Classes/Reservation.php";

$db = DB::connect();
$reservation = new Reservation($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['confirm_reservation'])) {
        $id = $_POST['reservation_id'];
        $reservation->updateStatus($id, 'confirmed');
        header("Location: ../reservations.php");
        exit();
    }

    if (isset($_POST['cancel_reservation'])) {
        $id = $_POST['reservation_id'];
        $reservation->updateStatus($id, 'cancelled');
        header("Location: ../reservations.php");
        exit();
    }
}
