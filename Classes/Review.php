<?php
require_once "db.php";

class Review {
    private $pdo;
    private $review_id;
    private $rating;
    private $comment;
    private $user_id;
    private $vehicle_id;
    private $review_date;
    private $deleted_at;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function __set($name, $value) {
        $this->$name = $value;
    }

    public function __get($name) {
        return $this->$name;
    }

    public function addReview() {
        $query = "INSERT INTO review (rating, comment, user_id, vehicle_id) 
                  VALUES (:rating, :comment, :user_id, :vehicle_id)";
        $stmt = $this->pdo->prepare($query);
        try {
            $stmt->execute([
                ':rating' => $this->rating,
                ':comment' => $this->comment,
                ':user_id' => $this->user_id,
                ':vehicle_id' => $this->vehicle_id
            ]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getReviewsByVehicleId($vehicle_id) {
        $query = "SELECT r.*, u.full_name 
                  FROM review r 
                  JOIN users u ON r.user_id = u.id 
                  WHERE r.vehicle_id = :vehicle_id AND r.deleted_at IS NULL 
                  ORDER BY r.review_date DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':vehicle_id' => $vehicle_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReviewsByUserId($user_id) {
        $query = "SELECT r.*, v.brand, v.model 
                  FROM review r 
                  JOIN vehicle v ON r.vehicle_id = v.vehicle_id 
                  WHERE r.user_id = :user_id AND r.deleted_at IS NULL 
                  ORDER BY r.review_date DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllReviews() {
        $query = "SELECT r.*, u.full_name, u.email, v.brand, v.model 
                  FROM review r 
                  JOIN users u ON r.user_id = u.id 
                  JOIN vehicle v ON r.vehicle_id = v.vehicle_id 
                  ORDER BY r.review_date DESC";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReviewById($id) {
        $query = "SELECT * FROM review WHERE review_id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateReview($id) {
        $query = "UPDATE review SET rating = :rating, comment = :comment WHERE review_id = :id";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([
            ':rating' => $this->rating,
            ':comment' => $this->comment,
            ':id' => $id
        ]);
    }

    public function softDelete($id) {
        $query = "UPDATE review SET deleted_at = NOW() WHERE review_id = :id";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([':id' => $id]);
    }

    public function restore($id) {
        $query = "UPDATE review SET deleted_at = NULL WHERE review_id = :id";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([':id' => $id]);
    }

    public function getTotalReviews() {
        $query = "SELECT COUNT(*) FROM review WHERE deleted_at IS NULL";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchColumn();
    }
}
