@extends('layouts.app')

@section('title', $categories[$category] . ' - Tra cứu liệt sĩ tỉnh Ninh Bình')

@section('content')
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-4">
            <div class="p-2 bg-primary/10 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                    class="h-6 w-6 text-primary">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-neutral">{{ $categories[$category] }}</h1>
                <p class="text-base-content/60">Tất cả bài viết trong danh mục {{ $categories[$category] }}</p>
            </div>
        </div>

        <!-- Category Navigation -->
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('articles.index') }}"
                class="btn btn-ghost btn-sm {{ request()->route('category') === null ? 'btn-active' : '' }}">
                Tất cả
            </a>
            @foreach ($categories as $key => $label)
                <a href="{{ route('articles.category', $key) }}"
                    class="btn btn-ghost btn-sm {{ $category === $key ? 'btn-active' : '' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Articles Grid -->
    @if ($articles->count() > 0)
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-neutral">Bài viết trong danh mục</h2>
                <div class="text-sm text-base-content/60">
                    Hiển thị {{ $articles->count() }} / {{ $articles->total() }} bài viết
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($articles as $article)
                    <div
                        class="card bg-base-100 shadow-lg hover:shadow-xl transition-all hover:-translate-y-1 border border-base-300">
                        <figure class="h-48 overflow-hidden">
                            @if ($article->featured_image)
                                <img src="{{ $article->featured_image }}" alt="{{ $article->title }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div
                                    class="w-full h-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="h-16 w-16 text-white">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                </div>
                            @endif
                        </figure>

                        <div class="card-body">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="badge badge-primary badge-sm">{{ $article->category_label }}</div>
                            </div>

                            <h3 class="card-title text-lg leading-tight mb-2">
                                <a href="{{ route('articles.show', $article->slug) }}"
                                    class="hover:text-primary transition-colors">
                                    {{ $article->title }}
                                </a>
                            </h3>


                            <div class="flex items-center justify-between text-sm text-base-content/60 mb-3">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                    Admin
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    {{ $article->views }}
                                </div>
                            </div>

                            <div class="card-actions justify-end">
                                <a href="{{ route('articles.show', $article->slug) }}" class="btn btn-error btn-sm">
                                    Đọc tiếp
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center mt-8">
                {{ $articles->appends(request()->query())->links() }}
            </div>
        </div>
    @else
        <div class="card bg-base-100 shadow-lg border border-base-300">
            <div class="card-body text-center py-16">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="h-16 w-16 mx-auto text-base-content/30 mb-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                </svg>
                <h3 class="text-xl font-bold text-neutral mb-2">Không có bài viết nào</h3>
                <p class="text-base-content/60 mb-4">Hiện tại chưa có bài viết nào trong danh mục
                    {{ $categories[$category] }}</p>
                <a href="{{ route('articles.index') }}" class="btn btn-ghost">Xem tất cả bài viết</a>
            </div>
        </div>
    @endif
@endsection
