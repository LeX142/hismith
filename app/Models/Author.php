<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Author of rss news.
 *
 * @property int $id
 * @property string $name
 * @property int $feed_id
 * @property string $created_at
 * @property string $updated_at
 */
class Author extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function feed()
    {
        return $this->belongsTo(Feed::class);
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }
}
