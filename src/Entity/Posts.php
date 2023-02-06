<?php

namespace Project4\Entity;

use DateTimeImmutable;
use OpenApi\Annotations as OA;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @OA\Schema(schema="Post", required={"title"})
 */

class Posts
{

    public function __construct(
        /** @OA\Property(example="id") */
        private UuidInterface $id,
        /** @OA\Property(example="title") */
        private string $title,
        /** @OA\Property(example="slug") */
        private string $slug,
        /** @OA\Property(example="content") */
        private string $content,
        /** @OA\Property(example="thumbnail") */
        private string $thumbnail,
        /** @OA\Property(example="author") */
        private string $author,
        /** @OA\Property(example="posted_at") */
        private  $posted_at,
    ){}

    /**
     * @throws \Exception
     */
    public static function populate(array $data): self
    {
        return new self(
            Uuid::fromString($data['id']),
            $data['title'],
            $data['slug'],
            $data['content'],
            $data['thumbnail'],
            $data['author'],
            $data['posted_at'],
        );
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function thumbnail(): string
    {
        return $this->thumbnail;
    }

    public function author(): string
    {
        return $this->author;
    }

    public function posted_at(): DateTimeImmutable
    {
        if (is_string($this->posted_at)) {
            return new DateTimeImmutable('now');
        }
        return $this->posted_at;
    }
}
