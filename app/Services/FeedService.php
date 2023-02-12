<?php

namespace App\Services;

use App\Models\Author;
use App\Models\Feed;
use App\Models\Image;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use SimpleXMLElement;

/**
 * Service for parse rss feed.
 */
class FeedService
{
    /**
     * Parse feed, download
     *
     * @param  Feed  $feed
     * @return true
     */
    public static function parse(Feed $feed)
    {
        $response = Http::get($feed->url);
        $xmlData = simplexml_load_string($response->body());
        if (!$xmlData) {
            echo "Failed loading XML: ";
            foreach (libxml_get_errors() as $error) {
                echo "<br>", $error->message;
            }
        }
        foreach ($xmlData->channel->item as $item) {
            $author = self::authorNews($item, $feed);
            $news = self::newsFromItem($item, $author);
            self::imageFromItem($item, $news);
        }
        return true;
    }

    /**
     * Return author model, if author field present in news.
     *
     * @param  SimpleXMLElement  $item
     * @param  Feed  $feed
     * @return Author|null
     */
    public static function authorNews(SimpleXMLElement $item, Feed $feed): ?Author
    {
        if ($item->author) {
            /** @var Author $author */
            $author = Author::firstOrCreate(['name' => $item->author, 'feed_id' => $feed->id]);
        }
        return $author ?? null;
    }

    /**
     * Find grabbed news by item->source_url or create new.
     *
     * @param  SimpleXMLElement  $item
     * @param  Author|null  $author
     * @return mixed
     */
    public static function newsFromItem(SimpleXMLElement $item, ?Author $author)
    {
        return News::where('source_url', trim($item->link))->firstOr(function () use ($item, $author) {
            return News::create([
                'author_id'    => $author->id ?? null,
                'title'        => trim($item->title),
                'description'  => trim($item->description),
                'source_url'   => trim($item->link),
                'published_at' => Carbon::parse($item->pubDate),
            ]);
        });
    }

    /**
     * Parsing enclosure from news and download only images if its present.
     * Attach created image to specific news.
     *
     * @param  SimpleXMLElement  $item
     * @param  News  $news
     * @return void
     */
    public static function imageFromItem(SimpleXMLElement $item, News $news): void
    {
        foreach ($item->enclosure as $imageLink) {
            // create item and download file only for link with mime-type as image
            if (str_starts_with((string)$imageLink->attributes()->type, 'image/')) {
                $url = (string)$imageLink->attributes()->url;
                $downloadedFilename = self::getImageFilename($url);

                $image = Image::where(['source_url' => $url, 'filename' => $downloadedFilename])
                    ->firstOr(
                        function () use ($news, $url, $downloadedFilename) {
                            return Image::create(
                                [
                                    'source_url' => $url,
                                    'filename'   => $downloadedFilename,
                                ]
                            );
                        }
                    );

                $news->images()->syncWithoutDetaching($image);
            }
        }
    }

    /**
     * Get formatted filename from source_url.
     *
     * @param  string  $url
     * @return string
     */
    public static function getImageFilename(string $url): string
    {
        $filename = md5($url);
        $extestion = pathinfo(basename($url), PATHINFO_EXTENSION);
        $path = substr($filename, 0, 5);
        return config('app.image_path').DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR.$filename.'.'.$extestion;
    }
}
