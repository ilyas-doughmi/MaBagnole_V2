<?php

class article
{
    private $articleId;
    private $name;
    private $media;
    private $description;
    private $isApprove;
    private $themeId;
    private $author_id;

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

    public function addArticle($author_id)
    {
        $query = "INSERT INTO articles (name, media, description, theme_id, author_id) VALUES (:name, :media, :description, :theme_id, :author_id)";
        $stmt = $this->pdo->prepare($query);
        try {
            $stmt->execute([
                ':name' => $this->name,
                ':media' => $this->media,
                ':description' => $this->description,
                ':theme_id' => $this->themeId,
                ':author_id' => $author_id
            ]);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function addTags($articleId, $tags)
    {
        $query = "INSERT INTO article_tag (articleId, tagId) VALUES (:articleId, :tagId)";
        $stmt = $this->pdo->prepare($query);
        try {
            foreach($tags as $tagId){
                $stmt->execute([
                    ':articleId' => $articleId,
                    ':tagId' => $tagId
                ]);
            }
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getArticlesPerTheme()
    {
        $query = "SELECT *,articles.id as artid FROM articles JOIN users ON users.id = articles.author_id WHERE theme_id = :themeId AND isApproved = 1";
        $stmt = $this->pdo->prepare($query);
        try {
            $stmt->execute([
                ":themeId" => $this->themeId
            ]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function approveArticle($id)
    {
        $query = "UPDATE articles SET isApproved = 1 WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        try {
            $stmt->execute([
                ":id" => $id
            ]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteArticle($id)
    {
        $query = "DELETE FROM articles WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        try {
            $stmt->execute([
                ":id" => $id
            ]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

     public function getAllArticles()
    {
        $query = "SELECT articles.*, themes.name as theme_name, users.full_name as author_name 
                  FROM articles 
                  LEFT JOIN themes ON articles.theme_id = themes.id
                  LEFT JOIN users ON articles.author_id = users.id
                  ORDER BY createdAt DESC";
        $stmt = $this->pdo->prepare($query);
        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

public function getArticleDetails()
{
    $query = "
        SELECT articles.*, 
                   articles.name AS title,
                   articles.createdAt AS date,
                   themes.name AS theme_name, 
                   users.full_name AS author
            FROM articles
            JOIN themes ON articles.theme_id = themes.id
            JOIN users ON users.id = articles.author_id
            WHERE articles.id = :id";
        $stmt = $this->pdo->prepare($query);

    try{

        $stmt->execute([
            ":id" => $this->name
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;

    } catch (PDOException $e) {
        return null; 
    }
}
}