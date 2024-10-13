<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/KenOrm.php';
require_once __DIR__ . '/../src/DB.php';
require_once __DIR__ . '/../Use/Post.php';

use PHPUnit\Framework\TestCase;

class KenOrmsMethodTest extends TestCase
{
    protected function setUp(): void
    {
        DB::mysql();
    }

    public function testAll()
    {
        $results = Post::all();
        $this->assertIsArray($results);
    }

    public function testCreate()
    {
        $data = ['title' => 'Test Post', 'content' => 'Test Content']; // Adjust according to your model
        $post = Post::create($data);
        $this->assertNotNull($post->id);
    }

    public function testFind()
    {
        $post = Post::find(1); // Adjust ID as necessary
        $this->assertInstanceOf(Post::class, $post);
    }

    public function testSave()
    {
        $post = new Post();
        $post->title = 'New Post';
        $post->content = 'New Content';
        $post->save();
        $this->assertNotNull($post->id);
    }

    public function testDelete()
    {
        $post = Post::find(1); // Adjust ID as necessary
        $post->delete();
        $this->assertNull($post->id);
    }
}

