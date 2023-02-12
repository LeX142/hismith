<?php

namespace App\Console\Commands;

use App\Models\Feed;
use App\Services\FeedService;
use Illuminate\Console\Command;

class ImportFeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:feed {feed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import news from RBC rss feed.';

    /**
     * Execute the console command.
     *
     * @return int
     * @throws \Exception
     */
    public function handle()
    {
        /** @var Feed $feed */
        $feed = Feed::whereIdentifier($this->argument('feed'))->first();
        if (!$feed) {
            $this->error('Invalid feed identifier.');
            return Command::INVALID;
        }

        FeedService::parse($feed);

        return Command::SUCCESS;
    }
}
