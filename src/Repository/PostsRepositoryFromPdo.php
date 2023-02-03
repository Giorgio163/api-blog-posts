<?php

namespace Project4\Repository;

use PDO;
use Project4\Entity\Posts;
use Ramsey\Uuid\UuidInterface;

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
        foreach ($result as $postsData) {
            $posts [] = Posts::populate($postsData);
        }
        return $posts;
    }

    /**
     * @throws \Exception
     */
    public function find(UuidInterface $id): Posts
    {
        $stm = $this->pdo->prepare('SELECT * FROM posts WHERE id=?');
        $stm->execute([$id->toString()]);
        $data = $stm->fetch(PDO::FETCH_ASSOC);
        return Posts::populate($data);
    }
}