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
    
    $commentObj->__set('content', $_POST['content']);
    $commentObj->__set('user_id', $_SESSION['id']);
    $commentObj->__set('article_id', $article_id);
    
    if ($commentObj->addComment()) {
        header("Location: blog-details.php?article=" . $article_id);
    } else {
        header("Location: blog-details.php?article=" . $article_id . "&error=comment_failed");
    }
    exit();
} else {
    header("Location: blog.php");
    exit();   
}
