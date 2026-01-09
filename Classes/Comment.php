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

    public function addComment() {
        $query = "INSERT INTO comments (content, user_id, article_id) 
                  VALUES (:content, :user_id, :article_id)";
        $stmt = $this->pdo->prepare($query);
        try {
            $stmt->execute([
                ':content' => $this->content,
                ':user_id' => $this->user_id,
                ':article_id' => $this->article_id
            ]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
