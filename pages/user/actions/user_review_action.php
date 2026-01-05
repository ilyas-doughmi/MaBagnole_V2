<?php
session_start();
require_once "../../../Classes/db.php";
require_once "../../../Classes/Review.php";

if (!isset($_SESSION['id'])) {
    header("Location: ../../login.php");
    exit();
}

$db = DB::connect();
$review = new Review($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['delete_review'])) {
        $id = $_POST['review_id'];
        $existingReview = $review->getReviewById($id);
        if ($existingReview && $existingReview['user_id'] == $_SESSION['id']) {
            $review->softDelete($id);
        }
        header("Location: ../my-reviews.php");
        exit();
    }

    if (isset($_POST['update_review'])) {
        $id = $_POST['review_id'];
        $existingReview = $review->getReviewById($id);
        if ($existingReview && $existingReview['user_id'] == $_SESSION['id']) {
            $review->__set('rating', $_POST['rating']);
            $review->__set('comment', $_POST['comment']);
            $review->updateReview($id);
        }
        header("Location: ../my-reviews.php");
        exit();
    }
}
