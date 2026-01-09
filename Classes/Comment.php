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
    
    public function getCommentsByArticleId($article_id) {
        $query = "SELECT c.*, u.full_name 
                  FROM comments c 
                  JOIN users u ON c.user_id = u.id 
                  WHERE c.article_id = :article_id 
                  ORDER BY c.created_at DESC";
        $stmt = $this->pdo->prepare($query);
        try {
             $stmt->execute([':article_id' => $article_id]);
             return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function updateComment($commentId, $content, $userId) {
        $query = "UPDATE comments SET content = :content, update_at = NOW() WHERE commentId = :commentId AND user_id = :user_id";
        $stmt = $this->pdo->prepare($query);
        try {
            return $stmt->execute([
                ':content' => $content,
                ':commentId' => $commentId,
                ':user_id' => $userId
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteComment($commentId, $userId)
    {
        $query = "DELETE FROM comments WHERE commentId = :commentId AND user_id = :user_id";
        $stmt = $this->pdo->prepare($query);
        try {
            return $stmt->execute([
                ':commentId' => $commentId,
                ':user_id' => $userId
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getAllComments() {
        $query = "SELECT c.*, u.full_name, a.name as article_title 
                  FROM comments c 
                  JOIN users u ON c.user_id = u.id 
                  JOIN articles a ON c.article_id = a.id
                  ORDER BY c.created_at DESC";
        $stmt = $this->pdo->prepare($query);
        try {
             $stmt->execute();
             return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function deleteCommentById($commentId) {
        $query = "DELETE FROM comments WHERE commentId = :commentId";
        $stmt = $this->pdo->prepare($query);
        try {
            return $stmt->execute([':commentId' => $commentId]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
