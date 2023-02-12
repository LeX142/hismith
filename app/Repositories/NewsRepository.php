<?php

namespace App\Repositories;

use App\Models\News;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class NewsRepository
{
    /**
     * Get list of news from db with filters in query string on request.
     *
     * @return QueryBuilder
     */
    public function getList()
    {
        return QueryBuilder::for(News::class)
            ->allowedFields([
                'id','title','description','published_at','author_id'
            ])
            ->allowedIncludes([
                AllowedInclude::relationship('author'),
                AllowedInclude::relationship('images'),
            ])
            ->allowedSorts([
                AllowedSort::field('published_at')
            ])
            ->with('author')
            ->defaultSort('-published_at');
    }

}
