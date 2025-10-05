@extends('layouts.app')

@section('title', 'Trang chủ - Quản lý Nghĩa Địa')

@section('content')
<!-- Hero Section -->
<div class="hero min-h-[400px] bg-gradient-to-r from-primary to-secondary rounded-box shadow-2xl mb-8">
    <div class="hero-content text-center text-neutral-content">
        <div class="max-w-md">
            <h1 class="mb-5 text-5xl font-bold text-white">Tra cứu Thông tin Lăng Mộ</h1>
            <p class="mb-5 text-lg text-base-100">
                Hệ thống tra cứu thông tin lăng mộ trực tuyến, giúp bạn dễ dàng tìm kiếm và quản lý thông tin người thân
            </p>
            <a href="{{ route('search') }}" class="btn btn-accent btn-lg gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                Bắt đầu tìm kiếm
            </a>
        </div>
    </div>
</div>

<!-- Stats -->
<div class="stats stats-vertical lg:stats-horizontal shadow w-full mb-8 bg-base-100">
    <div class="stat">
        <div class="stat-figure text-primary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
        </div>
        <div class="stat-title">Tổng số nghĩa trang</div>
        <div class="stat-value text-primary">{{ $cemeteries->count() }}</div>
        <div class="stat-desc">Đang quản lý</div>
    </div>
    
    <div class="stat">
        <div class="stat-figure text-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
        </div>
        <div class="stat-title">Tổng số lăng mộ</div>
        <div class="stat-value text-secondary">{{ number_format($totalGraves) }}</div>
        <div class="stat-desc">Trong hệ thống</div>
    </div>
    
    <div class="stat">
        <div class="stat-figure text-success">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
        </div>
        <div class="stat-title">Đã sử dụng</div>
        <div class="stat-value text-success">{{ number_format($occupiedGraves) }}</div>
        <div class="stat-desc">{{ $totalGraves > 0 ? round(($occupiedGraves / $totalGraves) * 100, 1) : 0 }}% tổng số</div>
    </div>
</div>

<!-- Cemeteries List -->
<div class="mb-8">
    <h2 class="text-3xl font-bold mb-6 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
        Danh sách Nghĩa trang
    </h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($cemeteries as $cemetery)
            <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow">
                <div class="card-body">
                    <h3 class="card-title text-primary">{{ $cemetery->name }}</h3>
                    <p class="text-sm text-base-content/70">{{ $cemetery->address }}</p>
                    
                    @if($cemetery->description)
                        <p class="text-sm mt-2">{{ Str::limit($cemetery->description, 100) }}</p>
                    @endif
                    
                    <div class="divider my-2"></div>
                    
                    <div class="flex justify-between items-center">
                        <div class="badge badge-secondary badge-lg">
                            {{ $cemetery->graves_count }} lăng mộ
                        </div>
                        <a href="{{ route('search', ['cemetery_id' => $cemetery->id]) }}" class="btn btn-primary btn-sm">
                            Xem chi tiết
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Quick Search -->
<div class="card bg-base-100 shadow-xl">
    <div class="card-body">
        <h2 class="card-title text-2xl mb-4">Tìm kiếm nhanh</h2>
        <form action="{{ route('search') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" name="grave_number" placeholder="Số lăng mộ" class="input input-bordered" value="{{ request('grave_number') }}">
            <input type="text" name="owner_name" placeholder="Tên chủ lăng mộ" class="input input-bordered" value="{{ request('owner_name') }}">
            <input type="text" name="deceased_name" placeholder="Tên người đã khuất" class="input input-bordered" value="{{ request('deceased_name') }}">
            <button type="submit" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                Tìm kiếm
            </button>
        </form>
    </div>
</div>
@endsection

