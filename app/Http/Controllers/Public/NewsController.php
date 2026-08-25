<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Contracts\View\View;

class NewsController extends Controller
{
    public function index(): View
{
    $newsItems = News::query()
        ->published()
        ->with('category:id,name')
        ->latest('published_at')
        ->paginate(9, [
            'id',
            'category_id',
            'title',
            'slug',
            'excerpt',
            'thumbnail',
            'published_at',
        ]);

    return view('public.news.index', compact('newsItems'));
}


    public function show(string $slug): View
{
    $news = News::query()
        ->published()
        ->with('category:id,name')
        ->where('slug', $slug)
        ->firstOrFail();

    $plainContent = trim(
        strip_tags(
            html_entity_decode(
                $news->content,
                ENT_QUOTES | ENT_HTML5,
                'UTF-8',
            ),
        ),
    );

    $words = preg_split(
        '/\s+/u',
        $plainContent,
        -1,
        PREG_SPLIT_NO_EMPTY,
    );

    $wordCount = is_array($words)
        ? count($words)
        : 0;

    $readingTime = max(
        1,
        (int) ceil($wordCount / 200),
    );

    $relatedNews = News::query()
        ->published()
        ->with('category:id,name')
        ->where('id', '!=', $news->id)
        ->when(
            $news->category_id,
            fn ($query, $categoryId) => $query
                ->where('category_id', $categoryId),
        )
        ->latest('published_at')
        ->limit(3)
        ->get([
            'id',
            'category_id',
            'title',
            'slug',
            'excerpt',
            'thumbnail',
            'published_at',
        ]);

    if ($relatedNews->count() < 3) {
        $excludedIds = $relatedNews
            ->pluck('id')
            ->push($news->id);

        $fallbackNews = News::query()
            ->published()
            ->with('category:id,name')
            ->whereNotIn('id', $excludedIds)
            ->latest('published_at')
            ->limit(3 - $relatedNews->count())
            ->get([
                'id',
                'category_id',
                'title',
                'slug',
                'excerpt',
                'thumbnail',
                'published_at',
            ]);

        $relatedNews = $relatedNews
            ->concat($fallbackNews)
            ->values();
    }

    return view(
        'public.news.show',
        compact(
            'news',
            'readingTime',
            'relatedNews',
        ),
    );
}
}