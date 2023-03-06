<?php

namespace Project4\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity, ORM\Table(name: 'Categories')]
class Categories
{
    #[ORM\ManyToMany(targetEntity: Posts::class, mappedBy: 'category')]
    #[ORM\JoinTable(name:"posts_categories")]
    private Collection $posts;

    public function __construct(
        #[ORM\Id, ORM\Column(type: 'uuid', unique: true)]
        private UuidInterface $id,
        #[ORM\Column(type: 'string', nullable: false)]
        private string $name,
        #[ORM\Column(type: 'string', nullable: false)]
        private string $description,
    ) {
        $this->posts = new ArrayCollection();
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

    /**
     * @return Collection<int, Posts>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPosts(Posts $posts): self
    {
        if (!$this->posts->contains($posts)) {
            $this->posts->add($posts);
            $posts->addCategory($this);
        }

        return $this;
    }

    public function removeCategory(Posts $posts): self
    {
        if ($this->posts->removeElement($posts)) {
            $posts->removeCategory($this);
        }

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id(),
            'name' => $this->name(),
            'description' => $this->description(),
        ];
    }
}
