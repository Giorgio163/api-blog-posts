<?php

namespace Project4\Controller;

use OpenApi\Annotations as OA;
use Project4\Entity\Categories;

/**
 * DTO: Data Transfer Object
 *
 * @OA\Schema(schema="CategoryResponse")
 */
class CategoryResponse
{
    public function __construct(
        /**
         *
         *
         * @OA\Property(property="id", type="string", example="e8f69951-8a11-4a99-9129-09bfd24e9edc")
         */
        public readonly string $id,
        /**
         *
         *
         * @OA\Property(property="name", type="string", example="Example: Food")
         */
        public readonly string $name,
        /**
         *
         *
         * @OA\Property(property="description", type="string", example="It is about food")
         */
        public readonly string $description,
    ) {
    }

    public static function fromCategory(Categories $category): self
    {
        return new CategoryResponse(
            $category->id()->toString(),
            $category->name(),
            $category->description(),
        );
    }
}
