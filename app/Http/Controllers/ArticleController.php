<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Repositories\ArticleRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function __construct(private readonly ArticleRepository $articleRepository)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // cache get
        $articles = Cache::get('articles');
        if ($articles === null) {
            $articles = $this->articleRepository->getLatest();
            // cache put
            Cache::put('articles', $articles, 600);
        }

        return view('articles.index', [
            'articles' => $articles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // validation
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:255',
        ]);

        $request->user()->articles()->create($validated);
        // cache invalidation
        Cache::delete('articles');

        return redirect(route('articles.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article): View
    {
        return view('articles.show', [
            'article' => $article,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article): View
    {
        // authorize
        Gate::authorize('update', $article);

        return view('articles.edit', [
            'article' => $article,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article): RedirectResponse
    {
        // authorize
        Gate::authorize('update', $article);

        // validate
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:255',
        ]);

        $article->update($validated);
        // cache invalidation
        Cache::delete('articles');

        return redirect(route('articles.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article): RedirectResponse
    {
        // authorize
        Gate::authorize('delete', $article);

        $article->delete();
        // cache invalidation
        Cache::delete('articles');

        return redirect(route('articles.index'));
    }
}
