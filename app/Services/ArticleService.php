<?php

namespace App\Services;

use App\Repositories\Contracts\ArticleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ArticleService
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @param int $perPage
     * @param string $orderBy
     * @param string $direction
     * @return LengthAwarePaginator
     */
    public function allArticlesPaginated(int $perPage = 5, string $orderBy = 'id', string $direction = 'asc'): LengthAwarePaginator
    {
        return $this->articleRepository->allArticlesPaginated($perPage, $orderBy, $direction);
    }
}
