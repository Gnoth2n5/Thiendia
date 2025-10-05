@extends('layouts.app')

@section('title', 'Trang chủ - Quản lý Nghĩa Địa')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden rounded-xl shadow-xl mb-12" style="background: linear-gradient(135deg, #374151 0%, #1f2937 100%);">
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(#grid)"/></svg>
    </div>
    <div class="relative hero min-h-[450px]">
        <div class="hero-content text-center text-white py-16">
            <div class="max-w-3xl">
                <div class="inline-block p-3 bg-white/10 backdrop-blur rounded-2xl mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-16 w-16 text-accent">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                    </svg>
                </div>
                <h1 class="mb-6 text-5xl font-bold leading-tight">
                    Hệ thống Tra cứu Thông tin<br/>
                    <span class="text-accent">Lăng Mộ & Nghĩa Địa</span>
                </h1>
                <p class="mb-8 text-lg text-white/90 max-w-2xl mx-auto leading-relaxed">
                    Tra cứu thông tin lăng mộ nhanh chóng, chính xác. Hỗ trợ tìm kiếm theo nhiều tiêu chí, 
                    giúp bạn dễ dàng tìm thấy thông tin người thân.
                </p>
                <div class="flex gap-4 justify-center flex-wrap">
                    <a href="{{ route('search') }}" class="btn btn-accent btn-lg gap-2 shadow-lg hover:shadow-xl transition-shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        Tra cứu ngay
                    </a>
                    <a href="#guide" class="btn btn-outline btn-lg gap-2 text-white border-white/30 hover:bg-white/10 hover:border-white/50">
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
    <div class="card bg-base-100 border-2 border-primary/20 shadow-lg hover:shadow-xl hover:border-primary/40 transition-all">
        <div class="card-body">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-sm font-medium text-base-content/60 mb-1">Nghĩa trang</h3>
                    <p class="text-5xl font-bold text-primary mb-1">{{ $cemeteries->count() }}</p>
                    <p class="text-sm text-base-content/60">Đang quản lý</p>
                </div>
                <div class="p-3 bg-primary/10 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-10 w-10 text-primary">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card bg-base-100 border-2 border-info/20 shadow-lg hover:shadow-xl hover:border-info/40 transition-all">
        <div class="card-body">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-sm font-medium text-base-content/60 mb-1">Lăng mộ</h3>
                    <p class="text-5xl font-bold text-info mb-1">{{ number_format($totalGraves) }}</p>
                    <p class="text-sm text-base-content/60">Tổng số trong hệ thống</p>
                </div>
                <div class="p-3 bg-info/10 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-10 w-10 text-info">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card bg-base-100 border-2 border-success/20 shadow-lg hover:shadow-xl hover:border-success/40 transition-all">
        <div class="card-body">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-sm font-medium text-base-content/60 mb-1">Đã sử dụng</h3>
                    <p class="text-5xl font-bold text-success mb-1">{{ number_format($occupiedGraves) }}</p>
                    <p class="text-sm text-base-content/60">{{ $totalGraves > 0 ? round(($occupiedGraves / $totalGraves) * 100, 1) : 0 }}% tổng số</p>
                </div>
                <div class="p-3 bg-success/10 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-10 w-10 text-success">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Search -->
<div class="card bg-base-100 shadow-xl mb-12 border border-base-300">
    <div class="card-body">
        <div class="flex items-center gap-3 mb-6">
            <div class="p-2 bg-primary/10 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6 text-primary">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-neutral">Tra cứu nhanh</h2>
                <p class="text-sm text-base-content/60">Tìm kiếm thông tin lăng mộ theo nhiều tiêu chí</p>
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
            <div class="p-2 bg-primary/10 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6 text-primary">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-neutral">Danh sách Nghĩa trang</h2>
                <p class="text-sm text-base-content/60">{{ $cemeteries->count() }} nghĩa trang đang quản lý</p>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($cemeteries as $cemetery)
            <div class="card bg-base-100 shadow-lg hover:shadow-xl transition-all hover:-translate-y-1 border border-base-300">
                <div class="card-body">
                    <div class="flex items-start gap-3 mb-3">
                        <div class="p-2 bg-primary/10 rounded-lg shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6 text-primary">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-lg text-neutral">{{ $cemetery->name }}</h3>
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
                        <a href="{{ route('search', ['cemetery_id' => $cemetery->id]) }}" class="btn btn-primary btn-sm gap-2">
                            Xem
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
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

