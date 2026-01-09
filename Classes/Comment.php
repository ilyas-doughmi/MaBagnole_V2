<?php
require_once "db.php";

class Comment {
    private $pdo;
    private $content;
    private $user_id;
    private $article_id;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function __set($name, $value) {
        $this->$name = $value;
    }

    public function __get($name) {
        return $this->$name;
    }
}
