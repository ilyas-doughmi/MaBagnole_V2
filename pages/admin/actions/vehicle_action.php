<?php
require_once "../../../Classes/db.php";
require_once "../../../Classes/vehicle.php";

$db = DB::connect();
$vehicle = new vehicle($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['add_vehicle'])) { 
        $brands = $_POST['brand'];
        $models = $_POST['model'];
        $prices = $_POST['price'];
        $categories = $_POST['category'];
        $images = $_POST['image'];

        for ($i = 0; $i < count($brands); $i++) {
            $vehicle->brand = $brands[$i];
            $vehicle->model = $models[$i];
            $vehicle->pricePerDay = $prices[$i];
            $vehicle->category_id = $categories[$i]; 
            $vehicle->imagePath = $images[$i];
            
            $vehicle->addVehicle();
        }
        header("Location: ../vehicles.php");
        exit();
    }

    if (isset($_POST['delete_vehicle'])) {
        $id = $_POST['vehicle_id'];
        $vehicle->deleteVehicle($id);
        header("Location: ../vehicles.php");
        exit();
    }
    if (isset($_POST['update_vehicle'])) {
        $id = $_POST['vehicle_id'];
        $vehicle->brand = $_POST['brand'];
        $vehicle->model = $_POST['model'];
        $vehicle->pricePerDay = $_POST['price'];
        $vehicle->category_id = $_POST['category'];
        $vehicle->imagePath = $_POST['image'];
        $vehicle->isAvailable = isset($_POST['is_available']) ? 1 : 0;

        $vehicle->updateVehicle($id);
        header("Location: ../vehicles.php");
        exit();
    }
}
