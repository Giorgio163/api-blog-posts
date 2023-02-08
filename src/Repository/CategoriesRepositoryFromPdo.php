<?php

namespace Project4\Repository;

use PDO;
use Project4\Entity\Categories;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class CategoriesRepositoryFromPdo implements CategoriesRepository
{
    public function __construct(private \PDO $pdo)
    {
    }

    public function storeCategories(Categories $categories): void
    {
        $stm = $this->pdo->prepare('INSERT INTO categories VALUES (?,?,?)');

        $stm->execute([
            $categories->id()->toString(),
            $categories->name(),
            $categories->description()
        ]);
    }

    public function findAllCategories(): array
    {
        $result = $this->pdo->query('SELECT * FROM categories')
            ->fetchAll(PDO::FETCH_ASSOC);
        $categories = [];
        foreach ($result as $categoriesData) {
            $categories [] = Categories::populate($categoriesData);
        }
        return $categories;
    }

    public function findCategory(UuidInterface $id): Categories
    {
        $stm = $this->pdo->prepare('SELECT * FROM categories WHERE id=?');
        $stm->execute([$id->toString()]);
        $data = $stm->fetch(PDO::FETCH_ASSOC);
        return Categories::populate($data);
    }

    public function deleteCategory(UuidInterface $id): string
    {
        $stm = $this->pdo->prepare('DELETE FROM categories WHERE id=?');
        $stm->execute([$id->toString()]);
        return $id;
    }

    public function updateCategory(UuidInterface $id, array $data): void
    {
        $stm = $this->pdo->prepare(<<<SQL
                UPDATE categories SET
                    name=:name,
                    description=:description
                    WHERE id=:id
                SQL);

        $stm->bindParam(':id', $id);
        $stm->bindParam(':name', $data['name']);
        $stm->bindParam(':description', $data['description']);

        $stm->execute();
    }
}