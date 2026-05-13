<?php

namespace App\Repositories\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;

interface ArticleRepositoryInterface
{
    /**
     * @param int $perPage
     * @param string $orderBy
     * @param string $direction
     */
    public function allArticlesPaginated(int $perPage, string $orderBy, string $direction): LengthAwarePaginator;
}
