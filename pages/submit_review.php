<?php
session_start();
require_once '../includes/guard.php';
require_once '../Classes/db.php';
require_once '../Classes/Review.php';

require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = DB::connect();
    $review = new Review($db);
    
    $review->__set('rating', $_POST['rating']);
    $review->__set('comment', $_POST['comment']);
    $review->__set('user_id', $_SESSION['id']);
    $review->__set('vehicle_id', $_POST['vehicle_id']);
    
    if ($review->addReview()) {
        header("Location: vehicle-details.php?id=" . $_POST['vehicle_id']);
    } else {
        header("Location: vehicle-details.php?id=" . $_POST['vehicle_id']);
    }
    exit();
}