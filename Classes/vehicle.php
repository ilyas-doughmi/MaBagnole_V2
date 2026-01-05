<?php

class vehicle{
    private $vehicle_id;
    private $brand;
    private $model;
    private $pricePerDay;
    private $description;
    private $imagePath;
    private $isAvailable;
    private $category_id;
    private $createdAt;

    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function getVehicles()
    {
        $query = "SELECT v.*, c.category_name 
                  FROM vehicle v 
                  LEFT JOIN category c ON v.category_id = c.category_id
                  ORDER BY v.created_at DESC";
        
        $stmt = $this->pdo->query($query);
        $stmt->execute();
        $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $count = count($vehicles);

        return [
            "vehicles" => $vehicles,
            "count" => $count
        ];
    }

    public function searchVehicles($search) {
        $query = "SELECT v.*, c.category_name 
                  FROM vehicle v 
                  LEFT JOIN category c ON v.category_id = c.category_id
                  WHERE v.brand LIKE :search OR v.model LIKE :search OR c.category_name LIKE :search
                  ORDER BY v.created_at DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':search' => '%' . $search . '%']);
        $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return [
            "vehicles" => $vehicles,
            "count" => count($vehicles)
        ];
    }

    public function getVehiclesPaginated($page, $perPage) {
        $offset = ($page - 1) * $perPage;
        $query = "SELECT vehicle.*, category.category_name 
                  FROM vehicle 
                  JOIN category ON vehicle.category_id = category.category_id
                  ORDER BY vehicle.created_at DESC
                  LIMIT $perPage OFFSET $offset";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalVehicles() {
        $query = "SELECT COUNT(*) FROM vehicle";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchColumn();
    }

    public function addVehicle()
    {
        $query = "INSERT INTO vehicle (brand, model, price_per_day, image, is_available, category_id) 
                  VALUES (:brand, :model, :price, :image, :available, :category_id)";
        $stmt = $this->pdo->prepare($query);
        try {
            $stmt->execute([
                ':brand' => $this->brand,
                ':model' => $this->model,
                ':price' => $this->pricePerDay,
                ':image' => $this->imagePath,
                ':available' => $this->isAvailable ?? 1,
                ':category_id' => $this->category_id
            ]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getVehicleById($id)
    {
        $query = "SELECT v.*, c.category_name 
                  FROM vehicle v 
                  LEFT JOIN category c ON v.category_id = c.category_id 
                  WHERE v.vehicle_id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ':id' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateVehicle($id)
    {
        $query = "UPDATE vehicle SET brand = :brand, model = :model, price_per_day = :price, 
                  image = :image, category_id = :category_id, is_available = :available 
                  WHERE vehicle_id = :id";
        $stmt = $this->pdo->prepare($query);
        try {
            $stmt->execute([
                ':brand' => $this->brand,
                ':model' => $this->model,
                ':price' => $this->pricePerDay,
                ':image' => $this->imagePath,
                ':category_id' => $this->category_id,
                ':available' => $this->isAvailable,
                ':id' => $id
            ]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteVehicle($id)
    {
        $query = "DELETE FROM vehicle WHERE vehicle_id = :id";
        $stmt = $this->pdo->prepare($query);
        try {
            $stmt->execute([
                ':id' => $id
            ]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}