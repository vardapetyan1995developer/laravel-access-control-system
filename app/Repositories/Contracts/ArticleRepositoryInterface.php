<?php

namespace App\Repositories\Contracts;

use App\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ArticleRepositoryInterface
{
    /**
     * @param int $perPage
     * @param string $orderBy
     * @param string $direction
     * @return LengthAwarePaginator
     */
    public function allPaginated(int $perPage = 5, string $orderBy = 'id', string $direction = 'asc'): LengthAwarePaginator;

    /**
     * @param array $data
     * @return Article
     */
    public function create(array $data): Article;

    /**
     * @param Article $article
     * @param array $data
     * @return bool
     */
    public function update(Article $article, array $data): bool;

    /**
     * @param Article $article
     * @return bool
     */
    public function delete(Article $article): bool;
}
