<?php

namespace Project4\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity, ORM\Table(name: 'Categories')]
class Categories
{
    public function __construct(
        #[ORM\Id, ORM\Column(type: 'uuid', unique: true)]
        private UuidInterface $id,
        #[ORM\Column(type: 'string', nullable: false)]
        private string $name,
        #[ORM\Column(type: 'string', nullable: false)]
        private string $description,
    ) {
    }

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
