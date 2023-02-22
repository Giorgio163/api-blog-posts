<?php

namespace Test\Project4\Entity;

use PHPUnit\Framework\TestCase;
use Project4\Entity\Posts;
use Ramsey\Uuid\Uuid;

class PostsTest extends TestCase
{
    public function testPosts()
    {
        $posts = new Posts(Uuid::uuid4(), 'PHP COURSE', 'php-course', 'its a test',
            'http://localhost:8888/images/63f5fd262a855.jpg', 'Giorgio Selmi');
        self::assertInstanceOf(Posts::class, $posts);
    }

    public function testCreatePosts()
    {
        $id = Uuid::uuid4();
        $title = 'PHP COURSE';
        $slug = 'php-course';
        $content = 'its a test';
        $thumbnail = 'http://localhost:8888/images/63f5fd262a855.jpg';
        $author = 'Giorgio Selmi';

        $post = new Posts(
            $id,
            $title,
            $slug,
            $content,
            $thumbnail,
            $author
        );

        self::assertEquals($id, $post->id());
        self::assertEquals($title, $post->title());
        self::assertEquals($slug, $post->slug());
        self::assertEquals($content, $post->content());
        self::assertEquals($thumbnail, $post->thumbnail());
        self::assertEquals($author, $post->author()
        );
    }
}