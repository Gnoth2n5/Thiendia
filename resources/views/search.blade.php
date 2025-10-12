@extends('layouts.app')

@section('title', 'Kết quả tìm kiếm - Quản lý Nghĩa Địa')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="text-center mb-8">
        <div class="relative inline-block mb-6">
            <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-blue-500 rounded-full blur-xl opacity-30 animate-pulse"></div>
            <div class="relative p-4 bg-gradient-to-br from-green-500 to-blue-600 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-12 w-12 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </div>
        </div>
        <h1 class="text-4xl font-bold bg-gradient-to-r from-green-700 via-blue-600 to-indigo-600 bg-clip-text text-transparent mb-4">
            Tìm kiếm lăng mộ
        </h1>
        <p class="text-lg text-slate-600 max-w-2xl mx-auto">
            Nhập thông tin để tra cứu lăng mộ tại các nghĩa trang Ninh Bình
        </p>
    </div>
</div>

<!-- Search Form -->
<div class="card bg-gradient-to-br from-white via-slate-50/50 to-green-50/30 shadow-xl mb-8 border border-green-200/50">
    <div class="card-body">
        <h2 class="card-title text-2xl text-slate-800 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6 text-green-600">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
            </svg>
            Bộ lọc tìm kiếm
        </h2>
        <form action="{{ route('search') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Xã/Phường/Thị trấn</span>
                    </label>
                    <select name="commune" id="commune" class="select select-bordered w-full">
                        <option value="">Tất cả xã/phường</option>
                        {{-- Danh sách sẽ được load từ API bằng JavaScript --}}
                    </select>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Nghĩa trang</span>
                    </label>
                    <select name="cemetery_id" id="cemetery_id" class="select select-bordered w-full">
                        <option value="">Tất cả nghĩa trang</option>
                        {{-- Danh sách sẽ được filter theo xã/phường bằng JavaScript --}}
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
                <a href="{{ route('search') }}" class="btn btn-ghost gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                    Xóa bộ lọc
                </a>
                <button type="submit" class="relative inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
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
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 bg-gradient-to-br from-white via-slate-50/50 to-green-50/30 border border-green-200/50">
                    <!-- Background Effects -->
                    <div class="absolute inset-0 bg-gradient-to-br from-green-100/20 to-blue-100/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative card-body">
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
                            <div class="bg-gradient-to-br from-base-200 to-base-300 rounded-xl p-4 mb-3">
                                <div class="flex items-start gap-4">
                                    @if($grave->deceased_photo)
                                        <div class="flex-shrink-0">
                                            <div class="w-20 h-24 rounded-lg overflow-hidden shadow-md ring-2 ring-primary/20">
                                                <img src="{{ Storage::url($grave->deceased_photo) }}" alt="{{ $grave->deceased_full_name }}" class="w-full h-full object-cover" />
                                            </div>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs text-base-content/60 mb-1">Người đã khuất</p>
                                        <p class="font-bold text-sm mb-1">{{ $grave->deceased_full_name }}</p>
                                        @if($grave->deceased_birth_date && $grave->deceased_death_date)
                                            <p class="text-xs text-base-content/70 mb-1">
                                                <span class="font-medium">Sinh:</span> {{ $grave->deceased_birth_date->format('d/m/Y') }}
                                            </p>
                                            <p class="text-xs text-base-content/70">
                                                <span class="font-medium">Mất:</span> {{ $grave->deceased_death_date->format('d/m/Y') }}
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
                            <a href="{{ route('grave.show', $grave->id) }}" class="relative inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 text-sm">
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const communeSelect = document.getElementById('commune');
    const cemeterySelect = document.getElementById('cemetery_id');
    const selectedCommune = '{{ request("commune") }}';
    const selectedCemetery = '{{ request("cemetery_id") }}';
    
    // Lấy danh sách nghĩa trang từ server (bao gồm cả commune)
    const allCemeteries = @json($cemeteries->map(function($c) {
        return [
            'id' => $c->id,
            'name' => $c->name,
            'commune' => $c->commune
        ];
    }));

    // Load danh sách xã/phường từ API khi trang load
    fetch('/api/communes')
        .then(response => response.json())
        .then(result => {
            if (result.success && result.data) {
                // Xóa các option cũ (trừ option đầu tiên)
                communeSelect.innerHTML = '<option value="">Tất cả xã/phường</option>';
                
                // Thêm các option mới từ API
                result.data.forEach(commune => {
                    const option = document.createElement('option');
                    option.value = commune;
                    option.textContent = commune;
                    
                    // Giữ lại selection nếu có
                    if (commune === selectedCommune) {
                        option.selected = true;
                    }
                    
                    communeSelect.appendChild(option);
                });
                
                console.log(`Loaded ${result.data.length} communes from API`);
                
                // Load nghĩa trang ban đầu
                filterCemeteries(selectedCommune);
            }
        })
        .catch(error => {
            console.error('Error loading communes:', error);
            // Nếu lỗi, vẫn load tất cả nghĩa trang
            filterCemeteries('');
        });

    // Hàm filter nghĩa trang theo xã/phường
    function filterCemeteries(commune) {
        // Reset dropdown nghĩa trang
        cemeterySelect.innerHTML = '<option value="">Tất cả nghĩa trang</option>';
        
        // Lọc nghĩa trang
        let filteredCemeteries = allCemeteries;
        if (commune) {
            filteredCemeteries = allCemeteries.filter(c => c.commune === commune);
        }
        
        // Thêm các option
        filteredCemeteries.forEach(cemetery => {
            const option = document.createElement('option');
            option.value = cemetery.id;
            option.textContent = cemetery.name;
            
            // Giữ lại selection nếu có
            if (cemetery.id == selectedCemetery) {
                option.selected = true;
            }
            
            cemeterySelect.appendChild(option);
        });
        
        console.log(`Filtered ${filteredCemeteries.length} cemeteries for commune: ${commune || 'all'}`);
    }

    // Xử lý khi chọn xã/phường
    communeSelect.addEventListener('change', function() {
        filterCemeteries(this.value);
    });
});
</script>
@endpush


