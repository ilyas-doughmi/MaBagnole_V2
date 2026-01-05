<?php
require_once "db.php";

class Reservation {
    private $pdo;
    private $reservation_id;
    private $user_id;
    private $vehicle_id;
    private $start_date;
    private $end_date;
    private $pickup_location;
    private $return_location;
    private $reservation_status;
    private $created_at;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function __set($name, $value) {
        $this->$name = $value;
    }

    public function __get($name) {
        return $this->$name;
    }

    public function createReservation() {
        $query = "INSERT INTO reservation (user_id, vehicle_id, start_date, end_date, pickup_location, return_location, reservation_status) 
                  VALUES (:user_id, :vehicle_id, :start_date, :end_date, :pickup_location, :return_location, :status)";
        $stmt = $this->pdo->prepare($query);
        
        try {
            $stmt->execute([
                ':user_id' => $this->user_id,
                ':vehicle_id' => $this->vehicle_id,
                ':start_date' => $this->start_date,
                ':end_date' => $this->end_date,
                ':pickup_location' => $this->pickup_location ?? 'Agence MaBagnole',
                ':return_location' => $this->return_location ?? 'Agence MaBagnole',
                ':status' => 'pending' 
            ]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getReservationsByUserId($user_id) {
        $query = "SELECT reservation.*, vehicle.*
                  FROM reservation  
                  JOIN vehicle ON reservation.vehicle_id = vehicle.vehicle_id 
                  WHERE reservation.user_id = :user_id 
                  ORDER BY reservation.reservation_date DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllReservations() {
        $query = "SELECT reservation.*, vehicle.brand, vehicle.model, vehicle.image, vehicle.price_per_day, users.full_name, users.email
                  FROM reservation  
                  JOIN vehicle ON reservation.vehicle_id = vehicle.vehicle_id 
                  JOIN users ON reservation.user_id = users.id
                  ORDER BY reservation.reservation_date DESC";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($id, $status) {
        $query = "UPDATE reservation SET reservation_status = :status WHERE reservation_id = :id";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([':status' => $status, ':id' => $id]);
    }

    public function getTotalReservations() {
        $query = "SELECT COUNT(*) FROM reservation";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchColumn();
    }

    public function calculateEarnings() {
        $query = "SELECT r.start_date, r.end_date, v.price_per_day
                  FROM reservation r
                  JOIN vehicle v ON r.vehicle_id = v.vehicle_id
                  WHERE r.reservation_status = 'confirmed'";
        $stmt = $this->pdo->query($query);
        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $totalEarnings = 0;
        foreach ($reservations as $res) {
            $start = new DateTime($res['start_date']);
            $end = new DateTime($res['end_date']);
            $diff = $start->diff($end);
            $days = $diff->days;
            if ($days == 0) $days = 1; 
            $totalEarnings += $days * $res['price_per_day'];
        }
        return $totalEarnings;
    }

    public function isVehicleAvailable($vehicle_id, $start_date, $end_date) {
        $query = "SELECT COUNT(*) FROM reservation 
                  WHERE vehicle_id = :vehicle_id 
                  AND reservation_status = 'confirmed' 
                  AND (
                      (start_date <= :end_date AND end_date >= :start_date)
                  )";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ':vehicle_id' => $vehicle_id,
            ':start_date' => $start_date,
            ':end_date' => $end_date
        ]);
        return $stmt->fetchColumn() == 0;
    }
}
