<?php

namespace Project4\Repository;

use Project4\Entity\Categories;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

interface CategoriesRepository
{
    public function storeCategories(Categories $categories): void;
    /** @return Categories[] */
    public function findAllCategories(): array;
    public function findCategory(Uuid $id): Categories;
    public function deleteCategory(UuidInterface $id): string;
    public function updateCategory(UuidInterface $id, array $data): void;
}