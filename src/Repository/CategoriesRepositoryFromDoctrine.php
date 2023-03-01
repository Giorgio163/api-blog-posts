<?php

namespace Project4\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Project4\Entity\Categories;
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

    public function findCategory(UuidInterface $id): Categories
    {
        return $this
            ->entityManager
            ->getRepository(Categories::class)
            ->findOneBy(['id' => $id]);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function deleteCategory(UuidInterface $id): string
    {
        $category = $this->entityManager->getReference('Project4\Entity\Categories', $id);
        $this->entityManager->remove($category);
        $this->entityManager->flush();
        return $id;
    }

    public function updateCategory(UuidInterface $id, array $data): void
    {
        $category = $this->entityManager->createQueryBuilder();
        $query = $category->update('Project4\Entity\Categories', 'c')
            ->set('c.name', ':name')
            ->set('c.description', ':description')
            ->where('c.id = :id')
            ->setParameter('name', $data['name'])
            ->setParameter('description', $data['description'])
            ->setParameter('id', $id)
            ->getQuery();
        $query->execute();
    }

    public function category($categoryId): Categories
    {
        return $this
            ->entityManager
            ->getRepository(Categories::class)
            ->findOneBy(['id' => $categoryId]);
    }
}
