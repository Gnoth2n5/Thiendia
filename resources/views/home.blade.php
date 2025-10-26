@extends('layouts.app')

@section('title', 'Hệ thống Tra cứu Thông tin Liệt sĩ Tỉnh Ninh Bình Trực tuyến - Tìm kiếm Lăng mộ Nhanh chóng')

@section('description',
    'Hệ thống tra cứu thông tin liệt sĩ tỉnh Ninh Bình trực tuyến. Tìm kiếm lăng mộ nhanh chóng,
    chính xác và tiện lợi. Quản lý dữ liệu nghĩa trang khoa học, minh bạch và hiện đại với công nghệ bản đồ số tiên tiến.')

    @push('structured-data')
        <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "Hệ thống Tra cứu Thông tin Liệt sĩ Tỉnh Ninh Bình",
  "description": "Hệ thống tra cứu thông tin liệt sĩ tỉnh Ninh Bình trực tuyến. Tìm kiếm lăng mộ nhanh chóng, chính xác và tiện lợi.",
  "url": "{{ url('/') }}",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "{{ url('/search') }}?q={search_term_string}",
    "query-input": "required name=search_term_string"
  },
  "publisher": {
    "@type": "Organization",
    "name": "Hệ thống Tra cứu Liệt sĩ Ninh Bình",
    "address": {
      "@type": "PostalAddress",
      "addressLocality": "Ninh Bình",
      "addressCountry": "VN"
    },
    "contactPoint": {
      "@type": "ContactPoint",
      "telephone": "0123-456-789",
      "contactType": "customer service",
      "availableLanguage": "Vietnamese"
    }
  },
  "inLanguage": "vi",
  "keywords": "tra cứu liệt sĩ, nghĩa trang Ninh Bình, tìm kiếm lăng mộ, quản lý nghĩa địa"
}
</script>

        <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Service",
  "name": "Dịch vụ Tra cứu Thông tin Liệt sĩ",
  "description": "Dịch vụ tra cứu thông tin liệt sĩ và quản lý nghĩa trang trực tuyến",
  "provider": {
    "@type": "Organization",
    "name": "Hệ thống Tra cứu Liệt sĩ Ninh Bình"
  },
  "areaServed": {
    "@type": "Place",
    "name": "Ninh Bình, Việt Nam"
  },
  "serviceType": "Tra cứu thông tin nghĩa trang",
  "availableChannel": {
    "@type": "ServiceChannel",
    "serviceUrl": "{{ url('/') }}",
    "serviceSmsNumber": "0123-456-789"
  }
}
</script>
    @endpush

@section('content')
    <!-- Quick Search Section -->
    <div class="mb-12">
        <div class="text-center mb-8">
            <h2 class="text-3xl md:text-4xl font-bold text-neutral mb-4">
                Tra cứu thông tin lăng mộ
            </h2>
            <p class="text-lg text-base-content/70 max-w-3xl mx-auto">
                Tìm kiếm thông tin về người thân đã khuất một cách nhanh chóng và chính xác
            </p>
        </div>

        <!-- Quick Search Form -->
        <div class="card bg-base-100 shadow-xl border border-base-300 max-w-4xl mx-auto">
            <div class="card-body">
                <form method="GET" action="{{ route('search') }}" class="space-y-6">
                    <!-- Search Inputs Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Deceased Name -->
                        <div class="form-control">
                            <label class="label" for="deceased_name">
                                <span class="label-text font-semibold">Tên người đã khuất</span>
                            </label>
                            <input type="text" name="deceased_name" id="deceased_name"
                                placeholder="Nhập tên người đã khuất..." class="input input-bordered w-full"
                                value="{{ request('deceased_name') }}">
                        </div>

                        <!-- Grave Number -->
                        <div class="form-control">
                            <label class="label" for="grave_number">
                                <span class="label-text font-semibold">Số lăng mộ</span>
                            </label>
                            <input type="text" name="grave_number" id="grave_number" placeholder="Nhập số lăng mộ..."
                                class="input input-bordered w-full" value="{{ request('grave_number') }}">
                        </div>
                    </div>

                    <!-- Second Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Owner Name -->
                        <div class="form-control">
                            <label class="label" for="owner_name">
                                <span class="label-text font-semibold">Tên chủ lăng mộ</span>
                            </label>
                            <input type="text" name="owner_name" id="owner_name" placeholder="Nhập tên chủ lăng mộ..."
                                class="input input-bordered w-full" value="{{ request('owner_name') }}">
                        </div>

                        <!-- Commune -->
                        <div class="form-control">
                            <label class="label" for="commune">
                                <span class="label-text font-semibold">Xã/Phường</span>
                            </label>
                            <select name="commune" id="commune" class="select select-bordered w-full"
                                data-selected="{{ request('commune') }}">
                                <option value="">Tất cả xã/phường</option>
                            </select>
                        </div>
                    </div>

                    <!-- Third Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Cemetery -->
                        <div class="form-control">
                            <label class="label" for="cemetery_id">
                                <span class="label-text font-semibold">Nghĩa trang</span>
                            </label>
                            <select name="cemetery_id" id="cemetery_id" class="select select-bordered w-full"
                                data-selected="{{ request('cemetery_id') }}">
                                <option value="">Tất cả nghĩa trang</option>
                            </select>
                        </div>
                    </div>

                    <!-- Search Button -->
                    <div class="flex justify-center pt-4">
                        <button type="submit" class="btn btn-error btn-lg px-12 gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                            Tìm kiếm
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Latest Articles Section -->
    <div class="mb-20">
        <div class="text-center mb-12">
            <div class="relative inline-block mb-6">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-green-400 to-blue-500 rounded-2xl blur-lg opacity-30 scale-110">
                </div>
                <div class="relative p-4 bg-gradient-to-br from-purple-500 to-red-500 rounded-2xl shadow-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="h-10 w-10 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </div>
            </div>

            <h2 class="text-4xl font-bold text-red-600 mb-4">
                Tin tức & Bài viết mới
            </h2>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                Cập nhật những thông tin mới nhất về hệ thống tra cứu thông tin liệt sĩ
            </p>
        </div>

        @php
            $latestArticles = \App\Models\Article::published()->orderBy('created_at', 'desc')->limit(6)->get();
        @endphp

        <!-- Main Layout: Left side large articles, Right side small articles -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Side: Large Articles (2/3 width) -->
            <div class="lg:col-span-2 space-y-8">
                @foreach ($latestArticles->take(2) as $article)
                    <div
                        class="group relative overflow-hidden rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 bg-gradient-to-br from-white via-slate-50/50 to-green-50/30 border border-green-200/50">
                        <!-- Background Effects -->
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-green-100/20 to-blue-100/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>
                        <div
                            class="absolute -top-10 -right-10 w-32 h-32 bg-green-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700">
                        </div>

                        <div class="relative grid grid-cols-1 md:grid-cols-2 gap-0">
                            <!-- Image Section -->
                            <div class="relative overflow-hidden">
                                @if ($article->featured_image)
                                    <img src="{{ $article->featured_image }}" alt="{{ $article->title }}"
                                        class="w-full h-64 md:h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div
                                        class="w-full h-64 md:h-full bg-gradient-to-br from-purple-500 to-red-500 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="h-16 w-16 text-white">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Content Section -->
                            <div class="p-6 flex flex-col justify-between">
                                <div>
                                    <!-- Category Badge -->
                                    <div class="mb-3">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-purple-500 to-red-500 text-white">
                                            @switch($article->category)
                                                @case('tin_tuc')
                                                    📰 Tin tức
                                                @break

                                                @case('huong_dan')
                                                    📖 Hướng dẫn
                                                @break

                                                @case('thong_bao')
                                                    📢 Thông báo
                                                @break

                                                @default
                                                    📄 Bài viết
                                            @endswitch
                                        </span>
                                    </div>

                                    <!-- Title -->
                                    <h3
                                        class="text-xl font-bold text-slate-800 group-hover:text-red-700 transition-colors duration-300 mb-3 line-clamp-2">
                                        {{ $article->title }}
                                    </h3>

                                    <!-- Excerpt -->
                                    <p class="text-sm text-slate-600 mb-4 line-clamp-3 leading-relaxed">
                                        {{ Str::limit(strip_tags($article->content), 150) }}
                                    </p>
                                </div>

                                <div class="space-y-3">
                                    <!-- Meta Info -->
                                    <div class="flex items-center justify-between text-xs text-slate-500">
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
                                            {{ $article->views }} lượt xem
                                        </div>
                                    </div>

                                    <!-- Action Button -->
                                    <a href="{{ route('articles.show', $article->slug) }}"
                                        class="group/btn relative inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-purple-500 to-red-500 hover:from-purple-700 hover:to-red-700 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-r from-purple-500 to-red-500 rounded-2xl blur opacity-0 group-hover/btn:opacity-75 transition-opacity duration-300">
                                        </div>
                                        <div class="relative flex items-center gap-2">
                                            <span>Đọc tiếp</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="2" stroke="currentColor"
                                                class="h-4 w-4 group-hover/btn:translate-x-1 transition-transform duration-300">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                            </svg>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Right Side: Small Articles (1/3 width) -->
            <div class="lg:col-span-1">
                <div class="sticky top-8">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Bài viết khác</h3>
                    <div class="space-y-4">
                        @foreach ($latestArticles->skip(2) as $article)
                            <div
                                class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 bg-white border border-green-200/50">
                                <div class="p-4">
                                    <div class="flex gap-3">
                                        <!-- Small Image -->
                                        <div class="flex-shrink-0">
                                            @if ($article->featured_image)
                                                <img src="{{ $article->featured_image }}" alt="{{ $article->title }}"
                                                    class="w-16 h-16 object-cover rounded-lg">
                                            @else
                                                <div
                                                    class="w-16 h-16 bg-gradient-to-br from-purple-500 to-red-500 rounded-lg flex items-center justify-center">
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
                                            <div class="mb-1">
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gradient-to-r from-purple-500 to-red-500 text-white">
                                                    {{ $article->category_label }}
                                                </span>
                                            </div>

                                            <h4
                                                class="font-semibold text-sm leading-tight mb-2 line-clamp-2 text-slate-800 group-hover:text-red-700 transition-colors">
                                                <a href="{{ route('articles.show', $article->slug) }}">
                                                    {{ $article->title }}
                                                </a>
                                            </h4>

                                            <div class="flex items-center gap-2 text-xs text-slate-500">
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

        <!-- View All Button -->
        <div class="text-center mt-12">
            <a href="{{ route('articles.index') }}"
                class="group relative inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-purple-500 to-red-500 hover:from-purple-700 hover:to-red-700 text-white font-bold text-lg rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 transform">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-purple-500 to-red-500 rounded-2xl blur opacity-0 group-hover:opacity-75 transition-opacity duration-300">
                </div>
                <div class="relative flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    Xem tất cả bài viết
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="h-5 w-5 group-hover:translate-x-1 transition-transform duration-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </div>
            </a>
        </div>
    </div>

    <!-- SEO Content Section -->
    <div>
        <div class="max-w-6xl mx-auto">
            <div class="bg-white rounded-3xl shadow-xl border border-gray-200 p-8 md:p-12">
                <h1 class="text-2xl md:text-4xl font-bold text-gray-800 mb-6 text-center xl:mx-28">
                    HỆ THỐNG TRA CỨU THÔNG TIN LIỆT SĨ TỈNH NINH BÌNH TRỰC TUYẾN
                </h1>
                <p class="text-xl text-gray-600 text-center mb-8">
                    Tra cứu thông tin lăng mộ nhanh chóng, chính xác và tiện lợi
                </p>

                <div class="prose prose-lg max-w-none">
                    <p class="text-lg text-gray-700 leading-relaxed mb-6">
                        Hệ thống Tra cứu thông tin liệt sĩ tỉnh Ninh Bình là nền tảng trực tuyến giúp người dân dễ dàng tra
                        cứu thông tin người thân đã khuất, xác định vị trí lăng mộ và quản lý dữ liệu nghĩa trang một cách
                        khoa học, minh bạch và hiện đại. Với công nghệ bản đồ số tiên tiến, người dùng có thể tìm kiếm thông
                        tin chính xác chỉ bằng vài thao tác đơn giản.
                    </p>

                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Giới thiệu hệ thống</h2>
                    <p class="text-lg text-gray-700 leading-relaxed mb-6">
                        Hệ thống được xây dựng nhằm số hóa dữ liệu nghĩa địa, phục vụ công tác quản lý, tra cứu và bảo tồn
                        thông tin người đã khuất. Đây là giải pháp tối ưu cho các địa phương, ban quản lý nghĩa trang, cũng
                        như thân nhân có nhu cầu tìm kiếm và cập nhật thông tin mộ phần.
                    </p>

                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Tính năng nổi bật</h2>
                    <ul class="list-disc list-inside text-lg text-gray-700 leading-relaxed mb-6 space-y-2">
                        <li>Tra cứu thông tin người đã khuất: Nhập tên, năm sinh, năm mất hoặc khu vực chôn cất để tìm kiếm
                            dễ dàng.</li>
                        <li>Xác định vị trí lăng mộ trên bản đồ số: Hỗ trợ định vị nhanh chóng, chính xác từng ô mộ.</li>
                        <li>Quản lý dữ liệu nghĩa trang: Cập nhật, chỉnh sửa thông tin mộ phần, phân khu, hàng, lô dễ dàng.
                        </li>
                        <li>Tích hợp hình ảnh và hồ sơ điện tử: Giúp lưu trữ và bảo tồn thông tin lâu dài.</li>
                        <li>Báo cáo thống kê thông minh: Hỗ trợ cơ quan quản lý tổng hợp số liệu và lập kế hoạch hiệu quả.
                        </li>
                    </ul>

                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Lợi ích mang lại</h2>
                    <ul class="list-disc list-inside text-lg text-gray-700 leading-relaxed mb-6 space-y-2">
                        <li>Đối với người dân: Dễ dàng tìm kiếm thông tin người thân mà không cần đến trực tiếp nghĩa trang.
                        </li>
                        <li>Đối với ban quản lý nghĩa trang: Tiết kiệm thời gian, giảm sai sót và quản lý tập trung, chuyên
                            nghiệp.</li>
                        <li>Đối với chính quyền địa phương: Góp phần vào công cuộc chuyển đổi số, nâng cao hiệu quả quản lý
                            dân cư và di sản văn hóa tâm linh.</li>
                    </ul>

                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Tầm nhìn và sứ mệnh</h2>
                    <p class="text-lg text-gray-700 leading-relaxed mb-6">
                        Chúng tôi hướng tới mục tiêu xây dựng hệ thống tra cứu và quản lý nghĩa địa toàn diện, góp phần gìn
                        giữ giá trị văn hóa truyền thống và tạo thuận tiện cho người dân trong hành trình tưởng nhớ tổ tiên.
                    </p>

                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Liên hệ</h2>
                    <p class="text-lg text-gray-700 leading-relaxed mb-6">
                        Nếu bạn là ban quản lý nghĩa trang, chính quyền địa phương hoặc người dân muốn sử dụng hệ thống, hãy
                        liên hệ với chúng tôi để được tư vấn và hỗ trợ triển khai:
                    </p>
                    <ul class="list-disc list-inside text-lg text-gray-700 leading-relaxed">
                        <li>📍 Địa chỉ: Ninh Bình, Việt Nam</li>
                        <li>📞 Hotline: 0123 456 789</li>
                        <li>🌐 Website: tenmiencuaban.vn</li>
                        <li>✉️ Email: lienhe@tenmiencuaban.vn</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Temporarily disabled JavaScript to test form submission --}}
