<?php

namespace App\Dto;

use OpenApi\Attributes as OA;
#[OA\Schema]
class FeedDto extends \Spatie\LaravelData\Data
{
    #[OA\Property]
    public ?int $id;
    #[OA\Property]
    public ?string $identifier;
    #[OA\Property]
    public ?string $url;
}
