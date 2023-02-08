<?php

namespace Project4\Controller;


use OpenApi\Annotations as OA;
use Project4\Entity\Posts;

/**
 * @OA\Schema(schema="UpdateResponse")
 */

class UpdateResponse
{
    public function __construct(
        /** @OA\Property(property="title", type="string", example="2023 review"), */
        public readonly string $title,
        /** @OA\Property(property="slug", type="string", example="Example"), */
        public readonly string $slug,
        /** @OA\Property(property="content", type="string", example="A review of the month"), */
        public readonly string $content,
        /** @OA\Property(property="thumbnail", type="string", example="photo from Base64Encoder"), */
        public readonly string $thumbnail,
        /** @OA\Property(property="author", type="string", example="Giorgio Selmi"), */
        public readonly string $author,
        /** @OA\Property(property="posted_at", type="string", example="2023-02-07 10:16:45") */
        public readonly string $posted_at,
    ) {
    }
    public static function update(Posts $posts): self
    {
        return new updateResponse(
            $posts->title(),
            $posts->slug(),
            $posts->content(),
            $posts->thumbnail(),
            $posts->author(),
            $posts->posted_at()->format('Y-m-d H:i:s'),
        );
    }
}