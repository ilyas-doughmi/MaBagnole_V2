<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../../index.php');
    exit();
}

require_once '../../../Classes/db.php';
require_once '../../../Classes/Article.php';

$db = DB::connect();
$articleObj = new Article($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['check_approve']) && isset($_POST['article_id'])) {
        $id = $_POST['article_id'];
        if ($articleObj->approveArticle($id)) {
            header('Location: ../articles.php?status=approved');
        } else {
            header('Location: ../articles.php?status=error');
        }
    }

    if (isset($_POST['check_reject']) && isset($_POST['article_id'])) {
        $id = $_POST['article_id'];
        if ($articleObj->deleteArticle($id)) {
            header('Location: ../articles.php?status=deleted');
        } else {
            header('Location: ../articles.php?status=error');
        }
    }
}
?>



}

