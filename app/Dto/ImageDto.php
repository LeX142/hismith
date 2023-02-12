<?php

namespace App\Dto;

use OpenApi\Attributes as OA;
#[OA\Schema]
class ImageDto extends \Spatie\LaravelData\Data
{
    #[OA\Property]
    public ?string $filename;
}
