<?php

namespace App\Http\Controllers;

use App\Helpers\Input;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Services\ArticleService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class ArticleController extends Controller implements HasMiddleware
{
    private ArticleService $articleService;

    /**
     * @param ArticleService $articleService
     */
    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * @return array
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view articles', only: ['index']),
            new Middleware('permission:edit articles', only: ['edit']),
            new Middleware('permission:create articles', only: ['create']),
            new Middleware('permission:delete articles', only: ['destroy']),
        ];
    }

    /**
     * @return Renderable
     */
    public function index(): Renderable
    {
        $articles = $this->articleService->getPaginatedArticles();

        return view('articles.list', compact('articles'));
    }

    /**
     * @return Renderable
     */
    public function create(): Renderable
    {
        return view('articles.create');
    }

    /**
     * @param StoreArticleRequest $request
     * @return RedirectResponse
     */
    public function store(StoreArticleRequest $request): RedirectResponse
    {
        $this->articleService->createArticle([
            'name' => Input::filter($request->input('name')),
            'author' => Input::filter($request->input('author')),
            'text' => Input::filter($request->input('text')),
        ]);

        return redirect()->route('articles.index')->with('success', 'Article created successfully.');
    }

    /**
     * @param Article $article
     * @return Renderable
     */
    public function show(Article $article): Renderable
    {
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article): Renderable
    {
        return view('articles.edit', compact('article'));
    }

    /**
     * @param UpdateArticleRequest $request
     * @param Article $article
     * @return RedirectResponse
     */
    public function update(UpdateArticleRequest $request, Article $article): RedirectResponse
    {
        $this->articleService->updateArticle($article, [
            'name' => $request->input('name'),
            'author' => $request->input('author'),
            'text' => $request->input('text'),
        ]);

        return redirect()->route('articles.index')->with('success', 'Article updated successfully');
    }

    /**
     * @param Article $article
     * @return JsonResponse
     */
    public function destroy(Article $article): JsonResponse
    {
        $this->articleService->deleteArticle($article);

        session()->flash('success', 'Article deleted successfully');

        return response()->json([
            'success' => true,
        ]);
    }
}
