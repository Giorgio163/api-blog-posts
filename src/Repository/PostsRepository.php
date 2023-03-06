<?php

namespace Project4\Repository;

use Doctrine\Common\Collections\Collection;
use Project4\Entity\Posts;
use Ramsey\Uuid\UuidInterface;

interface PostsRepository
{
    public function store(Posts $posts): void;
    /**
     * 
     *
     * @return Posts[] 
     */
    public function findAll(): array;
    public function find(UuidInterface $id): Posts;
    public function delete(UuidInterface $id): Posts;
    public function update(UuidInterface $id, array $data): void;
    public function findBySlug($slug): array;
}
