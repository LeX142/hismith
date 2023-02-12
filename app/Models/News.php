<?php

namespace App\Models;

use App\Dto\ImageDto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\DataCollection;

/**
 * Model for parsed news from rss feed.
 *
 * @property int $id
 * @property int $author_id
 * @property string $title
 * @property string $description
 * @property string $source_url
 * @property string $published_at
 * @property string $created_at
 * @property string $updated_at
 * @property-read null|array<int,Image> $images
 */
class News extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'images' => DataCollection::class.':'.ImageDto::class,
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, 'news_image', 'news_id', 'image_id');
    }
}
