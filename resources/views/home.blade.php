@extends('layouts.app')

@section('title', 'Trang chủ - Quản lý Nghĩa Địa')

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
                            <!-- Grave Number -->
                            <div class="form-control">
                                <label class="label" for="grave_number">
                                    <span class="label-text font-semibold">Số lăng mộ</span>
                                </label>
                                <input type="text" 
                                       name="grave_number" 
                                       id="grave_number"
                                       placeholder="Nhập số lăng mộ..." 
                                       class="input input-bordered w-full"
                                       value="{{ request('grave_number') }}">
                            </div>
                            
                            <!-- Owner Name -->
                            <div class="form-control">
                                <label class="label" for="owner_name">
                                    <span class="label-text font-semibold">Tên chủ lăng mộ</span>
                                </label>
                                <input type="text" 
                                       name="owner_name" 
                                       id="owner_name"
                                       placeholder="Nhập tên chủ lăng mộ..." 
                                       class="input input-bordered w-full"
                                       value="{{ request('owner_name') }}">
                            </div>
                        </div>
                        
                        <!-- Second Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Deceased Name -->
                            <div class="form-control">
                                <label class="label" for="deceased_name">
                                    <span class="label-text font-semibold">Tên người đã khuất</span>
                                </label>
                                <input type="text" 
                                       name="deceased_name" 
                                       id="deceased_name"
                                       placeholder="Nhập tên người đã khuất..." 
                                       class="input input-bordered w-full"
                                       value="{{ request('deceased_name') }}">
                            </div>
                            
                            <!-- District -->
                            <div class="form-control">
                                <label class="label" for="district">
                                    <span class="label-text font-semibold">Huyện/Thành phố</span>
                                </label>
                                <select name="district" id="district" class="select select-bordered w-full">
                                    <option value="">Tất cả huyện/thành phố</option>
                                    @foreach(['Bình Lục', 'Thanh Liêm', 'Lý Nhân', 'Nam Trực', 'Vụ Bản', 'Ý Yên', 'Trực Ninh', 'Xuân Trường', 'Hải Hậu', 'Giao Thủy', 'Nghĩa Hưng', 'Gia Viễn', 'Nho Quan', 'Yên Khánh', 'Yên Mô', 'Kim Sơn', 'Thành phố Phủ Lý', 'Thành phố Nam Định', 'Thành phố Hoa Lư', 'Thành phố Tam Điệp'] as $district)
                                        <option value="{{ $district }}" {{ request('district') == $district ? 'selected' : '' }}>
                                            {{ $district }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <!-- Third Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Commune -->
                            <div class="form-control">
                                <label class="label" for="commune">
                                    <span class="label-text font-semibold">Xã/Phường</span>
                                </label>
                                <select name="commune" id="commune" class="select select-bordered w-full">
                                    <option value="">Tất cả xã/phường</option>
                                    @if(request('district'))
                                        @php
                                            $communes = config("ninhbinh_locations.{$request->district}", []);
                                        @endphp
                                        @foreach($communes as $commune)
                                            <option value="{{ $commune }}" {{ request('commune') == $commune ? 'selected' : '' }}>
                                                {{ $commune }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            
                            <!-- Cemetery -->
                            <div class="form-control">
                                <label class="label" for="cemetery_id">
                                    <span class="label-text font-semibold">Nghĩa trang</span>
                                </label>
                                <select name="cemetery_id" id="cemetery_id" class="select select-bordered w-full">
                                    <option value="">Tất cả nghĩa trang</option>
                                    @foreach($cemeteries as $cemetery)
                                        <option value="{{ $cemetery->id }}" {{ request('cemetery_id') == $cemetery->id ? 'selected' : '' }}>
                                            {{ $cemetery->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <!-- Search Button -->
                        <div class="flex justify-center pt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-12 gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
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
                    <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-blue-500 rounded-2xl blur-lg opacity-30 scale-110"></div>
                    <div class="relative p-4 bg-gradient-to-br from-green-500 to-blue-600 rounded-2xl shadow-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-10 w-10 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                    </div>
                </div>
                
                <h2 class="text-4xl font-bold bg-gradient-to-r from-green-700 via-blue-600 to-indigo-600 bg-clip-text text-transparent mb-4">
                    Tin tức & Bài viết mới
                </h2>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                    Cập nhật những thông tin mới nhất về hệ thống quản lý nghĩa địa
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @php
                    $latestArticles = \App\Models\Article::with('author')
                        ->published()
                        ->orderBy('published_at', 'desc')
                        ->limit(6)
                        ->get();
                @endphp
                
                @foreach($latestArticles as $article)
                    <div class="group relative overflow-hidden rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 bg-gradient-to-br from-white via-slate-50/50 to-green-50/30 border border-green-200/50">
                        <!-- Background Effects -->
                        <div class="absolute inset-0 bg-gradient-to-br from-green-100/20 to-blue-100/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-green-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                        <div class="absolute -bottom-10 -left-10 w-24 h-24 bg-blue-500/10 rounded-full blur-xl group-hover:scale-125 transition-transform duration-700"></div>
                        
                        <div class="relative p-6">
                            <!-- Featured Image -->
                            @if($article->featured_image)
                                <div class="mb-4 rounded-2xl overflow-hidden">
                                    <img src="{{ $article->featured_image }}" alt="{{ $article->title }}" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                                </div>
                            @endif
                            
                            <!-- Category Badge -->
                            <div class="mb-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-green-500 to-blue-500 text-white">
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
                                        @case('su_kien')
                                            🎉 Sự kiện
                                            @break
                                        @default
                                            📄 Bài viết
                                    @endswitch
                                </span>
                                @if($article->is_featured)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-yellow-500 to-orange-500 text-white ml-2">
                                        ⭐ Nổi bật
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Title -->
                            <h3 class="text-lg font-bold text-slate-800 group-hover:text-green-700 transition-colors duration-300 mb-3 line-clamp-2">
                                {{ $article->title }}
                            </h3>
                            
                            <!-- Excerpt -->
                            <p class="text-sm text-slate-600 mb-4 line-clamp-3 leading-relaxed">
                                {{ $article->excerpt }}
                            </p>
                            
                            <!-- Meta Info -->
                            <div class="flex items-center justify-between text-xs text-slate-500 mb-4">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                                    </svg>
                                    {{ $article->author->name ?? 'Admin' }}
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    {{ $article->published_at ? $article->published_at->format('d/m/Y') : 'Chưa xuất bản' }}
                                </div>
                            </div>
                            
                            <!-- Action Button -->
                            <a href="{{ route('articles.show', $article->slug) }}" class="group/btn relative w-full inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 transform">
                                <div class="absolute inset-0 bg-gradient-to-r from-green-500 to-blue-500 rounded-2xl blur opacity-0 group-hover/btn:opacity-75 transition-opacity duration-300"></div>
                                <div class="relative flex items-center gap-2">
                                    <span>Đọc tiếp</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4 group-hover/btn:translate-x-1 transition-transform duration-300">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                    </svg>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- View All Button -->
            <div class="text-center mt-12">
                <a href="{{ route('articles.index') }}" class="group relative inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 text-white font-bold text-lg rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 transform">
                    <div class="absolute inset-0 bg-gradient-to-r from-green-500 to-blue-500 rounded-2xl blur opacity-0 group-hover:opacity-75 transition-opacity duration-300"></div>
                    <div class="relative flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                        Xem tất cả bài viết
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 group-hover:translate-x-1 transition-transform duration-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </div>
                </a>
            </div>
        </div>

<!-- Cemeteries List Section -->
<div class="mb-20">
    <div class="text-center mb-12">
        <div class="relative inline-block mb-6">
            <div class="absolute inset-0 bg-gradient-to-r from-violet-400 to-purple-500 rounded-2xl blur-lg opacity-30 scale-110"></div>
            <div class="relative p-4 bg-gradient-to-br from-violet-500 to-purple-600 rounded-2xl shadow-xl">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-10 w-10 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                </svg>
            </div>
        </div>
        
        <h2 class="text-4xl font-bold bg-gradient-to-r from-violet-700 via-purple-600 to-indigo-600 bg-clip-text text-transparent mb-4">
            Danh sách Nghĩa trang
        </h2>
        <p class="text-lg text-slate-600 max-w-2xl mx-auto">
            {{ $cemeteries->count() }} nghĩa trang đang được quản lý trong hệ thống
        </p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($cemeteries as $cemetery)
            <div class="group relative overflow-hidden rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 bg-gradient-to-br from-white via-slate-50/50 to-violet-50/30 border border-violet-200/50">
                <!-- Background Effects -->
                <div class="absolute inset-0 bg-gradient-to-br from-violet-100/20 to-purple-100/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-violet-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                <div class="absolute -bottom-10 -left-10 w-24 h-24 bg-purple-500/10 rounded-full blur-xl group-hover:scale-125 transition-transform duration-700"></div>
                
                <div class="relative p-8">
                    <!-- Header -->
                    <div class="flex items-start gap-4 mb-6">
                        <div class="p-3 bg-gradient-to-br from-amber-400 to-orange-500 rounded-2xl shadow-lg group-hover:scale-110 transition-transform duration-300 shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-7 w-7 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-xl text-slate-800 group-hover:text-violet-700 transition-colors duration-300 mb-2">{{ $cemetery->name }}</h3>
                            <p class="text-sm text-slate-600 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4 text-slate-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                                {{ $cemetery->address }}
                            </p>
                        </div>
                    </div>
                    
                    <!-- Description -->
                    @if($cemetery->description)
                        <p class="text-sm text-slate-600 line-clamp-3 mb-6 leading-relaxed">{{ $cemetery->description }}</p>
                    @endif
                    
                    <!-- Stats -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="px-4 py-2 bg-gradient-to-r from-violet-500 to-purple-500 text-white rounded-xl shadow-lg">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                    </svg>
                                    <span class="font-bold text-lg">{{ $cemetery->graves_count }}</span>
                                </div>
                            </div>
                            <span class="text-sm text-slate-500 font-medium">lăng mộ</span>
                        </div>
                    </div>
                    
                    <!-- Action Button -->
                    <a href="{{ route('search', ['cemetery_id' => $cemetery->id]) }}" class="group/btn relative w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-violet-600 to-purple-600 hover:from-violet-700 hover:to-purple-700 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 transform">
                        <div class="absolute inset-0 bg-gradient-to-r from-violet-500 to-purple-500 rounded-2xl blur opacity-0 group-hover/btn:opacity-75 transition-opacity duration-300"></div>
                        <div class="relative flex items-center gap-3">
                            <span>Xem chi tiết</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 group-hover/btn:translate-x-1 transition-transform duration-300">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

{{-- Temporarily disabled JavaScript to test form submission --}}

