<?php

class Theme{
    private $themeId;
    private $name;
    private $media;
    private $description;

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

    public function createTheme()
    {
        $query = "INSERT INTO themes(name,image,description)
                VALUES(:name,:image,:description)";
        $stmt = $this->pdo->prepare($query);
        
        try{
            $stmt->execute([
                ":name" => $this->name,
                ":image" => $this->media,
                ":description" => $this->description
            ]);
            return true;
        }catch(PDOException){
            return false;
        }
    }

    public function editTheme()
    {
        $query = "UPDATE themes SET name = :name, description = :description , image = :image WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        try {
            $stmt->execute([
                ':name' => $this->name,
                ':description' => $this->description,
                ':id' => $this->themeId,
                ':image' => $this->media
            ]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getThemes()
    {
        $query = "SELECT * FROM themes";
        $stmt = $this->pdo->prepare($query);
        try{
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException)
        {
            return false;
        }
    }

    public function deleteTheme()
    {
        $query = "DELETE FROM themes WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        try{
            $stmt->execute([
                ":id" => $this->themeId
            ]);
            return true;
        }catch(PDOException){
            return false;
        }
    }
}