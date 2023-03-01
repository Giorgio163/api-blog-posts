<?php
//
//namespace Project4\Entity;
//
//use Doctrine\ORM\Mapping as ORM;
//use Ramsey\Uuid\Uuid;
//use Ramsey\Uuid\UuidInterface;
//
//class TOBEDELETEDPostsCategories
//{
//    private string $title;
//    private string $slug;
//    private string $content;
//    private string $thumbnail;
//    private string $author;
//        private  $posted_at;
//    private string $name;
//
//    public function __construct(
//
//        private UuidInterface $postsId,
//
//        private UuidInterface $categoriesId,
//        string $title = '',
//        string $slug = '',
//        string $content = '',
//        string $thumbnail = '',
//        string $author = '',
//        string $posted_at = '',
//        string $name = '',
//    ) {
//            $this->title = $title;
//            $this->slug = $slug;
//            $this->content = $content;
//            $this->thumbnail = $thumbnail;
//            $this->author = $author;
//            $this->posted_at = $posted_at;
//            $this->name = $name;
//    }
//
//    public static function populate(array $data): self
//    {
//
//        return new self(
//            Uuid::fromString($data['id_post']),
//            $data['title'],
//            $data['slug'],
//            $data['content'],
//            $data['thumbnail'],
//            $data['author'],
//            $data['posted_at'],
//            Uuid::fromString($data['id_category']),
//            $data['name']
//        );
//    }
//
//    public function categoriesId(): UuidInterface
//    {
//        return $this->categoriesId;
//    }
//
//    public function postsId(): UuidInterface
//    {
//        return $this->postsId;
//    }
//
//    public function title(): string
//    {
//        return $this->title;
//    }
//
//    public function slug(): string
//    {
//        return $this->slug;
//    }
//
//    public function content(): string
//    {
//        return $this->content;
//    }
//
//    public function thumbnail(): string
//    {
//        return $this->thumbnail;
//    }
//
//    public function author(): string
//    {
//        return $this->author;
//    }
//
//    public function posted_at(): string
//    {
//        return $this->posted_at;
//    }
//
//    public function name(): string
//    {
//        return $this->name;
//    }
//}
