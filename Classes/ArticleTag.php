<?php

class ArticleTag{
    public static function getArticleTags($pdo,$id)
    {
        $query = "SELECT tag.* FROM article_tag JOIN tag ON tag.tagId  = article_tag.tagId WHERE articleTagId = :id";
        $stmt = $pdo->prepare($query);
        try{
            $stmt->execute([
                ":id" => $id
            ]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            return false;
        }
    } 
}