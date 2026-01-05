<?php
require_once "../../../Classes/db.php";
require_once "../../../Classes/Review.php";

$db = DB::connect();
$review = new Review($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['delete_review'])) {
        $id = $_POST['review_id'];
        $review->softDelete($id);
        header("Location: ../reviews.php");
        exit();
    }

    if (isset($_POST['restore_review'])) {
        $id = $_POST['review_id'];
        $review->restore($id);
        header("Location: ../reviews.php");
        exit();
    }
}
