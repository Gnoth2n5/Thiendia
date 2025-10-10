@extends('layouts.app')

@section('title', 'Trang chủ - Quản lý Nghĩa Địa')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden rounded-3xl shadow-2xl mb-16 bg-gradient-to-br from-slate-900 via-teal-900 to-emerald-900">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-blue-600/20 via-purple-600/20 to-pink-600/20"></div>
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-teal-500/10 rounded-full blur-3xl animate-pulse delay-500"></div>
    </div>
    
    <!-- Grid Pattern -->
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="hero-grid" width="60" height="60" patternUnits="userSpaceOnUse">
                    <path d="M 60 0 L 0 0 0 60" fill="none" stroke="white" stroke-width="1"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#hero-grid)"/>
        </svg>
    </div>
    
    <div class="relative hero min-h-[600px] flex items-center">
        <div class="hero-content text-center text-white py-20 px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Icon with Glow Effect -->
                <div class="relative inline-block mb-8">
                    <div class="absolute inset-0 bg-gradient-to-r from-amber-400 to-orange-500 rounded-3xl blur-lg opacity-60 scale-110"></div>
                    <div class="relative p-6 bg-white/10 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-20 w-20 text-amber-300 drop-shadow-lg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                        </svg>
                    </div>
                </div>
                
                <!-- Main Heading -->
                <h1 class="mb-8 text-6xl md:text-7xl font-black leading-tight drop-shadow-2xl">
                    <span class="bg-gradient-to-r from-white via-amber-100 to-amber-200 bg-clip-text text-transparent">
                        Hệ thống Tra cứu
                    </span>
                    <br/>
                    <span class="bg-gradient-to-r from-amber-300 via-yellow-400 to-orange-400 bg-clip-text text-transparent animate-pulse">
                        Lăng Mộ & Nghĩa Địa
                    </span>
                </h1>
                
                <!-- Subtitle -->
                <p class="mb-12 text-xl md:text-2xl text-white/90 max-w-3xl mx-auto leading-relaxed drop-shadow-lg font-medium">
                    Tra cứu thông tin lăng mộ <span class="text-amber-300 font-bold">nhanh chóng</span>, 
                    <span class="text-amber-300 font-bold">chính xác</span>. Hỗ trợ tìm kiếm theo nhiều tiêu chí, 
                    giúp bạn dễ dàng tìm thấy thông tin người thân.
                </p>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                    <a href="{{ route('search') }}" class="group relative px-8 py-4 bg-gradient-to-r from-amber-500 to-orange-500 rounded-2xl shadow-2xl hover:shadow-amber-500/50 transition-all duration-300 hover:scale-105 transform">
                        <div class="absolute inset-0 bg-gradient-to-r from-amber-400 to-orange-400 rounded-2xl blur opacity-0 group-hover:opacity-75 transition-opacity duration-300"></div>
                        <div class="relative flex items-center gap-3 text-white font-bold text-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6 group-hover:rotate-12 transition-transform duration-300">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                            Tra cứu ngay
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 group-hover:translate-x-1 transition-transform duration-300">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </div>
                    </a>
                    
                    <a href="#guide" class="group px-8 py-4 bg-white/10 backdrop-blur-xl rounded-2xl border border-white/30 hover:bg-white/20 hover:border-white/50 transition-all duration-300 hover:scale-105 transform">
                        <div class="flex items-center gap-3 text-white font-semibold text-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6 group-hover:scale-110 transition-transform duration-300">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                            </svg>
                            Hướng dẫn sử dụng
                        </div>
                    </a>
                </div>
                
                <!-- Trust Indicators -->
                <div class="mt-16 flex flex-wrap justify-center items-center gap-8 text-white/70">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-green-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span class="text-sm font-medium">Bảo mật cao</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-blue-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span class="text-sm font-medium">24/7 Hỗ trợ</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-purple-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                        </svg>
                        <span class="text-sm font-medium">Tốc độ nhanh</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Section -->
<div class="mb-20">
    <div class="text-center mb-12">
        <h2 class="text-4xl font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent mb-4">
            Thống kê hệ thống
        </h2>
        <p class="text-lg text-slate-600 max-w-2xl mx-auto">
            Dữ liệu thống kê tổng quan về hệ thống quản lý nghĩa địa
        </p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Cemetery Card -->
        <div class="group relative overflow-hidden rounded-3xl shadow-2xl hover:shadow-3xl transition-all duration-500 hover:-translate-y-2 bg-gradient-to-br from-emerald-500 via-teal-600 to-cyan-600">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-400/20 to-cyan-500/20"></div>
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-white/10 rounded-full blur-xl group-hover:scale-125 transition-transform duration-700"></div>
            
            <div class="relative p-8 text-white">
                <div class="flex justify-between items-start mb-6">
                    <div class="p-4 bg-white/20 backdrop-blur-xl rounded-2xl border border-white/30">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-8 w-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                        </svg>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-medium text-white/80 mb-1">Nghĩa trang</div>
                        <div class="text-xs text-white/60">Đang quản lý</div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="text-5xl font-black drop-shadow-lg mb-2">{{ $cemeteries->count() }}</div>
                    <div class="w-full bg-white/20 rounded-full h-2">
                        <div class="bg-white rounded-full h-2 transition-all duration-1000 ease-out" style="width: {{ min(($cemeteries->count() / 10) * 100, 100) }}%"></div>
                    </div>
                </div>
                
                <div class="flex items-center gap-2 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                    </svg>
                    <span class="text-white/80">Tăng trưởng ổn định</span>
                </div>
            </div>
        </div>
        
        <!-- Graves Card -->
        <div class="group relative overflow-hidden rounded-3xl shadow-2xl hover:shadow-3xl transition-all duration-500 hover:-translate-y-2 bg-gradient-to-br from-blue-500 via-indigo-600 to-purple-600">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-400/20 to-purple-500/20"></div>
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-white/10 rounded-full blur-xl group-hover:scale-125 transition-transform duration-700"></div>
            
            <div class="relative p-8 text-white">
                <div class="flex justify-between items-start mb-6">
                    <div class="p-4 bg-white/20 backdrop-blur-xl rounded-2xl border border-white/30">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-8 w-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                        </svg>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-medium text-white/80 mb-1">Lăng mộ</div>
                        <div class="text-xs text-white/60">Tổng số</div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="text-5xl font-black drop-shadow-lg mb-2">{{ number_format($totalGraves) }}</div>
                    <div class="w-full bg-white/20 rounded-full h-2">
                        <div class="bg-white rounded-full h-2 transition-all duration-1000 ease-out" style="width: {{ min(($totalGraves / 1000) * 100, 100) }}%"></div>
                    </div>
                </div>
                
                <div class="flex items-center gap-2 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                    </svg>
                    <span class="text-white/80">Tăng trưởng mạnh</span>
                </div>
            </div>
        </div>
        
        <!-- Occupied Graves Card -->
        <div class="group relative overflow-hidden rounded-3xl shadow-2xl hover:shadow-3xl transition-all duration-500 hover:-translate-y-2 bg-gradient-to-br from-orange-500 via-red-500 to-pink-600">
            <div class="absolute inset-0 bg-gradient-to-br from-orange-400/20 to-pink-500/20"></div>
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-white/10 rounded-full blur-xl group-hover:scale-125 transition-transform duration-700"></div>
            
            <div class="relative p-8 text-white">
                <div class="flex justify-between items-start mb-6">
                    <div class="p-4 bg-white/20 backdrop-blur-xl rounded-2xl border border-white/30">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-8 w-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-medium text-white/80 mb-1">Đã sử dụng</div>
                        <div class="text-xs text-white/60">Tỷ lệ sử dụng</div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="text-5xl font-black drop-shadow-lg mb-2">{{ number_format($occupiedGraves) }}</div>
                    <div class="w-full bg-white/20 rounded-full h-2">
                        <div class="bg-white rounded-full h-2 transition-all duration-1000 ease-out" style="width: {{ $totalGraves > 0 ? ($occupiedGraves / $totalGraves) * 100 : 0 }}%"></div>
                    </div>
                </div>
                
                <div class="flex items-center gap-2 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                    </svg>
                    <span class="text-white/80">{{ $totalGraves > 0 ? round(($occupiedGraves / $totalGraves) * 100, 1) : 0 }}% tổng số</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Search Section -->
<div class="mb-20">
    <div class="relative overflow-hidden rounded-3xl shadow-2xl bg-gradient-to-br from-white via-blue-50/50 to-indigo-100/50 border border-blue-200/50">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="search-grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="blue" stroke-width="1"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#search-grid)"/>
            </svg>
        </div>
        
        <div class="relative p-8 md:p-12">
            <!-- Header -->
            <div class="text-center mb-12">
                <div class="relative inline-block mb-6">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-2xl blur-lg opacity-30 scale-110"></div>
                    <div class="relative p-4 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-10 w-10 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </div>
                </div>
                
                <h2 class="text-4xl font-bold bg-gradient-to-r from-blue-700 via-indigo-600 to-purple-600 bg-clip-text text-transparent mb-4">
                    Tra cứu nhanh
                </h2>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                    Tìm kiếm thông tin lăng mộ theo nhiều tiêu chí khác nhau một cách nhanh chóng và chính xác
                </p>
            </div>
        
            <!-- Search Form -->
            <form action="{{ route('search') }}" method="GET" class="space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- District -->
                    <div class="form-control group">
                        <label class="label mb-2">
                            <span class="label-text font-semibold text-slate-700 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-blue-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                                Huyện/Thành phố
                            </span>
                        </label>
                        <select name="district" id="district" class="select select-bordered w-full bg-white/80 border-slate-300 focus:border-blue-500 focus:ring-blue-500/20 rounded-xl shadow-sm hover:shadow-md transition-all duration-300">
                            <option value="">Tất cả huyện/thành phố</option>
                            @foreach(['Bình Lục', 'Thanh Liêm', 'Lý Nhân', 'Nam Trực', 'Vụ Bản', 'Ý Yên', 'Trực Ninh', 'Xuân Trường', 'Hải Hậu', 'Giao Thủy', 'Nghĩa Hưng', 'Gia Viễn', 'Nho Quan', 'Yên Khánh', 'Yên Mô', 'Kim Sơn', 'Thành phố Phủ Lý', 'Thành phố Nam Định', 'Thành phố Hoa Lư', 'Thành phố Tam Điệp'] as $district)
                                <option value="{{ $district }}" {{ request('district') == $district ? 'selected' : '' }}>
                                    {{ $district }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Commune -->
                    <div class="form-control group">
                        <label class="label mb-2">
                            <span class="label-text font-semibold text-slate-700 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-green-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                                Xã/Phường/Thị trấn
                            </span>
                        </label>
                        <select name="commune" id="commune" class="select select-bordered w-full bg-white/80 border-slate-300 focus:border-green-500 focus:ring-green-500/20 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 {{ request('district') ? '' : 'opacity-50' }}" {{ request('district') ? '' : 'disabled' }}>
                            <option value="">Tất cả xã/phường</option>
                            @if(request('district'))
                                @php
                                    $communes = config("ninhbinh_locations." . request('district'), []);
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
                    <div class="form-control group">
                        <label class="label mb-2">
                            <span class="label-text font-semibold text-slate-700 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-purple-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                </svg>
                                Nghĩa trang
                            </span>
                        </label>
                        <select name="cemetery_id" class="select select-bordered w-full bg-white/80 border-slate-300 focus:border-purple-500 focus:ring-purple-500/20 rounded-xl shadow-sm hover:shadow-md transition-all duration-300">
                            <option value="">Tất cả nghĩa trang</option>
                            @foreach($cemeteries as $cemetery)
                                <option value="{{ $cemetery->id }}" {{ request('cemetery_id') == $cemetery->id ? 'selected' : '' }}>
                                    {{ $cemetery->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Grave Number -->
                    <div class="form-control group">
                        <label class="label mb-2">
                            <span class="label-text font-semibold text-slate-700 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-orange-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                                </svg>
                                Số lăng mộ
                            </span>
                        </label>
                        <input type="text" name="grave_number" placeholder="Ví dụ: 1-001" class="input input-bordered w-full bg-white/80 border-slate-300 focus:border-orange-500 focus:ring-orange-500/20 rounded-xl shadow-sm hover:shadow-md transition-all duration-300" value="{{ request('grave_number') }}">
                    </div>
                    
                    <!-- Owner Name -->
                    <div class="form-control group">
                        <label class="label mb-2">
                            <span class="label-text font-semibold text-slate-700 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-indigo-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                                Tên chủ lăng mộ
                            </span>
                        </label>
                        <input type="text" name="owner_name" placeholder="Nhập tên chủ lăng mộ" class="input input-bordered w-full bg-white/80 border-slate-300 focus:border-indigo-500 focus:ring-indigo-500/20 rounded-xl shadow-sm hover:shadow-md transition-all duration-300" value="{{ request('owner_name') }}">
                    </div>
                    
                    <!-- Deceased Name -->
                    <div class="form-control group">
                        <label class="label mb-2">
                            <span class="label-text font-semibold text-slate-700 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-rose-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                </svg>
                                Tên người đã khuất
                            </span>
                        </label>
                        <input type="text" name="deceased_name" placeholder="Nhập tên người đã khuất" class="input input-bordered w-full bg-white/80 border-slate-300 focus:border-rose-500 focus:ring-rose-500/20 rounded-xl shadow-sm hover:shadow-md transition-all duration-300" value="{{ request('deceased_name') }}">
                    </div>
                </div>
                
                <!-- Submit Button -->
                <div class="flex justify-center pt-6">
                    <button type="submit" class="group relative px-12 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-lg rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 transform">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-2xl blur opacity-0 group-hover:opacity-75 transition-opacity duration-300"></div>
                        <div class="relative flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6 group-hover:rotate-12 transition-transform duration-300">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                            Tìm kiếm ngay
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 group-hover:translate-x-1 transition-transform duration-300">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </div>
                    </button>
                </div>
            </form>
        </div>
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

