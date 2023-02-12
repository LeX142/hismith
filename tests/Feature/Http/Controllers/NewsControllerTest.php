<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Image;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsControllerTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();

        Image::unsetEventDispatcher();
        $this->artisan('import:feed rbc-news');

    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_valid_request()
    {
        $response = $this->get('/api/news');

        $response->assertStatus(200);

        $response->assertJsonIsArray('data');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_valid_request_fields()
    {
        $response = $this->get('/api/news/?fields=id,title');

        $response->assertStatus(200);

        $data = $response->json('data');

        $this->assertIsArray($data);

    }

}
