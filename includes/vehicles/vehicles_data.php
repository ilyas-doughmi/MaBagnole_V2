<?php
require_once(__DIR__ . "/../../Classes/db.php");
require_once(__DIR__ . "/../../Classes/vehicle.php");

$pdo = DB::connect();
$vehicles = new vehicle($pdo);

$vehicles = $vehicles->getVehicles();