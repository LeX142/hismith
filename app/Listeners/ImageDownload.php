<?php

namespace App\Listeners;

use App\Events\ImageCreatingEvent;
use Illuminate\Support\Facades\Storage;

/**
 * Download image to storage.
 */
class ImageDownload
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event for download image and put it to storage.
     *
     * @param  ImageCreatingEvent  $event
     * @return void
     */
    public function handle(ImageCreatingEvent $event)
    {
        $content = file_get_contents($event->image->source_url);
        Storage::put($event->image->filename, $content);
    }
}
