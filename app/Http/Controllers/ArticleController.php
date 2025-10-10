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
        $query = Article::published()
            ->orderBy('created_at', 'desc');

        // Filter by category
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Search by title or content
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $articles = $query->paginate(12);

        // Get recent articles as featured (since we removed is_featured)
        $featuredArticles = Article::published()
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        $categories = [
            'tin_tuc' => 'Tin tức',
            'huong_dan' => 'Hướng dẫn',
            'thong_bao' => 'Thông báo',
        ];

        return view('articles.index', compact('articles', 'featuredArticles', 'categories'));
    }

    /**
     * Display the specified article.
     */
    public function show(string $slug)
    {
        $article = Article::published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment view count
        $article->increment('views');

        // Get related articles (same category, excluding current article)
        $relatedArticles = Article::published()
            ->where('category', $article->category)
            ->where('id', '!=', $article->id)
            ->orderBy('created_at', 'desc')
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
        ];

        if (!array_key_exists($category, $categories)) {
            abort(404);
        }

        $articles = Article::published()
            ->byCategory($category)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('articles.category', compact('articles', 'category', 'categories'));
    }
}
