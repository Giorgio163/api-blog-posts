<?php

namespace Project4\Repository;

use DI\NotFoundException;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Laminas\Diactoros\Response\JsonResponse;
use Project4\Entity\Categories;
use Project4\Entity\Posts;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;


class PostsRepositoryFromDoctrine implements PostsRepository
{
    public function __construct(private EntityManager $entityManager)
    {
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
        $res = $this
            ->entityManager
            ->getRepository(Posts::class)
            ->findOneBy(['id' => $id]);

        if ($res === null) {
            throw new NotFoundException('Warning Post ID not found!');
        }else {
            return $res;
        }
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     * @throws \Exception
     */
    public function delete(UuidInterface $id): Posts
    {
        $post = $this->find($id);

        $this->entityManager->remove($post);
        $this->entityManager->flush();
        return $post;
    }

    /**
     * @throws ORMException
     * @throws NotFoundException
     * @throws \Exception
     */
    public function update(UuidInterface $id, array $data): void
    {
        $this->find($id);

        $post = $this->entityManager->createQueryBuilder();
            $query = $post->update(Posts::class, 'p')
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

    /**
     * @throws ORMException
     * @throws \Exception
     */
    public function store(Posts $posts): void
    {
        $this->entityManager->persist($posts);
        $this->entityManager->flush();
    }
}
