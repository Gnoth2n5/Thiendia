@extends('layouts.app')

@section('title', 'Bài viết - Tra cứu liệt sĩ tỉnh Ninh Bình')

@section('content')
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-4">
            <div class="p-2 rounded-lg" style="background-color: rgba(139,0,0,0.1);">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                    class="h-6 w-6" style="color: #8b0000;">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold" style="color: #2b2b2b;">Bài viết & Tin tức</h1>
                <p style="color: #2b2b2b; opacity: 0.6;">Cập nhật thông tin mới nhất về hệ thống quản lý nghĩa địa</p>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="card mb-8 border" style="background-color: #fafaf8; border-color: #d4d0c8; box-shadow: none;">
        <div class="card-body">
            <form method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" name="search" placeholder="Tìm kiếm bài viết..."
                        class="input input-bordered w-full" value="{{ request('search') }}">
                </div>
                <div class="md:w-48">
                    <select name="category" class="select select-bordered w-full">
                        <option value="">Tất cả danh mục</option>
                        @foreach ($categories as $key => $label)
                            <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn gap-2" style="background-color: #8b0000; color: #f5f3e7; border: none;"
                    onmouseover="this.style.backgroundColor='#6b0000'" onmouseout="this.style.backgroundColor='#8b0000'">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    Tìm kiếm
                </button>
            </form>
        </div>
    </div>

    <!-- Featured Articles -->
    @if ($featuredArticles->count() > 0)
        <div class="mb-12">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-2 rounded-lg" style="background-color: rgba(139,0,0,0.1);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="h-6 w-6" style="color: #8b0000;">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold" style="color: #2b2b2b;">Bài viết nổi bật</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($featuredArticles as $article)
                    <div class="card border transition-all"
                        style="background-color: #fafaf8; border-color: #d4d0c8; box-shadow: none;"
                        onmouseover="this.style.boxShadow='0 4px 6px rgba(139, 0, 0, 0.1)'"
                        onmouseout="this.style.boxShadow='none'">
                        <figure class="h-48 overflow-hidden">
                            @if ($article->featured_image)
                                <img src="{{ $article->featured_image }}" alt="{{ $article->title }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center"
                                    style="background-color: #8b0000;">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="h-16 w-16 text-white">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <div class="badge gap-1" style="background-color: #8b0000; color: #f5f3e7; border: none;">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="h-3 w-3">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                    </svg>
                                    Nổi bật
                                </div>
                            </div>
                        </figure>

                        <div class="card-body">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="badge badge-sm"
                                    style="background-color: #8b0000; color: #f5f3e7; border: none;">
                                    {{ $article->category_label }}</div>
                            </div>

                            <h3 class="card-title text-lg leading-tight mb-2">
                                <a href="{{ route('articles.show', $article->slug) }}" style="color: #2b2b2b;"
                                    onmouseover="this.style.color='#8b0000'" onmouseout="this.style.color='#2b2b2b'">
                                    {{ $article->title }}
                                </a>
                            </h3>

                            <div class="flex items-center justify-between text-sm" style="color: #2b2b2b; opacity: 0.6;">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    {{ $article->created_at->format('d/m/Y') }}
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

                            <div class="card-actions justify-end mt-4">
                                <a href="{{ route('articles.show', $article->slug) }}" class="btn btn-sm"
                                    style="background-color: #8b0000; color: #f5f3e7; border: none;"
                                    onmouseover="this.style.backgroundColor='#6b0000'"
                                    onmouseout="this.style.backgroundColor='#8b0000'">
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
        </div>
    @endif

    <!-- All Articles -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold" style="color: #2b2b2b;">Tất cả bài viết</h2>
            <div class="text-sm" style="color: #2b2b2b; opacity: 0.6;">
                Hiển thị {{ $articles->count() }} / {{ $articles->total() }} bài viết
            </div>
        </div>

        @if ($articles->count() > 0)
            <!-- Main Layout: Left side large articles, Right side small articles -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Side: Large Articles (2/3 width) -->
                <div class="lg:col-span-2 space-y-8">
                    @foreach ($articles->take(2) as $index => $article)
                        <div class="card border transition-all"
                            style="background-color: #fafaf8; border-color: #d4d0c8; box-shadow: none;"
                            onmouseover="this.style.boxShadow='0 4px 6px rgba(139, 0, 0, 0.1)'"
                            onmouseout="this.style.boxShadow='none'">
                            <div class="card-body p-0">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-0">
                                    <!-- Image Section -->
                                    <div class="relative overflow-hidden">
                                        @if ($article->featured_image)
                                            <img src="{{ $article->featured_image }}" alt="{{ $article->title }}"
                                                class="w-full h-64 md:h-full object-cover">
                                        @else
                                            <div class="w-full h-64 md:h-full flex items-center justify-center"
                                                style="background-color: #8b0000;">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    class="h-16 w-16 text-white">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Content Section -->
                                    <div class="p-6 flex flex-col justify-between">
                                        <div>
                                            <div class="flex items-center gap-2 mb-3">
                                                <div class="badge badge-sm"
                                                    style="background-color: #8b0000; color: #f5f3e7; border: none;">
                                                    {{ $article->category_label }}</div>
                                            </div>

                                            <h3 class="card-title text-xl leading-tight mb-3">
                                                <a href="{{ route('articles.show', $article->slug) }}"
                                                    style="color: #2b2b2b;" onmouseover="this.style.color='#8b0000'"
                                                    onmouseout="this.style.color='#2b2b2b'">
                                                    {{ $article->title }}
                                                </a>
                                            </h3>

                                            <p class="text-sm line-clamp-3 mb-4" style="color: #2b2b2b; opacity: 0.6;">
                                                {{ Str::limit(strip_tags($article->content), 150) }}
                                            </p>
                                        </div>

                                        <div class="space-y-3">
                                            <div class="flex items-center justify-between text-sm"
                                                style="color: #2b2b2b; opacity: 0.6;">
                                                <div class="flex items-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        class="h-4 w-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>
                                                    {{ $article->created_at->format('d/m/Y') }}
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        class="h-4 w-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                    </svg>
                                                    {{ $article->views }} lượt xem
                                                </div>
                                            </div>

                                            <div class="card-actions justify-start">
                                                <a href="{{ route('articles.show', $article->slug) }}" class="btn btn-sm"
                                                    style="background-color: #8b0000; color: #f5f3e7; border: none;"
                                                    onmouseover="this.style.backgroundColor='#6b0000'"
                                                    onmouseout="this.style.backgroundColor='#8b0000'">
                                                    Đọc tiếp
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        class="h-4 w-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Right Side: Small Articles (1/3 width) -->
                <div class="lg:col-span-1">
                    <div class="sticky top-8">
                        <h3 class="text-lg font-bold mb-4" style="color: #2b2b2b;">Bài viết khác</h3>
                        <div class="space-y-4">
                            @foreach ($articles->skip(2) as $article)
                                <div class="card border"
                                    style="background-color: #fafaf8; border-color: #d4d0c8; box-shadow: none;"
                                    onmouseover="this.style.boxShadow='0 2px 4px rgba(139, 0, 0, 0.1)'"
                                    onmouseout="this.style.boxShadow='none'">
                                    <div class="card-body p-4">
                                        <div class="flex gap-3">
                                            <!-- Small Image -->
                                            <div class="flex-shrink-0">
                                                @if ($article->featured_image)
                                                    <img src="{{ $article->featured_image }}"
                                                        alt="{{ $article->title }}"
                                                        class="w-16 h-16 object-cover rounded-lg">
                                                @else
                                                    <div class="w-16 h-16 rounded-lg flex items-center justify-center"
                                                        style="background-color: #8b0000;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                            class="h-6 w-6 text-white">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Content -->
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <div class="badge badge-xs"
                                                        style="background-color: #8b0000; color: #f5f3e7; border: none;">
                                                        {{ $article->category_label }}</div>
                                                </div>

                                                <h4 class="font-semibold text-sm leading-tight mb-2 line-clamp-2"
                                                    style="color: #2b2b2b;">
                                                    <a href="{{ route('articles.show', $article->slug) }}"
                                                        onmouseover="this.style.color='#8b0000'"
                                                        onmouseout="this.style.color='#2b2b2b'">
                                                        {{ $article->title }}
                                                    </a>
                                                </h4>

                                                <div class="flex items-center gap-2 text-xs"
                                                    style="color: #2b2b2b; opacity: 0.6;">
                                                    <span>{{ $article->created_at->format('d/m/Y') }}</span>
                                                    <span>•</span>
                                                    <span>{{ $article->views }} lượt xem</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center mt-8">
                {{ $articles->appends(request()->query())->links() }}
            </div>
        @else
            <div class="card border text-center py-16" style="background-color: #fafaf8; border-color: #d4d0c8;">
                <div class="card-body">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-16 w-16 mx-auto mb-4" style="color: #8b0000; opacity: 0.3;">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    <h3 class="text-xl font-bold mb-2" style="color: #2b2b2b;">Không tìm thấy bài viết</h3>
                    <p class="mb-4" style="color: #2b2b2b; opacity: 0.6;">Vui lòng thử lại với từ khóa khác hoặc bộ lọc
                        khác</p>
                    <a href="{{ route('articles.index') }}" class="btn"
                        style="background-color: #d4d0c8; color: #2b2b2b; border: none;">Xem tất cả bài viết</a>
                </div>
            </div>
        @endif
    </div>
@endsection
