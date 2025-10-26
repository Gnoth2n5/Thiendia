@extends('layouts.app')

@section('title', 'Liệt sĩ ' . $grave->deceased_full_name . ' - Tra cứu liệt sĩ tỉnh Ninh Bình')

@section('content')
    <!-- Breadcrumb -->
    <div class="text-sm breadcrumbs mb-6">
        <ul>
            <li>
                <a href="{{ route('home') }}" class="text-green-600 hover:underline">Trang chủ</a>
            </li>
            <li>
                <a href="{{ route('search') }}" class="text-green-600 hover:underline">Tìm kiếm</a>
            </li>
            <li class="text-base-content/60">{{ $grave->deceased_full_name }}</li>
        </ul>
    </div>

    <!-- Page Header -->
    <div class="mb-8">
        <div class="text-center mb-8">
            <div class="relative inline-block mb-6">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-green-400 to-blue-500 rounded-full blur-xl opacity-30 animate-pulse">
                </div>
                <div class="relative p-4 bg-gradient-to-br from-purple-500 to-red-500 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="h-12 w-12 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                    </svg>
                </div>
            </div>
            <div class="flex items-center justify-center gap-3 mb-2">
                <h1 class="text-4xl font-bold bg-gradient-to-r from-purple-700 to-red-600 bg-clip-text text-transparent">
                   Liệt Sỹ {{ $grave->deceased_full_name }}
                </h1>
            </div>
            <p class="text-lg text-slate-600 mb-6">{{ $grave->cemetery->name }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div
                class="card bg-gradient-to-br from-white via-slate-50/50 to-green-50/30 shadow-xl border border-green-200/50">
                <div class="card-body">
                    <h2 class="card-title text-xl mb-4">Thông tin cơ bản</h2>

                    <div class="space-y-4">
                        <div class="flex items-start gap-3 p-3 bg-base-200 rounded-lg">
                            <div class="p-2 bg-primary/10 rounded-lg shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" class="h-5 w-5 text-primary">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-base-content/60">Người quản lý mộ</p>
                                <p class="font-bold text-lg">{{ $grave->caretaker_name ?? 'Chưa có thông tin' }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-base-content/60 mb-1">Loại mộ</p>
                                <p class="font-medium">{{ $grave->grave_type_label }}</p>
                            </div>

                            @if ($grave->burial_date)
                                <div>
                                    <p class="text-sm text-base-content/60 mb-1">Ngày an táng</p>
                                    <p class="font-medium">{{ $grave->burial_date->format('d/m/Y') }}</p>
                                </div>
                            @endif

                            @if ($grave->plot)
                                <div>
                                    <p class="text-sm text-base-content/60 mb-1">Lô mộ</p>
                                    <p class="font-medium text-primary">{{ $grave->plot->plot_code }}</p>
                                </div>

                                <div>
                                    <p class="text-sm text-base-content/60 mb-1">Vị trí trong lưới</p>
                                    <p class="font-medium">Hàng {{ $grave->plot->row }}, Cột {{ $grave->plot->column }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deceased Person Information -->
            @if ($grave->deceased_full_name)
                <div
                    class="card bg-gradient-to-br from-white via-slate-50/50 to-green-50/30 shadow-xl border border-green-200/50">
                    <div class="card-body">
                        <h2 class="card-title text-xl mb-4">Thông tin người đã khuất</h2>

                        <div class="space-y-4">
                            <div class="p-6 bg-gradient-to-br from-base-200 to-base-300 rounded-xl">
                                <div class="flex items-start gap-6 mb-6">
                                    @if ($grave->deceased_photo)
                                        <div class="flex-shrink-0">
                                            <div class="w-32 h-40 rounded-xl overflow-hidden shadow-xl ring-4 ring-white/50 cursor-pointer group relative"
                                                onclick="openImageModal('{{ Storage::url($grave->deceased_photo) }}')">
                                                <img src="{{ Storage::url($grave->deceased_photo) }}"
                                                    alt="{{ $grave->deceased_full_name }}"
                                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                                                <div
                                                    class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-all duration-300 flex items-center justify-center">
                                                    <div
                                                        class="bg-white/20 backdrop-blur-sm rounded-full p-2 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:scale-110">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                            class="h-5 w-5 text-white">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-32 h-40 bg-gradient-to-br from-slate-200 to-slate-300 rounded-xl flex items-center justify-center shadow-xl ring-4 ring-white/50">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor"
                                                    class="h-16 w-16 text-slate-400">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                                </svg>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <p class="font-bold text-2xl mb-2">{{ $grave->deceased_full_name }}</p>
                                        
                                        @if ($grave->rank_and_unit)
                                            <p class="text-base text-primary font-semibold mb-2">
                                                {{ $grave->rank_and_unit }}
                                            </p>
                                        @endif
                                        
                                        @if ($grave->position)
                                            <p class="text-sm text-base-content/70 mb-2">
                                                Chức vụ: <span class="font-semibold">{{ $grave->position }}</span>
                                            </p>
                                        @endif
                                        
                                        @if ($grave->deceased_gender)
                                            <div
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/50">
                                                {{ ucfirst($grave->deceased_gender) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @if ($grave->birth_year)
                                        <div class="bg-white/50 rounded-lg p-3">
                                            <p class="text-xs text-base-content/60 mb-1">Năm sinh</p>
                                            <p class="font-bold text-lg">{{ $grave->birth_year }}</p>
                                        </div>
                                    @endif
                                    
                                    @if ($grave->deceased_birth_date)
                                        <div class="bg-white/50 rounded-lg p-3">
                                            <p class="text-xs text-base-content/60 mb-1">Ngày sinh đầy đủ</p>
                                            <p class="font-bold text-base">{{ $grave->deceased_birth_date->format('d/m/Y') }}
                                            </p>
                                        </div>
                                    @endif

                                    @if ($grave->deceased_death_date)
                                        <div class="bg-white/50 rounded-lg p-3">
                                            <p class="text-xs text-base-content/60 mb-1">Ngày hy sinh</p>
                                            <p class="font-bold text-lg text-error">{{ $grave->deceased_death_date->format('d/m/Y') }}
                                            </p>
                                        </div>
                                    @endif
                                    
                                    @if ($grave->certificate_number)
                                        <div class="bg-white/50 rounded-lg p-3">
                                            <p class="text-xs text-base-content/60 mb-1">Số bằng TQGC</p>
                                            <p class="font-bold text-base">{{ $grave->certificate_number }}</p>
                                        </div>
                                    @endif
                                    
                                    @if ($grave->decision_number)
                                        <div class="bg-white/50 rounded-lg p-3">
                                            <p class="text-xs text-base-content/60 mb-1">Số QĐ</p>
                                            <p class="font-bold text-base">{{ $grave->decision_number }}</p>
                                        </div>
                                    @endif
                                    
                                    @if ($grave->decision_date)
                                        <div class="bg-white/50 rounded-lg p-3">
                                            <p class="text-xs text-base-content/60 mb-1">Ngày cấp QĐ</p>
                                            <p class="font-bold text-base">{{ $grave->decision_date->format('d/m/Y') }}</p>
                                        </div>
                                    @endif
                                    
                                    @if ($grave->next_of_kin)
                                        <div class="bg-white/50 rounded-lg p-3">
                                            <p class="text-xs text-base-content/60 mb-1">Thân nhân</p>
                                            <p class="font-bold text-base">{{ $grave->next_of_kin }}</p>
                                        </div>
                                    @endif
                                    
                                    @if ($grave->deceased_relationship)
                                        <div class="bg-white/50 rounded-lg p-3">
                                            <p class="text-xs text-base-content/60 mb-1">Quan hệ</p>
                                            <p class="font-bold text-base">{{ $grave->deceased_relationship }}</p>
                                        </div>
                                    @endif
                                </div>

                                @if ($grave->deceased_birth_date && $grave->deceased_death_date)
                                    <div class="mt-4 pt-4 border-t border-white/50">
                                        <div class="flex items-center gap-2">

                                            <p class="text-sm font-bold text-slate-700">
                                                Hưởng thọ: <span
                                                    class="text-lg font-bold text-green-700">{{ $grave->deceased_birth_date->diffInYears($grave->deceased_death_date) }}</span>
                                                tuổi
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Location & Notes -->
            @if ($grave->location_description || $grave->notes)
                <div
                    class="card bg-gradient-to-br from-white via-slate-50/50 to-green-50/30 shadow-xl border border-green-200/50">
                    <div class="card-body">
                        <h2 class="card-title text-xl mb-4">Thông tin bổ sung</h2>

                        @if ($grave->location_description)
                            <div class="mb-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="h-5 w-5 text-primary">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                    </svg>
                                    <p class="font-medium">Vị trí</p>
                                </div>
                                <p class="text-base-content/80 ml-7">{{ $grave->location_description }}</p>
                            </div>
                        @endif

                        @if ($grave->notes)
                            <div>
                                <div class="flex items-center gap-2 mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="h-5 w-5 text-primary">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                    <p class="font-medium">Ghi chú</p>
                                </div>
                                <p class="text-base-content/80 ml-7">{{ $grave->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Map Location -->
            @if ($grave->latitude && $grave->longitude)
                <div
                    class="card bg-gradient-to-br from-white via-slate-50/50 to-green-50/30 shadow-xl border border-green-200/50">
                    <div class="card-body">
                        <h2 class="card-title text-xl mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="h-6 w-6 text-primary">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z" />
                            </svg>
                            Vị trí trên bản đồ
                        </h2>

                        <div id="grave-map" class="w-full rounded-lg shadow-md relative z-10" style="height: 400px;">
                        </div>

                        <div class="mt-4 flex flex-wrap gap-4 text-sm text-base-content/70">
                            <div class="flex items-center gap-2">
                                <span class="font-medium">Vĩ độ:</span>
                                <span class="font-mono">{{ $grave->latitude }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="font-medium">Kinh độ:</span>
                                <span class="font-mono">{{ $grave->longitude }}</span>
                            </div>
                            <a href="https://www.google.com/maps?q={{ $grave->latitude }},{{ $grave->longitude }}"
                                target="_blank"
                                class="inline-flex items-center gap-1 text-primary hover:text-primary-focus transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                </svg>
                                Mở trong Google Maps
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Grave Photos -->
            @if ($grave->grave_photos && count($grave->grave_photos) > 0)
                <div
                    class="card bg-gradient-to-br from-white via-slate-50/50 to-green-50/30 shadow-xl border border-green-200/50">
                    <div class="card-body">
                        <h2 class="card-title text-xl mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="h-6 w-6 text-primary">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                            </svg>
                            Hình ảnh bia mộ
                        </h2>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach ($grave->grave_photos as $index => $photo)
                                <div class="relative group cursor-pointer"
                                    onclick="openImageModal('{{ Storage::url($photo) }}')">
                                    <img src="{{ Storage::url($photo) }}" alt="Ảnh bia mộ"
                                        class="w-full h-48 object-cover rounded-lg shadow-md group-hover:shadow-xl transition-all duration-300 group-hover:scale-105" />
                                    <div
                                        class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-all duration-300 rounded-lg flex items-center justify-center">
                                        <div
                                            class="bg-white/20 backdrop-blur-sm rounded-full p-3 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:scale-110">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="2" stroke="currentColor" class="h-6 w-6 text-white">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Cemetery Info -->
            <div
                class="card bg-gradient-to-br from-white via-slate-50/50 to-green-50/30 shadow-xl border border-green-200/50">
                <div class="card-body">
                    <h3 class="font-bold text-lg mb-4">Nghĩa trang</h3>

                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-base-content/60 mb-1">Tên nghĩa trang</p>
                            <p class="font-medium">{{ $grave->cemetery->name }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-base-content/60 mb-1">Địa chỉ</p>
                            <p class="text-sm">{{ $grave->cemetery->address }}</p>
                        </div>

                        @if ($grave->cemetery->description)
                            <div>
                                <p class="text-sm text-base-content/60 mb-1">Mô tả</p>
                                <p class="text-sm text-base-content/80">{{ $grave->cemetery->description }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="divider my-2"></div>

                    <div class="flex flex-col gap-2">
                        <a href="{{ route('search', ['cemetery_id' => $grave->cemetery_id]) }}"
                            class="btn btn-outline btn-sm gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                            Xem nghĩa trang
                        </a>

                        <a href="{{ route('cemetery.map', ['id' => $grave->cemetery_id]) }}"
                            class="btn btn-primary btn-sm gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                            </svg>
                            Xem sơ đồ lô
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Info -->
            @if ($grave->contact_info && count(array_filter($grave->contact_info)) > 0)
                <div
                    class="card bg-gradient-to-br from-white via-slate-50/50 to-green-50/30 shadow-xl border border-green-200/50">
                    <div class="card-body">
                        <h3 class="font-bold text-lg mb-4">Thông tin liên hệ</h3>

                        <div class="space-y-3">
                            @foreach ($grave->contact_info as $key => $value)
                                @if ($value)
                                    <div class="flex items-start gap-2">
                                        @if ($key === 'phone')
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="2" stroke="currentColor"
                                                class="h-5 w-5 text-primary shrink-0">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                            </svg>
                                        @elseif($key === 'email')
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="2" stroke="currentColor"
                                                class="h-5 w-5 text-primary shrink-0">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                            </svg>
                                        @elseif($key === 'address')
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="2" stroke="currentColor"
                                                class="h-5 w-5 text-primary shrink-0">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="2" stroke="currentColor"
                                                class="h-5 w-5 text-primary shrink-0">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                            </svg>
                                        @endif
                                        <div class="flex-1">
                                            <p class="text-xs text-base-content/60">
                                                {{ match ($key) {
                                                    'phone' => 'Số điện thoại',
                                                    'email' => 'Email',
                                                    'address' => 'Địa chỉ',
                                                    default => ucfirst($key),
                                                } }}
                                            </p>
                                            <p class="text-sm font-medium">{{ $value }}</p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black/90 hidden z-50 flex items-center justify-center p-4"
        onclick="closeImageModal()">
        <div class="relative max-w-6xl w-full max-h-[90vh]">
            <!-- Close Button -->
            <button onclick="closeImageModal()"
                class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors z-10">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-10 h-10">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Navigation Arrows -->
            <button id="prevBtn" onclick="event.stopPropagation(); navigateImage(-1);"
                class="absolute left-4 top-1/2 -translate-y-1/2 text-white hover:text-gray-300 transition-colors z-10 bg-black/50 rounded-full p-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </button>

            <button id="nextBtn" onclick="event.stopPropagation(); navigateImage(1);"
                class="absolute right-4 top-1/2 -translate-y-1/2 text-white hover:text-gray-300 transition-colors z-10 bg-black/50 rounded-full p-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </button>

            <!-- Image Container -->
            <div class="relative bg-white rounded-xl overflow-hidden shadow-2xl" onclick="event.stopPropagation()">
                <img id="modalImage" src="" alt="Ảnh phóng to"
                    class="w-full h-auto max-h-[80vh] object-contain" />

                <!-- Image Info -->
                <div id="imageInfo"
                    class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-4 text-white">
                    <p id="imageTitle" class="font-semibold text-lg"></p>
                    <p id="imageDescription" class="text-sm opacity-90"></p>
                </div>
            </div>

            <!-- Thumbnail Navigation -->
            <div id="thumbnailContainer" class="flex gap-2 mt-4 justify-center overflow-x-auto max-w-full">
                <!-- Thumbnails will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <script>
        let currentImageIndex = 0;
        let allImages = [];

        // Collect all images when page loads
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, collecting images...');

            // Deceased person photo
            @if ($grave->deceased_photo)
                allImages.push({
                    url: '{{ Storage::url($grave->deceased_photo) }}',
                    title: '{{ $grave->deceased_full_name }}',
                    description: 'Ảnh người đã khuất'
                });
            @endif

            // Grave photos
            @if ($grave->grave_photos && count($grave->grave_photos) > 0)
                @foreach ($grave->grave_photos as $index => $photo)
                    allImages.push({
                        url: '{{ Storage::url($photo) }}',
                        title: 'Hình ảnh bia mộ',
                        description: 'Ảnh {{ $index + 1 }} trong {{ count($grave->grave_photos) }} ảnh'
                    });
                @endforeach
            @endif

            console.log('Collected images:', allImages);
        });

        function openImageModal(imageUrl, title = '', description = '') {
            console.log('Opening modal for:', imageUrl);
            console.log('All images:', allImages);

            // Fallback: if allImages is empty, just show the clicked image
            if (allImages.length === 0) {
                console.log('No images collected, showing fallback modal');
                document.getElementById('modalImage').src = imageUrl;
                document.getElementById('imageTitle').textContent = title || 'Hình ảnh';
                document.getElementById('imageDescription').textContent = description || '';
                document.getElementById('imageModal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                return;
            }

            // Find the index of the clicked image
            currentImageIndex = allImages.findIndex(img => img.url === imageUrl);
            if (currentImageIndex === -1) {
                console.log('Image not found in array, using index 0');
                currentImageIndex = 0;
            }

            console.log('Current image index:', currentImageIndex);

            updateModalImage();
            updateThumbnails();
            updateNavigationButtons();

            document.getElementById('imageModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function updateModalImage() {
            console.log('Updating modal image, index:', currentImageIndex);
            const image = allImages[currentImageIndex];

            if (!image) {
                console.log('No image found at index:', currentImageIndex);
                return;
            }

            console.log('Updating to image:', image);

            const modalImage = document.getElementById('modalImage');
            const imageTitle = document.getElementById('imageTitle');
            const imageDescription = document.getElementById('imageDescription');

            if (modalImage) modalImage.src = image.url;
            if (imageTitle) imageTitle.textContent = image.title;
            if (imageDescription) imageDescription.textContent = image.description;
        }

        function updateThumbnails() {
            const container = document.getElementById('thumbnailContainer');
            container.innerHTML = '';

            allImages.forEach((image, index) => {
                const thumbnail = document.createElement('div');
                thumbnail.className = `w-16 h-16 rounded-lg overflow-hidden cursor-pointer border-2 transition-all ${
                index === currentImageIndex ? 'border-white' : 'border-transparent opacity-60'
            }`;
                thumbnail.onclick = () => {
                    currentImageIndex = index;
                    updateModalImage();
                    updateThumbnails();
                    updateNavigationButtons();
                };

                const img = document.createElement('img');
                img.src = image.url;
                img.alt = image.title;
                img.className = 'w-full h-full object-cover';

                thumbnail.appendChild(img);
                container.appendChild(thumbnail);
            });
        }

        function updateNavigationButtons() {
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');

            prevBtn.style.display = allImages.length > 1 ? 'block' : 'none';
            nextBtn.style.display = allImages.length > 1 ? 'block' : 'none';
        }

        function navigateImage(direction) {
            console.log('Navigate image:', direction);
            console.log('Current index before:', currentImageIndex);
            console.log('Total images:', allImages.length);

            if (allImages.length <= 1) {
                console.log('Only 1 image, navigation disabled');
                return;
            }

            currentImageIndex += direction;

            if (currentImageIndex >= allImages.length) {
                currentImageIndex = 0;
            } else if (currentImageIndex < 0) {
                currentImageIndex = allImages.length - 1;
            }

            console.log('Current index after:', currentImageIndex);

            updateModalImage();
            updateThumbnails();
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Test function to check if navigation works
        function testNavigation() {
            console.log('Testing navigation...');
            console.log('All images:', allImages);
            console.log('Current index:', currentImageIndex);

            if (allImages.length > 1) {
                console.log('Testing next image...');
                navigateImage(1);
            }
        }

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (document.getElementById('imageModal').classList.contains('hidden')) return;

            console.log('Key pressed:', e.key);

            switch (e.key) {
                case 'Escape':
                    closeImageModal();
                    break;
                case 'ArrowLeft':
                    console.log('Left arrow pressed');
                    navigateImage(-1);
                    break;
                case 'ArrowRight':
                    console.log('Right arrow pressed');
                    navigateImage(1);
                    break;
            }
        });

        // Initialize map if coordinates exist
        @if ($grave->latitude && $grave->longitude)
            document.addEventListener('DOMContentLoaded', function() {
                // Add CSS to fix z-index issues
                const style = document.createElement('style');
                style.textContent = `
                #grave-map {
                    position: relative !important;
                    z-index: 1 !important;
                }
                #grave-map .leaflet-container {
                    position: relative !important;
                    z-index: 1 !important;
                }
                #grave-map .leaflet-control-container {
                    z-index: 10 !important;
                }
                #grave-map .leaflet-popup {
                    z-index: 1000 !important;
                }
                #grave-map .leaflet-popup-content-wrapper {
                    z-index: 1000 !important;
                }
            `;
                document.head.appendChild(style);

                // Create map
                const graveMap = L.map('grave-map', {
                    zoomControl: true,
                    attributionControl: true,
                    scrollWheelZoom: true,
                    doubleClickZoom: true,
                    boxZoom: false,
                    dragging: true,
                    keyboard: true,
                    touchZoom: true
                }).setView([{{ $grave->latitude }}, {{ $grave->longitude }}], 15);

                // Add OpenStreetMap tiles
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                    maxZoom: 19
                }).addTo(graveMap);

                // Add marker for grave location
                const marker = L.marker([{{ $grave->latitude }}, {{ $grave->longitude }}]).addTo(graveMap);

                // Add popup with grave information
                marker.bindPopup(`
                <div class="text-center">
                    <p class="font-bold text-lg mb-2">{{ $grave->deceased_full_name }}</p>
                    <p class="text-sm mb-1">{{ $grave->cemetery->name }}</p>
                    @if ($grave->location_description)
                        <p class="text-xs text-gray-600 mt-2">{{ $grave->location_description }}</p>
                    @endif
                </div>
            `).openPopup();

                // Ensure map doesn't overflow container
                graveMap.invalidateSize();
            });
        @endif
    </script>
@endsection
