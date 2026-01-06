<?php

class Theme{
    private $themeId;
    private $name;
    private $media;
    private $description;


    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }
}