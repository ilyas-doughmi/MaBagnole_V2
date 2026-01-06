<?php 

class article{
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
    public function getArticlesPerTheme()
    {
        $query = "SELECT * FROM articles JOIN users ON users.id = articles.author_id WHERE theme_id = :themeId";
        $stmt = $this->pdo->prepare($query);
        try{
                    $stmt->execute([
            ":themeId" => $this->themeId
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            return false;
        }


    }
}