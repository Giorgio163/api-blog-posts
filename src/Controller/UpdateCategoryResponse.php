<?php

namespace Project4\Controller;


use OpenApi\Annotations as OA;
use Project4\Entity\Categories;

/**
 * @OA\Schema(schema="UpdateCategoriesResponse")
 */
class UpdateCategoryResponse
{
    public function __construct(
        /** @OA\Property(property="title", type="string", example="Example: Food") */
        public readonly string $name,
        /** @OA\Property(property="slug", type="string", example="It is about food") */
        public readonly string $description,
    ){}

    public static function updateCategories(Categories $categories): self
    {
        return new updateCategoriesResponse(
            $categories->name(),
            $categories->description(),
        );
    }
}