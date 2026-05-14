<?php

namespace App\Repositories;

use App\Models\Article;
use App\Repositories\Contracts\ArticleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ArticleRepository implements ArticleRepositoryInterface
{
    /**
     * @param int $perPage
     * @param string $orderBy
     * @param string $direction
     * @return LengthAwarePaginator
     */
    public function allPaginated(int $perPage = 5, string $orderBy = 'id', string $direction = 'asc'): LengthAwarePaginator
    {
        return Article::query()->orderBy($orderBy, $direction)->paginate($perPage);
    }

    /**
     * @param array $data
     * @return Article
     */
    public function create(array $data): Article
    {
        return Article::query()->create($data);
    }

    /**
     * @param Article $article
     * @param array $data
     * @return bool
     */
    public function update(Article $article, array $data): bool
    {
        return $article->update($data);
    }

    /**
     * @param Article $article
     * @return bool
     */
    public function delete(Article $article): bool
    {
        return $article->delete();
    }
}
