<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of articles.
     */
    public function index(Request $request)
    {
        $query = Article::with('author')
            ->published()
            ->orderBy('published_at', 'desc');

        // Filter by category
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Search by title or content
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $articles = $query->paginate(12);
        $featuredArticles = Article::with('author')
            ->published()
            ->featured()
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        $categories = [
            'tin_tuc' => 'Tin tức',
            'huong_dan' => 'Hướng dẫn',
            'thong_bao' => 'Thông báo',
            'su_kien' => 'Sự kiện',
        ];

        return view('articles.index', compact('articles', 'featuredArticles', 'categories'));
    }

    /**
     * Display the specified article.
     */
    public function show(string $slug)
    {
        $article = Article::with('author')
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment view count
        $article->incrementViews();

        // Get related articles (same category, excluding current article)
        $relatedArticles = Article::with('author')
            ->published()
            ->where('category', $article->category)
            ->where('id', '!=', $article->id)
            ->orderBy('published_at', 'desc')
            ->limit(4)
            ->get();

        return view('articles.show', compact('article', 'relatedArticles'));
    }

    /**
     * Display articles by category.
     */
    public function category(string $category)
    {
        $categories = [
            'tin_tuc' => 'Tin tức',
            'huong_dan' => 'Hướng dẫn',
            'thong_bao' => 'Thông báo',
            'su_kien' => 'Sự kiện',
        ];

        if (!array_key_exists($category, $categories)) {
            abort(404);
        }

        $articles = Article::with('author')
            ->published()
            ->byCategory($category)
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        return view('articles.category', compact('articles', 'category', 'categories'));
    }
}
