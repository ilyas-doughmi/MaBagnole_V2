<?php

class user
{
    protected $userId;
    protected $fullname;
    protected $email;
    protected $password;
    protected $role;
    protected $createdAt;

    protected $pdo;

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

    public function login()
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ":email" => $this->email
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return false;
        }

        if (!password_verify($this->password, $result["password"])) {
            return false;
        }
        if ($result["is_active"] == 0) {
            return false;
        }

        session_start();

        $_SESSION["id"] = $result["id"];
        $_SESSION["role"] = $result["role"];
        return true;
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
    }
}
