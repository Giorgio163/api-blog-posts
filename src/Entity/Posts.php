<?php

namespace Project4\Entity;

use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;

class Posts
{
    public function __construct(
        private UuidInterface $id,
        private string $title,
        private string $slug,
        private string $content,
        private string $thumbnail,
        private string $author,
        private  $posted_at
    ){}

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
