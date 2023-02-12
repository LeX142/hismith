<?php

namespace Database\Seeders;

use App\Models\Feed;
use Illuminate\Database\Seeder;

class FeedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Feed::factory()->create([
            'url'        => 'http://static.feed.rbc.ru/rbc/logical/footer/news.rss',
            'identifier' => 'rbc-news',
        ]);
    }
}
