<?php
session_start();
require_once '../includes/guard.php';
require_once '../Classes/db.php';
require_once '../Classes/Comment.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id']) && isset($_GET['article'])) {
    $db = DB::connect();
    $commentObj = new Comment($db);
    
    $comment_id = $_GET['id'];
    $article_id = $_GET['article'];
    $user_id = $_SESSION["id"];
    
    if ($commentObj->deleteComment($comment_id, $user_id)) {
        header("Location: blog-details.php?article=" . $article_id . "&msg=comment_deleted");
    } else {
        header("Location: blog-details.php?article=" . $article_id . "&error=delete_failed");
    }
    exit();
} else {
    header("Location: blog.php");
    exit();
}
