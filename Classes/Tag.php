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
}