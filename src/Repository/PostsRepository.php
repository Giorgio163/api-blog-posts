<?php

namespace Project4\Repository;

use Project4\Entity\Posts;
use Ramsey\Uuid\Uuid;

interface PostsRepository
{
    public function storePost(Posts $post): void;
    /** @return Posts[] */
    public function findAll(): array;
    public function find(Uuid $id): Posts;
}