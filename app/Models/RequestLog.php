<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model for log http::client request/response when grabbing rss feed.
 *
 * @property int $id
 * @property string $request_method
 * @property string $request_url
 * @property string $response_code
 * @property string $response_body
 * @property string $response_time
 * @property string $created_at
 * @property string $updated_at
 */
class RequestLog extends Model
{
    use HasFactory;

    protected $guarded = [];
}
