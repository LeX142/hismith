<?php

namespace Tests\Feature\Console\Commands;

use App\Models\Image;
use App\Models\News;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImportFeedTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_import_feed_command()
    {
        Image::unsetEventDispatcher();

        $this->artisan('import:feed rbc-news');

        $this->assertDatabaseHas('news',['id'=>2]);

        $news = News::whereId(2)->with(['author','images'])->firstOrFail();

        $this->assertArrayHasKey('author',$news->toArray());
        $this->assertArrayHasKey('images',$news->toArray());


    }
}
