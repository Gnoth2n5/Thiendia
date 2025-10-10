@extends('layouts.app')

@section('title', 'Kết quả tìm kiếm - Quản lý Nghĩa Địa')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center gap-3 mb-4">
        <div class="p-2 bg-primary/10 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6 text-primary">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
        </div>
        <div>
            <h1 class="text-3xl font-bold text-neutral">Tìm kiếm lăng mộ</h1>
            <p class="text-base-content/60">Nhập thông tin để tra cứu</p>
        </div>
    </div>
</div>

<!-- Search Form -->
<div class="card bg-base-100 shadow-xl mb-8 border border-base-300">
    <div class="card-body">
        <form action="{{ route('search') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Huyện/Thành phố</span>
                    </label>
                    <select name="district" id="district" class="select select-bordered w-full">
                        <option value="">Tất cả huyện/thành phố</option>
                        @foreach($districts as $district)
                            <option value="{{ $district }}" {{ request('district') == $district ? 'selected' : '' }}>
                                {{ $district }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Xã/Phường/Thị trấn</span>
                    </label>
                    <select name="commune" id="commune" class="select select-bordered w-full" {{ request('district') ? '' : 'disabled' }}>
                        <option value="">Tất cả xã/phường</option>
                        @foreach($communes as $commune)
                            <option value="{{ $commune }}" {{ request('commune') == $commune ? 'selected' : '' }}>
                                {{ $commune }}
                            </option>
                        @endforeach
                    </select>
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
            </div>
            
            <div class="flex gap-3 justify-end">
                <a href="{{ route('search') }}" class="btn btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                    Xóa bộ lọc
                </a>
                <button type="submit" class="btn btn-primary gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    Tìm kiếm
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Search Results -->
<div class="search-results-content">
    @if(request()->hasAny(['grave_number', 'owner_name', 'deceased_name', 'cemetery_id', 'district', 'commune']))
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-neutral">Kết quả tìm kiếm</h2>
                    <p class="text-sm text-base-content/60 search-result-count">Tìm thấy {{ $graves->total() }} lăng mộ</p>
                </div>
            </div>
        </div>

    @if($graves->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($graves as $grave)
                <div class="card bg-base-100 shadow-lg hover:shadow-xl transition-all hover:-translate-y-1 border border-base-300">
                    <div class="card-body">
                        <!-- Header -->
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <div class="badge badge-primary mb-2">{{ $grave->grave_number }}</div>
                                <h3 class="font-bold text-lg text-neutral">{{ $grave->owner_name }}</h3>
                            </div>
                            <div class="badge {{ $grave->status === 'đã_sử_dụng' ? 'badge-success' : 'badge-ghost' }}">
                                {{ $grave->status_label }}
                            </div>
                        </div>

                        <!-- Cemetery Info -->
                        <div class="flex items-center gap-2 text-sm text-base-content/70 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                            <span>{{ $grave->cemetery->name }}</span>
                        </div>

                        <!-- Deceased Person -->
                        @if($grave->deceased_full_name)
                            <div class="bg-base-200 rounded-lg p-3 mb-3">
                                <div class="flex items-center gap-3">
                                    @if($grave->deceased_photo)
                                        <div class="avatar">
                                            <div class="w-12 h-12 rounded-full">
                                                <img src="{{ Storage::url($grave->deceased_photo) }}" alt="{{ $grave->deceased_full_name }}" class="object-cover" />
                                            </div>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <p class="text-xs text-base-content/60 mb-1">Người đã khuất</p>
                                        <p class="font-medium text-sm">{{ $grave->deceased_full_name }}</p>
                                        @if($grave->deceased_birth_date && $grave->deceased_death_date)
                                            <p class="text-xs text-base-content/60 mt-1">
                                                {{ $grave->deceased_birth_date->format('d/m/Y') }} - {{ $grave->deceased_death_date->format('d/m/Y') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Additional Info -->
                        <div class="space-y-1 text-sm mb-3">
                            <div class="flex items-center gap-2">
                                <span class="text-base-content/60">Loại:</span>
                                <span class="font-medium">{{ $grave->grave_type_label }}</span>
                            </div>
                            @if($grave->burial_date)
                                <div class="flex items-center gap-2">
                                    <span class="text-base-content/60">An táng:</span>
                                    <span class="font-medium">{{ $grave->burial_date->format('d/m/Y') }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="divider my-2"></div>

                        <!-- Actions -->
                        <div class="flex justify-end">
                            <a href="{{ route('grave.show', $grave->id) }}" class="btn btn-primary btn-sm gap-2">
                                Xem chi tiết
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $graves->appends(request()->query())->links() }}
        </div>
    @else
        <div class="card bg-base-100 shadow-lg border border-base-300">
            <div class="card-body text-center py-16">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-16 w-16 mx-auto text-base-content/30 mb-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <h3 class="text-xl font-bold text-neutral mb-2">Không tìm thấy kết quả</h3>
                <p class="text-base-content/60 mb-4">Vui lòng thử lại với thông tin khác hoặc mở rộng tiêu chí tìm kiếm</p>
                <a href="{{ route('search') }}" class="btn btn-ghost">Xóa bộ lọc</a>
            </div>
        </div>
    @endif
    @else
        <!-- Empty State -->
        <div class="card bg-base-100 shadow-lg border border-base-300">
            <div class="card-body text-center py-16">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-16 w-16 mx-auto text-primary/50 mb-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <h3 class="text-xl font-bold text-neutral mb-2">Bắt đầu tìm kiếm</h3>
                <p class="text-base-content/60">Nhập thông tin vào form phía trên để tra cứu lăng mộ</p>
            </div>
        </div>
    @endif
</div>
@endsection

{{-- Temporarily disabled JavaScript to test form submission --}}


