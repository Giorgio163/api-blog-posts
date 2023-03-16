<?php

namespace Project4\Controller;

use Doctrine\Common\Collections\Collection;
use OpenApi\Annotations as OA;
use Project4\Entity\Posts;

/**
 * DTO: Data Transfer Object
 *
 * @OA\Schema(schema="PostResponse")
 */

class PostsResponse
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
         * @OA\Property(property="postedAt", type="string", example="2023-01-20 13:56:00")
         */
        public readonly ?string $postedAt,
        public readonly Collection $category,
    ) {
    }

}
