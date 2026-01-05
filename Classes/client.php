<?php

require_once("user.php");


class client extends user
{
    private $isActive;

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function register()
    {
        $query = "INSERT INTO users(full_name,email,password)
        VALUES(:fullname,:email,:password)";

        $stmt = $this->pdo->prepare($query);

        $hashed_password = password_hash($this->password,PASSWORD_DEFAULT);

        try {
            $stmt->execute([
                ":fullname" => $this->fullname,
                ":email" => $this->email,
                ":password" => $hashed_password
            ]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getAllClients()
    {
        $query = "SELECT * FROM users WHERE role != 'admin' ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function activateUser($id) {
        $query = "UPDATE users SET is_active = :isActive WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([':isActive' => $this->isActive, ':id' => $id]);
    }

    public function banUser($id) {
        $query = "UPDATE users SET is_active = :isActive WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([':isActive' => $this->isActive, ':id' => $id]);
    }
}
