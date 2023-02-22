<?php

namespace Project4\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use PDO;
use Project4\Entity\Posts;
use Ramsey\Uuid\UuidInterface;

class PostsRepositoryFromDoctrine implements PostsRepository
{
    public function __construct(private EntityManager $entityManager)
    {
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function storePost(Posts $post): void
    {
        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }


    /**
     * 
     *
     * @return Posts[]
     * @throws \Exception
     */
    public function findAll(): array
    {
        return $this
            ->entityManager
            ->getRepository(Posts::class)
            ->findAll();
    }

    /**
     * @throws \Exception
     */
    public function find(UuidInterface $id): Posts
    {
        return $this
            ->entityManager
            ->getRepository(Posts::class)
            ->findOneBy(['id' => $id]);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function delete(UuidInterface $id): string
    {
        $post = $this->entityManager->getReference('Project4\Entity\Posts', $id);
        $this->entityManager->remove($post);
        $this->entityManager->flush();
        return $id;
    }

    /**
     * @throws ORMException
     */
    public function update(UuidInterface $id, array $data): void
    {
        $post = $this->entityManager->createQueryBuilder();
        $query = $post->update('Project4\Entity\Posts', 'p')
            ->set('p.title', ':title')
            ->set('p.slug', ':slug')
            ->set('p.content', ':content')
            ->set('p.thumbnail', ':thumbnail')
            ->set('p.author', ':author')
            ->set('p.posted_at', ':posted_at')
            ->where('p.id = :id')
            ->setParameter('title', $data['title'])
            ->setParameter('slug', $data['slug'])
            ->setParameter('content', $data['content'])
            ->setParameter('thumbnail', $data['thumbnail'])
            ->setParameter('author', $data['author'])
            ->setParameter('posted_at', $data['posted_at'])
            ->setParameter('id', $id)
            ->getQuery();
        $query->execute();
    }

    /**
     * @throws \Exception
     */
    public function findBySlug($slug): array
    {
        return $this
            ->entityManager
            ->getRepository(Posts::class)
            ->findBy(['slug' => $slug]);
    }
}
