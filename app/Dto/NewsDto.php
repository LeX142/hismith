<?php

namespace App\Dto;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\DataCollection;
use OpenApi\Attributes as OA;
#[OA\Schema]
class NewsDto extends \Spatie\LaravelData\Data
{
    #[OA\Property]
    public ?int $id;
    #[OA\Property]
    #[MapInputName('author.name')]
    public ?string $author;
    #[OA\Property]
    public ?string $title;
    #[OA\Property]
    public ?string $description;

    #[OA\Property]
    public ?string $published_at;

    #[OA\Property(type: 'array', items: new OA\Items(ref: '#/components/schemas/ImageDto'))]
    #[DataCollectionOf(ImageDto::class)]
    public ?DataCollection $images;

}
