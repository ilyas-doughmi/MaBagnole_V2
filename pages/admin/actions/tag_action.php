<?php
session_start();
require_once "../../../Classes/db.php";
require_once "../../../Classes/Tag.php";

$db = DB::connect();
$tagObj = new Tag($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_tag'])) {
        $name = $_POST['tag_name'];
        if ($tagObj->addTag($name)) {
            header("Location: ../tags.php?status=success");
        } else {
            header("Location: ../tags.php?status=error");
        }
    } elseif (isset($_POST['delete_tag'])) {
        $id = $_POST['tag_id'];
        if ($tagObj->deleteTag($id)) {
            header("Location: ../tags.php?status=deleted");
        } else {
            header("Location: ../tags.php?status=error");
        }
    }
}
?>