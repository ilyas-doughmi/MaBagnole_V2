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
}