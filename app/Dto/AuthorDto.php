<?php

namespace App\Dto;

use OpenApi\Attributes as OA;

#[OA\Schema]
class AuthorDto extends \Spatie\LaravelData\Data
{
    #[OA\Property]
    public ?int $id;
    #[OA\Property]
    public ?string $name;
    #[OA\Property]
    public ?FeedDto $feed;
}
