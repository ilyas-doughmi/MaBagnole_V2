<?php
require_once "../../../Classes/db.php";
require_once "../../../Classes/client.php";

$db = DB::connect();
$client = new client($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['activate_user'])) {
        $id = $_POST['user_id'];
        $client->__set('isActive', 1);
        $client->activateUser($id);
        header("Location: ../clients.php");
        exit();
    }

    if (isset($_POST['ban_user'])) {
        $id = $_POST['user_id'];
        $client->__set('isActive', 0);
        $client->banUser($id);
        header("Location: ../clients.php");
        exit();
    }
}
