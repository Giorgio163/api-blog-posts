<?php

namespace Project4\Repository;

use PDO;
use Project4\Entity\Posts;

class PostsRepositoryFromPdo implements PostsRepository
{
    public function __construct(private \PDO $pdo)
    {

    }

    public function storePost(Posts $post): void
    {
       $stm = $this->pdo->prepare('INSERT INTO posts VALUES (?,?,?,?,?,?,?)');
       $stm->execute([
           $post->id()->toString(),
           $post->title(),
           $post->slug(),
           $post->content(),
           $post->thumbnail(),
           $post->author(),
           $post->posted_at()->format('Y-m-d H:i:s')
       ]);
    }

    /** @return Posts[] */
    public function findAll(): array
    {
        $result = $this->pdo->query('SELECT * FROM posts')
            ->fetchAll(PDO::FETCH_ASSOC);
        $posts = [];
        foreach ($result as $postsData){
            $posts [] = Posts::populate($postsData);
        }
        return $posts;
    }
}
