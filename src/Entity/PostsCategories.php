<?php

namespace Project4\Entity;

use Ramsey\Uuid\Uuid;

class PostsCategories
{
    public function __construct(
        private string $postsId,
        private string $title,
        private string $slug,
        private string $content,
        private string $thumbnail,
        private string $author,
        private string $posted_at,
        private string $categoriesId,
        private string $name
    ){}

    public static function populate(array $data): self
    {
        return new self(
            Uuid::fromString($data['id_post']),
            $data['title'],
            $data['slug'],
            $data['content'],
            $data['thumbnail'],
            $data['author'],
            $data['posted_at'],
            Uuid::fromString($data['id_category']),
            $data['name'],
        );
    }

    public function categoriesId(): string
    {
       return $this->categoriesId;
    }

    public function postsId(): string
    {
        return $this->postsId;
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

    public function posted_at(): string
    {
        return $this->posted_at;
    }

    public function name(): string
    {
        return $this->name;
    }
}