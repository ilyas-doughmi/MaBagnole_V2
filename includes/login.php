<?php

if (isset($_POST["login"])) {
    require_once(__DIR__ . "/../Classes/db.php");
    require_once(__DIR__ . "/../Classes/user.php");

    $pdo = DB::connect();
    $user = new user($pdo);

    $user->__set("email", $_POST["email"]);
    $user->__set("password", $_POST["password"]);

    if (!$user->login()) {
        header("location: ../pages/login.php?msg=Problem Happend");
        exit();
    }

    session_start();

    if ($_SESSION["role"] == "admin") {
        header("location: ../pages/admin/dashboard.php");
        exit();
    } else {
        header("location: ../index.php?msg=Login Success");
        exit();
    }
}
