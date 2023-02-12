<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Feed. Every item is an url of feed for parse.
 *
 * @property int $id
 * @property string $identifier
 * @property string $url
 * @property string $created_at
 * @property string $updated_at
 */
class Feed extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function authors()
    {
        return $this->hasMany(Author::class);
    }
}
