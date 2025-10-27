@extends('layouts.app')

@section('title', $article->title . ' - Tra cứu liệt sĩ tỉnh Ninh Bình')

@section('content')
    <!-- Article Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 mb-4">
            <a href="{{ route('articles.index') }}" class="btn btn-ghost btn-sm gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                    class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Quay lại
            </a>
            <div class="badge badge-primary">{{ $article->category_label }}</div>
        </div>

        <h1 class="text-4xl md:text-5xl font-bold text-neutral leading-tight mb-4">{{ $article->title }}</h1>


        <div class="flex flex-wrap items-center gap-6 text-sm text-base-content/60">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
                <span class="font-medium">Admin</span>
            </div>

            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                </svg>
                <span>{{ $article->created_at->format('d/m/Y H:i') }}</span>
            </div>

            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                <span>{{ number_format($article->views) }} lượt xem</span>
            </div>
        </div>
    </div>

    <!-- Featured Image -->
    @if ($article->featured_image)
        <div class="mb-8">
            <div class="card bg-base-100 shadow-xl border border-base-300 overflow-hidden">
                <figure>
                    <img src="{{ $article->featured_image }}" alt="{{ $article->title }}" class="w-full h-96 object-cover">
                </figure>
            </div>
        </div>
    @endif

    <!-- Article Content -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-3">
            <div class="card bg-base-100 shadow-xl border border-base-300">
                <div class="card-body prose prose-lg max-w-none">
                    {!! $article->content !!}
                </div>
            </div>

        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Article Info -->
            <div class="card bg-base-100 shadow-xl border border-base-300 mb-6">
                <div class="card-body">
                    <h3 class="card-title text-lg mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        Thông tin bài viết
                    </h3>
                    <div class="space-y-2">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-medium">Ngày đăng:</span>
                            <span
                                class="text-sm text-base-content/60">{{ $article->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-medium">Danh mục:</span>
                            <span class="badge badge-primary badge-sm">{{ $article->category_label }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-medium">Lượt xem:</span>
                            <span class="text-sm text-base-content/60">{{ $article->views }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Articles -->
            @if ($relatedArticles->count() > 0)
                <div class="card bg-base-100 shadow-xl border border-base-300">
                    <div class="card-body">
                        <h3 class="card-title text-lg mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                            Bài viết liên quan
                        </h3>
                        <div class="space-y-4">
                            @foreach ($relatedArticles as $relatedArticle)
                                <div class="flex gap-3">
                                    <div class="flex-shrink-0">
                                        @if ($relatedArticle->featured_image)
                                            <img src="{{ $relatedArticle->featured_image }}"
                                                alt="{{ $relatedArticle->title }}"
                                                class="w-16 h-16 object-cover rounded-lg">
                                        @else
                                            <div
                                                class="w-16 h-16 bg-gradient-to-br from-primary-400 to-primary-600 rounded-lg flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor" class="h-6 w-6 text-white">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <a href="{{ route('articles.show', $relatedArticle->slug) }}" class="block">
                                            <h4
                                                class="font-semibold text-sm leading-tight hover:text-primary transition-colors line-clamp-2">
                                                {{ $relatedArticle->title }}
                                            </h4>
                                            <div class="flex items-center gap-2 mt-1 text-xs text-base-content/60">
                                                <span>{{ $relatedArticle->created_at->format('d/m/Y') }}</span>
                                                <span>•</span>
                                                <span>{{ $relatedArticle->views }} lượt xem</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="card-actions justify-end mt-4">
                            <a href="{{ route('articles.index') }}" class="btn btn-ghost btn-sm">
                                Xem tất cả
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Back to Top -->
    <div class="fixed bottom-8 right-8">
        <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="btn btn-error btn-circle shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="h-6 w-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 19.5v-15m0 0l-6.75 6.75M12 4.5l6.75 6.75" />
            </svg>
        </button>
    </div>
@endsection
