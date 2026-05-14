<?php

namespace App\Services;

use App\Models\Article;
use App\Repositories\Contracts\ArticleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ArticleService
{
    private ArticleRepositoryInterface $articleRepository;

    /**
     * @param ArticleRepositoryInterface $articleRepository
     */
    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginatedArticles(int $perPage = 5): LengthAwarePaginator
    {
        return $this->articleRepository->allPaginated($perPage);
    }

    /**
     * @param array $data
     * @return Article
     */
    public function createArticle(array $data): Article
    {
        return $this->articleRepository->create($data);
    }

    /**
     * @param Article $article
     * @param array $data
     * @return bool
     */
    public function updateArticle(Article $article, array $data): bool
    {
        return $this->articleRepository->update($article, $data);
    }

    /**
     * @param Article $article
     * @return bool
     */
    public function deleteArticle(Article $article): bool
    {
        return $this->articleRepository->delete($article);
    }
}
