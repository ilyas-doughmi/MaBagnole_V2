<?php
session_start();
require_once '../includes/guard.php';
require_once '../Classes/db.php';
require_once '../Classes/Comment.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = DB::connect();
    $commentObj = new Comment($db);
    
    $article_id = $_POST['article_id'];
    $comment_id = $_POST['comment_id'];
    $content = $_POST['content'];
    
    if ($commentObj->updateComment($comment_id, $content, $_SESSION['id'])) {
        header("Location: blog-details.php?article=" . $article_id . "&msg=comment_updated");
    } else {
        header("Location: blog-details.php?article=" . $article_id . "&error=update_failed");
    }
    exit();
} else {
    header("Location: blog.php");
    exit();   
}
