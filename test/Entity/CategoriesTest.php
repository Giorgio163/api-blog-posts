<?php

namespace Test\Project4\Entity;

use PHPUnit\Framework\TestCase;
use Project4\Entity\Categories;
use Ramsey\Uuid\Uuid;

class CategoriesTest extends TestCase
{
    public function testPosts()
    {
        $categories = new Categories(Uuid::uuid4(), 'Food', 'its a food category');
        self::assertInstanceOf(Categories::class, $categories);
    }

    public function testCreatePosts()
    {
        $id = Uuid::uuid4();
        $name = 'Food';
        $description = 'its a food category';

        $categories = new Categories(
            $id,
            $name,
            $description,
        );

        self::assertEquals($id, $categories->id());
        self::assertEquals($name, $categories->name());
        self::assertEquals($description, $categories->description());
    }
}