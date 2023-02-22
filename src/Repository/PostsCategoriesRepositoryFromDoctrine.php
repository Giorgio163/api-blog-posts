<?php

namespace Project4\Repository;

use Doctrine\ORM\EntityManager;
use PDO;
use Project4\Entity\PostsCategories;
use Ramsey\Uuid\Uuid;

class PostsCategoriesRepositoryFromDoctrine implements PostsCategoriesRepository
{
    public function __construct(private EntityManager $entityManager)
    {
    }

//    public function storePostsCategories(PostsCategories $postsCategories): void
//    {
//        $stm = $this->pdo->prepare(
//            <<<SQL
//                INSERT INTO posts_categories (id_post, id_category)
//                VALUES (:id_post, :id_category);
//                SQL
//        );
//
//        $postId = $postsCategories->postsId();
//        $categoriesId = $postsCategories->categoriesId();
//
//        $param = [
//            ':id_post' => $postId,
//            ':id_category' => $categoriesId
//        ];
//
//        $stm->execute($param);
//    }
//
//    public function find($id): array
//    {
//        $stmt = $this->pdo->prepare(
//            <<<SQL
//           SELECT pc.id_post AS id_post, pc.id_category AS id_category, p.title AS title, p.slug AS slug,
//                  p.content AS content, p.thumbnail AS thumbnail, p.author AS author, p.posted_at AS posted_at,
//                  c.name AS name
//            FROM categories c
//            JOIN posts_categories pc ON pc.id_category=c.id
//            JOIN posts p ON pc.id_post=p.id
//            WHERE id_post = :id_post
//        SQL
//        );
//
//        $stmt->bindParam(':id_post', $id);
//        $stmt->execute();
//        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
//
//
//        $postCategory = [];
//        $postCat = [];
//        foreach ($data as $post) {
//            $postCat = [
//                'id_post' => $post['id_post'],
//                'title' => $post['title'],
//                'slug' => $post['slug'],
//                'content' => $post['content'],
//                'thumbnail' => $post['thumbnail'],
//                'author' => $post['author'],
//                'posted_at' => $post['posted_at']
//            ];
//            $postCategory = [];
//            foreach ($data as $row) {
//                $postCategory['category'][] = [
//                    'id_category' => $row['id_category'],
//                    'name' => $row['name'],
//                ];
//            }
//        }
//         $newArray = array_merge($postCat, $postCategory);
//        return array_unique($newArray, SORT_REGULAR);
//    }
}
