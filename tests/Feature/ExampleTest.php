<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Image;
use App\Models\News;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_database()
    {
        $this->assertDatabaseHas('feeds', ['identifier' => 'rbc-news']);

        $author = Author::create(['name' => 'test author', 'feed_id' => 1]);
        $this->assertDatabaseHas('authors', ['name' => 'test author']);

        $news = News::create([
            'author_id'    => $author->id,
            'title'        => 'test news',
            'description'  => 'test description',
            'source_url'   => 'test url',
            'published_at' => Carbon::now(),
        ]);

        $this->assertDatabaseHas('news', ['title' => 'test news', 'author_id' => $author->id]);

        Image::unsetEventDispatcher();
        $image = Image::create([
            'source_url' => 'test image',
            'filename'   => 'test filename',
        ]);

        $news->images()->attach($image);

        $this->assertDatabaseHas('news_image', [
            'image_id' => $image->id,
            'news_id'  => $news->id,
        ]);
    }
}
