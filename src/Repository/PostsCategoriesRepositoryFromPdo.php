<?php

namespace Project4\Repository;

use PDO;
use Project4\Entity\PostsCategories;

class PostsCategoriesRepositoryFromPdo implements PostsCategoriesRepository
{
    public function __construct(private \PDO $pdo)
    {
    }

    public function storePostsCategories(PostsCategories $postsCategories): void
    {
        $stm = $this->pdo->prepare(<<<SQL
                INSERT INTO posts_categories (id_post, id_category)
                VALUES (:id_post, :id_category);
                SQL);

        $postId = $postsCategories->postsId();
        $categoriesId = $postsCategories->categoriesId();

        $param = [
            ':id_post' => $postId,
            ':id_category' => $categoriesId
        ];

       $stm->execute($param);
    }

    public function find($id): PostsCategories
    {
        $stmt = $this->pdo->prepare(<<<SQL
           SELECT pc.id_post AS id_posts, pc.id_category AS id_categories, p.title AS title, p.slug AS slug,
                  p.content AS content, p.thumbnail AS thumbnail, p.author AS author, p.posted_at AS posted_at, c.name AS name
            FROM categories c 
            JOIN posts_categories pc ON pc.id_category=c.id
            JOIN posts p ON pc.id_post=p.id
            WHERE id_post = :id_post
        SQL);

        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, PostsCategories::class);
        $stmt->bindParam(':id_post', $id);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return PostsCategories::populate($data);
    }
}