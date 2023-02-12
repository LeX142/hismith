<?php

namespace App\Http\Controllers;

use App\Dto\NewsDto;
use App\Repositories\NewsRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Request;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'LaravelLengthAwarePaginator',
    properties: [
        new OA\Property(property: 'current_page',type: 'integer'),
        new OA\Property(property: 'first_page_url',type: 'string', format: 'url'),
        new OA\Property(property: 'from',type: 'integer'),
        new OA\Property(property: 'last_page',type: 'integer'),
        new OA\Property(property: 'last_page_url',type: 'string', format: 'url'),
        new OA\Property(property: 'next_page_url',type: 'string', format: 'url'),
        new OA\Property(property: 'path',type: 'string', format: 'url'),
        new OA\Property(property: 'per_page',type: 'integer'),
        new OA\Property(property: 'prev_page_url',type: 'string', format: 'url'),
        new OA\Property(property: 'to',type: 'integer'),
        new OA\Property(property: 'total',type: 'integer'),
    ]
)]
class NewsController extends Controller
{
    public function __construct(
        private NewsRepository $newsRepository
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    #[OA\Get(
        path       : '/api/news',
        operationId: 'getNewsList',
        tags       : ['News'],
        parameters : [
            new OA\Parameter(
                name  : 'fields[news][]',
                in    : 'query',
                schema: new OA\Schema(
                    type : 'array',
                    items: new OA\Items(
                        type: 'string',
                        enum: ['id', 'title', 'description', 'published_at', 'author_id']
                    )
                )
            ),
            new OA\Parameter(
                name  : 'include',
                in    : 'query',
                schema: new OA\Schema(type: 'string', enum: ['images'])
            ),
            new OA\Parameter(
                name  : 'sort',
                in    : 'query',
                schema: new OA\Schema(type: 'string', enum: ['-published_at','published_at'])
            ),
            new OA\Parameter(name: 'page', in: 'query', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'per_page', in: 'query', schema: new OA\Schema(type: 'integer')),
        ],
        responses  : [
            new OA\Response(
                response   : 200,
                description: 'getNewsListResponse',
                content    : new OA\JsonContent(allOf: [
                    new OA\Schema(ref: '#/components/schemas/LaravelLengthAwarePaginator'),
                    new OA\Schema(properties: [
                        new OA\Property(property: 'data',type: 'array', items: new OA\Items(ref: '#/components/schemas/NewsDto')),
                    ])
                ])
            ),
        ]
    )]
    public function index(Request $request)
    {
        $query = $this->newsRepository->getList();
        /** @var LengthAwarePaginator $paginate */
        $paginate = $query->paginate($request->per_page ?? 10);
        $paginate->setCollection($paginate->getCollection()->map(fn($item) => NewsDto::from($item)));

        return response()->json($paginate);
    }

}
