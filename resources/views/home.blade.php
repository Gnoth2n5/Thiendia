@extends('layouts.app')

@section('title', 'Trang chủ - Quản lý Nghĩa Địa')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden rounded-2xl shadow-2xl mb-12" style="background: linear-gradient(135deg, #0f766e 0%, #115e59 50%, #134e4a 100%);">
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(#grid)"/></svg>
    </div>
    <div class="absolute top-0 right-0 w-1/2 h-full opacity-5">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="white" class="w-full h-full">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
        </svg>
    </div>
    <div class="relative hero min-h-[450px]">
        <div class="hero-content text-center text-white py-16">
            <div class="max-w-3xl">
                <div class="inline-block p-4 bg-white/10 backdrop-blur-md rounded-2xl mb-6 shadow-xl border border-white/20">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-16 w-16 text-amber-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                    </svg>
                </div>
                <h1 class="mb-6 text-5xl font-bold leading-tight drop-shadow-lg">
                    Hệ thống Tra cứu Thông tin<br/>
                    <span class="text-amber-300">Lăng Mộ & Nghĩa Địa</span>
                </h1>
                <p class="mb-8 text-lg text-white/95 max-w-2xl mx-auto leading-relaxed drop-shadow">
                    Tra cứu thông tin lăng mộ nhanh chóng, chính xác. Hỗ trợ tìm kiếm theo nhiều tiêu chí, 
                    giúp bạn dễ dàng tìm thấy thông tin người thân.
                </p>
                <div class="flex gap-4 justify-center flex-wrap">
                    <a href="{{ route('search') }}" class="btn btn-accent btn-lg gap-2 shadow-2xl hover:shadow-amber-500/50 transition-all hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        Tra cứu ngay
                    </a>
                    <a href="#guide" class="btn btn-outline btn-lg gap-2 text-white border-white/40 hover:bg-white/15 hover:border-white/60 backdrop-blur">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                        </svg>
                        Hướng dẫn
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
    <div class="card shadow-xl hover:shadow-2xl transition-all hover:-translate-y-1 relative overflow-hidden" style="background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%);">
        <div class="absolute top-0 right-0 w-32 h-32 opacity-10">
            <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24" class="w-full h-full">
                <path d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
            </svg>
        </div>
        <div class="card-body text-white relative z-10">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-sm font-medium text-white/80 mb-1">Nghĩa trang</h3>
                    <p class="text-5xl font-bold mb-1 drop-shadow-lg">{{ $cemeteries->count() }}</p>
                    <p class="text-sm text-white/90">Đang quản lý</p>
                </div>
                <div class="p-3 bg-white/20 backdrop-blur rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-10 w-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card shadow-xl hover:shadow-2xl transition-all hover:-translate-y-1 relative overflow-hidden" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);">
        <div class="absolute top-0 right-0 w-32 h-32 opacity-10">
            <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24" class="w-full h-full">
                <path d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
            </svg>
        </div>
        <div class="card-body text-white relative z-10">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-sm font-medium text-white/80 mb-1">Lăng mộ</h3>
                    <p class="text-5xl font-bold mb-1 drop-shadow-lg">{{ number_format($totalGraves) }}</p>
                    <p class="text-sm text-white/90">Tổng số trong hệ thống</p>
                </div>
                <div class="p-3 bg-white/20 backdrop-blur rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-10 w-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card shadow-xl hover:shadow-2xl transition-all hover:-translate-y-1 relative overflow-hidden" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
        <div class="absolute top-0 right-0 w-32 h-32 opacity-10">
            <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24" class="w-full h-full">
                <path d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </div>
        <div class="card-body text-white relative z-10">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-sm font-medium text-white/80 mb-1">Đã sử dụng</h3>
                    <p class="text-5xl font-bold mb-1 drop-shadow-lg">{{ number_format($occupiedGraves) }}</p>
                    <p class="text-sm text-white/90">{{ $totalGraves > 0 ? round(($occupiedGraves / $totalGraves) * 100, 1) : 0 }}% tổng số</p>
                </div>
                <div class="p-3 bg-white/20 backdrop-blur rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-10 w-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Search -->
<div class="card bg-gradient-to-br from-white to-teal-50/50 shadow-xl mb-12 border-2 border-teal-100">
    <div class="card-body">
        <div class="flex items-center gap-3 mb-6">
            <div class="p-3 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold bg-gradient-to-r from-teal-700 to-teal-600 bg-clip-text text-transparent">Tra cứu nhanh</h2>
                <p class="text-sm text-base-content/70">Tìm kiếm thông tin lăng mộ theo nhiều tiêu chí</p>
            </div>
        </div>
        
        <form action="{{ route('search') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Số lăng mộ</span>
                    </label>
                    <input type="text" name="grave_number" placeholder="Ví dụ: 1-001" class="input input-bordered w-full" value="{{ request('grave_number') }}">
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Tên chủ lăng mộ</span>
                    </label>
                    <input type="text" name="owner_name" placeholder="Nhập tên chủ lăng mộ" class="input input-bordered w-full" value="{{ request('owner_name') }}">
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Tên người đã khuất</span>
                    </label>
                    <input type="text" name="deceased_name" placeholder="Nhập tên người đã khuất" class="input input-bordered w-full" value="{{ request('deceased_name') }}">
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Nghĩa trang</span>
                    </label>
                    <select name="cemetery_id" class="select select-bordered w-full">
                        <option value="">Tất cả nghĩa trang</option>
                        @foreach($cemeteries as $cemetery)
                            <option value="{{ $cemetery->id }}" {{ request('cemetery_id') == $cemetery->id ? 'selected' : '' }}>
                                {{ $cemetery->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="btn btn-primary btn-lg gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    Tìm kiếm
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Cemeteries List -->
<div class="mb-12">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <div class="p-3 bg-gradient-to-br from-violet-500 to-violet-600 rounded-xl shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold bg-gradient-to-r from-violet-700 to-violet-600 bg-clip-text text-transparent">Danh sách Nghĩa trang</h2>
                <p class="text-sm text-base-content/70">{{ $cemeteries->count() }} nghĩa trang đang quản lý</p>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($cemeteries as $cemetery)
            <div class="card bg-gradient-to-br from-white to-violet-50/30 shadow-lg hover:shadow-2xl transition-all hover:-translate-y-2 border-2 border-violet-100 group">
                <div class="card-body">
                    <div class="flex items-start gap-3 mb-3">
                        <div class="p-2 bg-gradient-to-br from-amber-400 to-amber-500 rounded-xl shadow-md group-hover:scale-110 transition-transform shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-lg text-neutral group-hover:text-teal-700 transition-colors">{{ $cemetery->name }}</h3>
                            <p class="text-sm text-base-content/70 mt-1">{{ $cemetery->address }}</p>
                        </div>
                    </div>
                    
                    @if($cemetery->description)
                        <p class="text-sm text-base-content/80 line-clamp-2 mb-3">{{ $cemetery->description }}</p>
                    @endif
                    
                    <div class="divider my-2"></div>
                    
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <div class="badge badge-primary gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-3 w-3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                </svg>
                                {{ $cemetery->graves_count }}
                            </div>
                            <span class="text-xs text-base-content/60">lăng mộ</span>
                        </div>
                        <a href="{{ route('search', ['cemetery_id' => $cemetery->id]) }}" class="btn btn-primary btn-sm gap-2 group-hover:btn-accent transition-colors">
                            Xem
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4 group-hover:translate-x-1 transition-transform">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

