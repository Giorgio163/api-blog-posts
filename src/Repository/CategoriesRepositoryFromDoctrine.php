<?php

namespace Project4\Repository;

use DI\NotFoundException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use http\Exception\BadMessageException;
use Project4\Entity\Categories;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class CategoriesRepositoryFromDoctrine implements CategoriesRepository
{
    public function __construct(private EntityManager $entityManager)
    {
    }


    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function storeCategories(Categories $categories): void
    {
        $this->entityManager->persist($categories);
        $this->entityManager->flush();
    }

    public function findAllCategories(): array
    {
        return $this
            ->entityManager
            ->getRepository(Categories::class)
            ->findAll();
    }

    /**
     * @throws NotFoundException
     */
    public function findCategory(UuidInterface $id): Categories
    {
        $res = $this
            ->entityManager
            ->getRepository(Categories::class)
            ->findOneBy(['id' => $id]);
        if ($res === null) {
            throw new NotFoundException('Warning Category ID not found!');
        }else {
            return $res;
        }
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     * @throws NotFoundException
     */
    public function deleteCategory(UuidInterface $id): Categories
    {
        $category = $this->findCategory($id);

        $this->entityManager->remove($category);
        $this->entityManager->flush();
        return $category;

    }

    /**
     * @throws NotFoundException
     */
    public function updateCategory(UuidInterface $id, array $data): void
    {
        $this->findCategory($id);

        $category = $this->entityManager->createQueryBuilder();
        $query = $category->update(Categories::class, 'c')
            ->set('c.name', ':name')
            ->set('c.description', ':description')
            ->where('c.id = :id')
            ->setParameter('name', $data['name'])
            ->setParameter('description', $data['description'])
            ->setParameter('id', $id)
            ->getQuery();
        $query->execute();
    }

    /**
     * @throws NotFoundException
     */
    public function category($categoryId): Categories
    {
        $this->findCategory(Uuid::fromString($categoryId));

        return $this
            ->entityManager
            ->getRepository(Categories::class)
            ->findOneBy(['id' => $categoryId]);
    }
}
