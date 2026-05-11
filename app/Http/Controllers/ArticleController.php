<?php

namespace App\Http\Controllers;

use App\Helpers\Input;
use App\Models\Article;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * @return Renderable
     */
    public function index(): Renderable
    {
        $articles = Article::query()->orderByDesc('created_at')->paginate(5);

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
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:articles', 'min:3'],
            'author' => ['required', 'min:3', 'string'],
            'text' => ['nullable', 'min:3', 'string'],
        ]);

        if ($validator->passes())
        {
            Article::query()->create([
                'name' => Input::filter($request->input('name')),
                'author' => Input::filter($request->input('author')),
                'text' => Input::filter($request->input('text')),
            ]);

            return redirect()->route('articles.index')->with('success', 'Article created successfully.');
        }
        else
        {
            return redirect()->route('articles.create')->withInput()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article): Renderable
    {
        return view('articles.edit', compact('article'));
    }

    /**
     * @param Request $request
     * @param Article $article
     * @return RedirectResponse
     */
    public function update(Request $request, Article $article): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:articles,name,'. $article->id . ',id',
            'author' => ['required', 'min:3', 'string'],
            'text' => ['nullable', 'min:3', 'string'],
        ]);

        if ($validator->passes())
        {
            $article->update([
                'name' => $request->input('name'),
                'author' => $request->input('author'),
                'text' => $request->input('text'),
            ]);

            return redirect()->route('articles.index')->with('success', 'Article updated successfully');
        }
        else
        {
            return redirect()->route('articles.edit', $article)->withInput()->withErrors($validator);
        }
    }

    /**
     * @param Article $article
     * @return JsonResponse
     */
    public function destroy(Article $article): JsonResponse
    {
        $article->delete();

        session()->flash('success', 'Article deleted successfully');

        return response()->json([
            'success' => true,
        ]);
    }
}
