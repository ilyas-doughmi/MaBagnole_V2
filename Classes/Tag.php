<?php

class tag{
    private $tagId;
    private $name;
    
    private $pdo;

    public function __construct($pdo)
    {
        return $this->pdo = $pdo;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function getTags()
    {
        $query = "SELECT * FROM tag";
        $stmt = $this->pdo->prepare($query);
        try{
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            return false;
        }
    }

    public function addTag($name)
    {
        $query = "INSERT INTO tag (name) VALUES (:name)";
        $stmt = $this->pdo->prepare($query);
        try{
            $stmt->execute([':name' => $name]);
            return true;
        }catch(PDOException $e){
            return false;
        }
    }

    public function deleteTag($id)
    {
        $query = "DELETE FROM tag WHERE tagId = :id";
        $stmt = $this->pdo->prepare($query);
        try{
            $stmt->execute([':id' => $id]);
            return true;
        }catch(PDOException $e){
            return false;
        }
    }
}