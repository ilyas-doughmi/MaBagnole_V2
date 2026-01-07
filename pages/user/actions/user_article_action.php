<?php
session_start();
require_once "../../../Classes/db.php";
require_once "../../../Classes/Article.php";

if (!isset($_SESSION['id'])) {
    header("Location: ../../login.php");
    exit();
}

$db = DB::connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $articleObj = new Article($db);
    $articleObj->__set('name', $_POST['title']);
    $articleObj->__set('media', $_POST['image']);
    $articleObj->__set('description', $_POST['description']);
    $articleObj->__set('themeId', $_POST['theme_id']); 
    
    $articleId = $articleObj->addArticle($_SESSION['id']);

    if ($articleId) {
        if (isset($_POST['tags']) && is_array($_POST['tags'])) {
            $articleObj->addTags($articleId, $_POST['tags']);
        }
        header("Location: ../add-article.php?status=success");
        exit();
    } else {
        header("Location: ../add-article.php?status=error");
        exit();
    }
}
?>