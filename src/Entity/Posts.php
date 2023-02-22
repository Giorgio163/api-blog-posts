<?php

namespace Project4\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;


#[ORM\Entity, ORM\Table(name: 'Posts')]
class Posts
{
    #[ORM\Column(name: 'posted_at', type: 'datetimetz_immutable', nullable: false)]
    private DateTimeImmutable  $posted_at;

    public function __construct(
        #[ORM\Id, ORM\Column(type: 'uuid', unique: true)]
        private UuidInterface $id,
        #[ORM\Column(type: 'string', nullable: false)]
        private string $title,
        #[ORM\Column(type: 'string', nullable: false)]
        private string $slug,
        #[ORM\Column(type: 'string', nullable: false)]
        private string $content,
        #[ORM\Column(type: 'string', nullable: false)]
        private string $thumbnail,
        #[ORM\Column(type: 'string', nullable: false)]
        private string $author,

    ) {
        $this->posted_at = new DateTimeImmutable('now');
    }

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
