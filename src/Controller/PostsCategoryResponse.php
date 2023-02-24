<?php

namespace Project4\Controller;

use OpenApi\Annotations as OA;
use Project4\Entity\PostsCategories;

/**
 * DTO: Data Transfer Object
 *
 * @OA\Schema(schema="PostsCategoryResponse")
 */

class PostsCategoryResponse
{
    public function __construct(
        /**
         * 
         *
         * @OA\Property(property="id_post", type="string", example="e8f69951-8a11-4a99-9129-09bfd24e9edc") 
         */
        public readonly string $postsId,
        /**
         * 
         *
         * @OA\Property(property="title", type="string", example="PHP COURSE") 
         */
        public readonly string $title,
        /**
         * 
         *
         * @OA\Property(property="slug", type="string", example="php-course") 
         */
        public readonly string $slug,
        /**
         * 
         *
         * @OA\Property(property="content", type="string", example="test") 
         */
        public readonly string $content,
        /**
         * 
         *
         * @OA\Property(property="thumbnail", type="string", example="photo from Base64Encoder") 
         */
        public readonly string $thumbnail,
        /**
         * 
         *
         * @OA\Property(property="author", type="string", example="Giorgio Selmi") 
         */
        public readonly string $author,
        /**
         * 
         *
         * @OA\Property(property="posted_at", type="string", example="2023-01-20 13:56:00") 
         */
        public readonly ?string  $posted_at,
        /**
         * 
         *
         * @OA\Property(property="id_category", type="string", example="e8f69951-8a11-4a99-9129-09bfd24e9edc") 
         */
        public readonly string $categoriesId,
        /**
         * 
         *
         * @OA\Property(property="name", type="string", example="Example: Food") 
         */
        public readonly string $name,
    ) {
    }
}
