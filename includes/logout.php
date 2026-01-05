<?php
require_once(__DIR__ . "/../Classes/db.php");
require_once(__DIR__ . "/../Classes/user.php");

$pdo = DB::connect();
$user = new user($pdo);
$user->logout();
header("location: ../index.php?msg=Logout Success");
exit();