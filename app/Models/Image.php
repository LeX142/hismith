<?php

namespace App\Models;

use App\Events\ImageCreatingEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model for downloaded image from rss feed.
 *
 * @property int $id
 * @property string $source_url
 * @property string $filename
 * @property string $created_at
 * @property string $updated_at
 */
class Image extends Model
{
    use HasFactory;

    protected $dispatchesEvents =[
        'creating'=>ImageCreatingEvent::class
    ];

    protected $guarded=[];

}
