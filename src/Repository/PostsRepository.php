<?php

namespace Project4\Repository;

use Project4\Entity\Posts;

interface PostsRepository
{
    public function storePost(Posts $posts): void;
}