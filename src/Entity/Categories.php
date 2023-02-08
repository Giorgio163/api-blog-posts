<?php

namespace Project4\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Categories
{
    public function __construct(
        private UuidInterface $id,
        private string $name,
        private string $description,
    ){}

    public static function populate(array $data): self
    {
        return new self(
            Uuid::fromString($data['id']),
            $data['name'],
            $data['description'],
        );
    }
    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }
}