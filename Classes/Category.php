<?php

class Category {
    private $category_id;
    private $category_name;
    private $category_description;
    private $created_at;
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function __set($name, $value) {
        $this->$name = $value;
    }

    public function __get($name) {
        return $this->$name;
    }

    public function addCategory() {
        $query = "INSERT INTO category (category_name, category_description) VALUES (:name, :description)";
        $stmt = $this->pdo->prepare($query);
        try {
            $stmt->execute([
                ':name' => $this->category_name,
                ':description' => $this->category_description
            ]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getCategories() {
        $query = "SELECT c.*, COUNT(v.vehicle_id) as count 
                  FROM category c 
                  LEFT JOIN vehicle v ON c.category_id = v.category_id 
                  GROUP BY c.category_id";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoryById($id) {
        $query = "SELECT * FROM category WHERE category_id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateCategory() {
        $query = "UPDATE category SET category_name = :name, category_description = :description WHERE category_id = :id";
        $stmt = $this->pdo->prepare($query);
        try {
            $stmt->execute([
                ':name' => $this->category_name,
                ':description' => $this->category_description,
                ':id' => $this->category_id
            ]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteCategory($id) {
        $query = "DELETE FROM category WHERE category_id = :id";
        $stmt = $this->pdo->prepare($query);
        try {
            $stmt->execute([':id' => $id]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
