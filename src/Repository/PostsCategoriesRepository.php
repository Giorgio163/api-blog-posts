<?php

namespace Project4\Repository;

use Project4\Entity\PostsCategories;

interface PostsCategoriesRepository
{
    public function storePostsCategories(PostsCategories $postsCategories): void;

    /**
     * @param $id
     * @return PostsCategories
     */
    public function find($id): PostsCategories;
}