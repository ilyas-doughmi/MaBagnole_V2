<?php

class DB
{
    private static $instance = null;
    private $pdo;

    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $db_name = "mabagnole";

    private function __construct()
    {
        $this->pdo = new PDO(
            "mysql:host={$this->host};dbname={$this->db_name};charset=utf8",
            $this->user,
            $this->password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
    }

    public static function connect()
    {
        if (self::$instance === null) {
            self::$instance = new DB();
        }
        return self::$instance->pdo;
    }
}
