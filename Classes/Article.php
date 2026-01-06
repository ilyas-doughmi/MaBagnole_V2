<?php 

class article{
    private $articleId;
    private $name;
    private $media;
    private $description;
    private $isApprove;
    private $themeId;

    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
}