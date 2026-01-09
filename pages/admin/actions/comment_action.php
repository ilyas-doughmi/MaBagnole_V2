<?php
session_start();
require_once '../../../Classes/db.php';
require_once '../../../Classes/Comment.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = DB::connect();
    $commentObj = new Comment($db);
    
    if (isset($_POST['delete_comment'])) {
        $id = $_POST['comment_id'];
        
        if ($commentObj->deleteCommentById($id)) {
            $_SESSION['message'] = "Commentaire supprimé avec succès.";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['message'] = "Erreur lors de la suppression du commentaire.";
            $_SESSION['msg_type'] = "danger";
        }
    }
}

header("Location: ../comments.php");
exit();
