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


    /** @return Posts[]
     * @throws \Exception
     */
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

    public function delete(UuidInterface $id): string
    {
        $stm = $this->pdo->prepare('DELETE FROM posts WHERE id=?');
        $stm->execute([$id->toString()]);
        return $id;
    }

    public function update(UuidInterface $id, array $data): void
    {
        $stm = $this->pdo->prepare(<<<SQL
                UPDATE posts SET
                    title=:title,
                    slug=:slug,
                    content=:content,
                    thumbnail=:thumbnail,
                    author=:author,
                    posted_at=:posted_at
                    WHERE id=:id
                SQL);

        $stm->bindParam(':id', $id);
        $stm->bindParam(':title', $data['title']);
        $stm->bindParam(':slug', $data['slug']);
        $stm->bindParam(':content', $data['content']);
        $stm->bindParam(':thumbnail', $data['thumbnail']);
        $stm->bindParam(':author', $data['author']);
        $stm->bindParam(':posted_at', $data['posted_at']);

        $stm->execute();
    }

    /**
     * @throws \Exception
     */
    public function findBySlug($slug): array
    {
        $stm = $this->pdo->prepare('SELECT * FROM posts WHERE slug=?');
        $stm->execute([$slug]);
        $data = [];
        foreach ($stm as $postSlug){
            $data [] = Posts::populate($postSlug);
        }

        return $data;
    }
}

