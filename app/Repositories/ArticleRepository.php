<?php

namespace App\Repositories;

use App\Models\Article;
use App\Repositories\Contracts\ArticleRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleRepository implements ArticleRepositoryInterface
{
    /**
     * @param int $perPage
     * @param string $orderBy
     * @param string $direction
     * @return LengthAwarePaginator
     */
    public function allArticlesPaginated(int $perPage, string $orderBy, string $direction): LengthAwarePaginator
    {
        return Article::query()->orderBy($orderBy)->paginate($perPage);
    }
}
