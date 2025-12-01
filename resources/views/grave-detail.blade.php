@extends('layouts.app')

@section('title', 'Liệt sĩ ' . $grave->deceased_full_name . ' - Tra cứu liệt sĩ tỉnh Ninh Bình')

@section('content')
    <!-- Breadcrumb -->
    <div class="text-sm breadcrumbs mb-6">
        <ul>
            <li>
                <a href="{{ route('home') }}" style="color: #3b82f6;" onmouseover="this.style.textDecoration='underline'"
                    onmouseout="this.style.textDecoration='none'">Trang chủ</a>
            </li>
            <li>
                <a href="{{ route('search') }}" style="color: #3b82f6;" onmouseover="this.style.textDecoration='underline'"
                    onmouseout="this.style.textDecoration='none'">Tìm kiếm</a>
            </li>
            <li class="text-base-content/60">{{ $grave->deceased_full_name }}</li>
        </ul>
    </div>

    <!-- Page Header -->
    <div class="mb-8">
        <div class="text-center mb-8">
            <div class="inline-block mb-6">
                <div class="p-4 rounded-full" style="background-color: #3b82f6;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="h-12 w-12 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                    </svg>
                </div>
            </div>
            <div class="flex items-center justify-center gap-3 mb-2">
                <h1 class="text-4xl font-bold bg-gradient-to-r from-purple-700 to-blue-600 bg-clip-text text-transparent">
                    Liệt Sỹ {{ $grave->deceased_full_name }}
                </h1>
            </div>
            <p class="text-lg mb-6" style="color: #2b2b2b;">{{ $grave->cemetery->name }}</p>

            <!-- Tribute Memorial Section -->
            <div class="mt-8 text-center">
                <!-- Tribute Button -->
                <button id="tributeBtn"
                    onclick="openTributeModal({{ $grave->id }}, '{{ $grave->deceased_full_name ?: $grave->owner_name }}')"
                    class="inline-flex items-center gap-2 px-6 py-3 text-white font-medium border transition-colors duration-200"
                    style="background-color: #3b82f6; border-color: #1e40af;"
                    onmouseover="this.style.backgroundColor='#1e40af'" onmouseout="this.style.backgroundColor='#3b82f6'">
                    <span class="text-xl">🕯️</span>
                    <span id="tributeBtnText">Thắp hương tưởng nhớ</span>
                </button>

                <!-- Tribute Count -->
                <div id="tributeCount" class="mt-3 text-sm" style="color: #2b2b2b;">
                    Đã có <span id="tributeCountNumber">0</span> người thắp hương tưởng nhớ
                </div>

                <!-- Social Sharing -->
                <div class="mt-4 flex justify-center gap-3">
                    <button
                        onclick="shareToFacebook('{{ $grave->deceased_full_name ?: $grave->owner_name }}', '{{ route('grave.show', $grave->id) }}')"
                        class="p-2 transition-colors" style="color: #2b2b2b;" onmouseover="this.style.color='#1e40af'"
                        onmouseout="this.style.color='#2b2b2b'">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                    </button>
                    <button
                        onclick="shareToTwitter('{{ $grave->deceased_full_name ?: $grave->owner_name }}', '{{ route('grave.show', $grave->id) }}')"
                        class="p-2 transition-colors" style="color: #2b2b2b;" onmouseover="this.style.color='#1e40af'"
                        onmouseout="this.style.color='#2b2b2b'">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="card border" style="background-color: #fafaf8; border-color: #d4d0c8; box-shadow: none;">
                <div class="card-body">
                    <h2 class="card-title text-xl mb-4" style="color: #2b2b2b;">Thông tin cơ bản</h2>

                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if ($grave->plot)
                                <div>
                                    <p class="text-sm text-base-content/60 mb-1">Lô mộ</p>
                                    <p class="font-medium text-primary">{{ $grave->plot->plot_code }}</p>
                                </div>

                                <div>
                                    <p class="text-sm text-base-content/60 mb-1">Vị trí trong lưới</p>
                                    <p class="font-medium">Hàng {{ $grave->plot->row }}, Cột {{ $grave->plot->column }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cemetery Plot Grid -->
            @if ($grave->plot && $plotGrid)
                <div
                    class="card bg-gradient-to-br from-white via-slate-50/50 to-blue-50/30 shadow-xl border border-blue-200/50">
                    <div class="card-body">
                        <h2 class="card-title text-xl mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="h-6 w-6 text-blue-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                            </svg>
                            Sơ đồ vị trí trong nghĩa trang
                        </h2>

                        <div class="space-y-4">
                            <!-- Target Plot Banner -->
                            <div class="p-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-lg">
                                <div class="flex items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="h-8 w-8 flex-shrink-0">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                    </svg>
                                    <div class="flex-1">
                                        <div class="font-bold text-lg">📍 Vị trí liệt sĩ: Lô {{ $grave->plot->plot_code }}
                                            - Hàng {{ $grave->plot->row }}, Cột {{ $grave->plot->column }}</div>
                                        <div class="text-sm opacity-90">Lô được đánh dấu màu xanh dương trên sơ đồ</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Legend -->
                            <div class="flex items-center gap-4 text-sm p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 rounded" style="background-color: #3b82f6;"></div>
                                    <span>Lô này</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 rounded" style="background-color: #22c55e;"></div>
                                    <span>Còn trống</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 rounded" style="background-color: #6b7280;"></div>
                                    <span>Đã sử dụng</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 rounded" style="background-color: #eab308;"></div>
                                    <span>Đã đặt trước</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 rounded" style="background-color: #ef4444;"></div>
                                    <span>Không khả dụng</span>
                                </div>
                            </div>

                            <!-- Grid Container -->
                            @if ($plotGrid['rows'] > 0 && $plotGrid['columns'] > 0 && $plotGrid['plots']->count() > 0)
                                @php
                                    // Helper function for plot colors
                                    $getPlotColor = function ($plot, $targetPlotId) {
                                        if ($plot->id === $targetPlotId) {
                                            return '#3b82f6'; // blue-500 - highlighted
                                        }

                                        $colors = [
                                            'available' => '#22c55e', // green-500
                                            'occupied' => '#6b7280', // gray-500
                                            'reserved' => '#eab308', // yellow-500
                                            'unavailable' => '#ef4444', // red-500
                                        ];
                                        return $colors[$plot->status] ?? '#d1d5db';
                                    };

                                    // Build plot lookup map
                                    $plotMap = [];
                                    foreach ($plotGrid['plots'] as $plot) {
                                        $plotMap[$plot->row][$plot->column] = $plot;
                                    }
                                @endphp

                                <div class="overflow-x-auto p-4 bg-white rounded-lg border-2 border-gray-200">
                                    <div class="inline-block">
                                        <!-- Column Headers -->
                                        <div style="display: flex; gap: 4px; margin-bottom: 4px; margin-left: 40px;">
                                            @for ($col = 1; $col <= $plotGrid['columns']; $col++)
                                                <div
                                                    style="width: 40px; text-align: center; font-weight: 600; color: #6b7280; font-size: 11px;">
                                                    {{ $col }}
                                                </div>
                                            @endfor
                                        </div>

                                        <!-- Grid Rows -->
                                        @for ($row = 1; $row <= $plotGrid['rows']; $row++)
                                            <div style="display: flex; gap: 4px; margin-bottom: 4px;">
                                                <!-- Row Label -->
                                                <div
                                                    style="width: 36px; display: flex; align-items: center; justify-content: center; font-weight: 600; color: #6b7280; font-size: 13px;">
                                                    {{ chr(64 + $row) }}
                                                </div>

                                                <!-- Plot Cells -->
                                                @for ($col = 1; $col <= $plotGrid['columns']; $col++)
                                                    @if (isset($plotMap[$row][$col]))
                                                        @php
                                                            $plot = $plotMap[$row][$col];
                                                            $isHighlighted = $plot->id === $plotGrid['targetPlotId'];
                                                            $backgroundColor = $getPlotColor(
                                                                $plot,
                                                                $plotGrid['targetPlotId'],
                                                            );
                                                            $border = $isHighlighted
                                                                ? '3px solid #1e40af'
                                                                : '1px solid rgba(0,0,0,0.1)';
                                                            $boxShadow = $isHighlighted
                                                                ? '0 4px 12px rgba(59, 130, 246, 0.5)'
                                                                : '0 1px 2px rgba(0,0,0,0.1)';
                                                            $title = $plot->plot_code . ' - ' . $plot->status_label;
                                                            if ($plot->grave) {
                                                                $title .= ' (' . $plot->grave->deceased_full_name . ')';
                                                            }
                                                        @endphp
                                                        <div style="
                                                                width: 40px;
                                                                height: 40px;
                                                                border-radius: 6px;
                                                                display: flex;
                                                                align-items: center;
                                                                justify-content: center;
                                                                font-size: 9px;
                                                                font-weight: bold;
                                                                color: #ffffff;
                                                                background-color: {{ $backgroundColor }};
                                                                border: {{ $border }};
                                                                box-shadow: {{ $boxShadow }};
                                                            "
                                                            title="{{ $title }}">
                                                            {{ $plot->plot_code }}
                                                        </div>
                                                    @else
                                                        <div style="width: 40px; height: 40px;"></div>
                                                    @endif
                                                @endfor
                                            </div>
                                        @endfor
                                    </div>
                                </div>

                                <!-- Stats -->
                                <div class="text-sm text-gray-600 text-center mt-4">
                                    <span>Tổng số lô: {{ $plotGrid['plots']->count() }}</span>
                                    <span class="mx-2">•</span>
                                    <span>Còn trống: {{ $plotGrid['plots']->where('status', 'available')->count() }}</span>
                                    <span class="mx-2">•</span>
                                    <span>Đã sử dụng: {{ $plotGrid['plots']->where('status', 'occupied')->count() }}</span>
                                </div>
                            @else
                                <div class="text-center py-8 text-gray-500">
                                    <p>Nghĩa trang chưa có lưới lô</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Deceased Person Information -->
            @if ($grave->deceased_full_name)
                <div class="card border" style="background-color: #fafaf8; border-color: #d4d0c8; box-shadow: none;">
                    <div class="card-body">
                        <h2 class="card-title text-xl mb-4" style="color: #2b2b2b;">Thông tin người đã khuất</h2>

                        <div class="space-y-4">
                            <div class="p-6 rounded-xl" style="background-color: #f5f3e7;">
                                <div class="flex items-start gap-6 mb-6">
                                    @if ($grave->deceased_photo)
                                        <div class="flex-shrink-0">
                                            <div class="w-32 h-40 rounded-xl overflow-hidden cursor-pointer group relative"
                                                onclick="openImageModal('{{ Storage::url($grave->deceased_photo) }}')">
                                                <img src="{{ Storage::url($grave->deceased_photo) }}"
                                                    alt="{{ $grave->deceased_full_name }}"
                                                    class="w-full h-full object-cover" />
                                                <div
                                                    class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-all duration-300 flex items-center justify-center">
                                                    <div class="rounded-full p-2 opacity-0 group-hover:opacity-100 transition-all duration-300"
                                                        style="background-color: rgba(255,255,255,0.2);">
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
                                            <div class="w-32 h-40 rounded-xl flex items-center justify-center"
                                                style="background-color: #d4d0c8;">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="h-16 w-16" style="color: #3b82f6; opacity: 0.5;">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                                </svg>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <p class="font-bold text-2xl mb-2">{{ $grave->deceased_full_name }}</p>

                                        <p class="text-base text-primary font-semibold mb-1">
                                            Cấp bậc: <span class="text-gray-700">{{ $grave->rank ?: '—' }}</span>
                                        </p>

                                        <p class="text-base text-primary font-semibold mb-1">
                                            Đơn vị: <span class="text-gray-700">{{ $grave->unit ?: '—' }}</span>
                                        </p>

                                        <p class="text-sm text-base-content/70 mb-2">
                                            Chức vụ: <span class="font-semibold">{{ $grave->position ?: '—' }}</span>
                                        </p>

                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-white/50 rounded-lg p-3">
                                        <p class="text-xs text-base-content/60 mb-1">Nguyên Quán</p>
                                        <p class="font-bold text-lg">{{ $grave->hometown ?: '—' }}</p>
                                    </div>

                                    <div class="rounded-lg p-3" style="background-color: #fafaf8;">
                                        <p class="text-xs mb-1" style="color: #2b2b2b; opacity: 0.6;">Ngày sinh</p>
                                        <p class="font-bold text-lg" style="color: #2b2b2b;">
                                            {{ $grave->deceased_birth_date ? $grave->deceased_birth_date->format('d/m/Y') : '—' }}
                                        </p>
                                    </div>

                                    <div class="rounded-lg p-3" style="background-color: #fafaf8;">
                                        <p class="text-xs mb-1" style="color: #2b2b2b; opacity: 0.6;">Ngày nhập ngũ</p>
                                        <p class="font-bold text-lg" style="color: #2b2b2b;">
                                            {{ $grave->enlistment_date ? $grave->enlistment_date->format('d/m/Y') : '—' }}
                                        </p>
                                    </div>

                                    <div class="rounded-lg p-3" style="background-color: #fafaf8;">
                                        <p class="text-xs mb-1" style="color: #2b2b2b; opacity: 0.6;">Ngày hy sinh</p>
                                        <p class="font-bold text-lg" style="color: #2b2b2b;">
                                            {{ $grave->deceased_death_date ? $grave->deceased_death_date->format('d/m/Y') : '—' }}
                                        </p>
                                    </div>

                                </div>

                                @if ($grave->deceased_birth_date && $grave->deceased_death_date)
                                    <div class="mt-4 pt-4" style="border-top: 1px solid #d4d0c8;">
                                        <div class="flex items-center gap-2">
                                            <p class="text-sm font-bold" style="color: #2b2b2b;">
                                                Hưởng thọ: <span class="text-lg font-bold"
                                                    style="color: #3b82f6;">{{ $grave->deceased_birth_date->diffInYears($grave->deceased_death_date) }}</span>
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

            <!-- Notes -->
            @if ($grave->notes)
                <div class="card border" style="background-color: #fafaf8; border-color: #d4d0c8; box-shadow: none;">
                    <div class="card-body">
                        <h2 class="card-title text-xl mb-4" style="color: #2b2b2b;">Ghi chú</h2>

                        @if ($grave->notes)
                            <div>
                                <div class="flex items-center gap-2 mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="h-5 w-5" style="color: #3b82f6;">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                    <p class="font-medium" style="color: #2b2b2b;">Ghi chú</p>
                                </div>
                                <p class="ml-7" style="color: #2b2b2b; opacity: 0.8;">{{ $grave->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif


            <!-- Grave Photos -->
            @if ($grave->grave_photos && count($grave->grave_photos) > 0)
                <div class="card border" style="background-color: #fafaf8; border-color: #d4d0c8; box-shadow: none;">
                    <div class="card-body">
                        <h2 class="card-title text-xl mb-4" style="color: #2b2b2b;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="h-6 w-6" style="color: #3b82f6;">
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
                                        class="w-full h-48 object-cover rounded-lg" />
                                    <div
                                        class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-all duration-300 rounded-lg flex items-center justify-center">
                                        <div class="rounded-full p-3 opacity-0 group-hover:opacity-100 transition-all duration-300"
                                            style="background-color: rgba(255,255,255,0.2);">
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
            <div class="card border" style="background-color: #fafaf8; border-color: #d4d0c8; box-shadow: none;">
                <div class="card-body">
                    <h3 class="font-bold text-lg mb-4" style="color: #2b2b2b;">Nghĩa trang</h3>

                    <div class="space-y-3">
                        <div>
                            <p class="text-sm mb-1" style="color: #2b2b2b; opacity: 0.6;">Tên nghĩa trang</p>
                            <p class="font-medium" style="color: #2b2b2b;">{{ $grave->cemetery->name }}</p>
                        </div>

                        <div>
                            <p class="text-sm mb-1" style="color: #2b2b2b; opacity: 0.6;">Địa chỉ</p>
                            <p class="text-sm" style="color: #2b2b2b;">{{ $grave->cemetery->address }}</p>
                        </div>

                        @if ($grave->cemetery->description)
                            <div>
                                <p class="text-sm mb-1" style="color: #2b2b2b; opacity: 0.6;">Mô tả</p>
                                <p class="text-sm" style="color: #2b2b2b; opacity: 0.8;">
                                    {{ $grave->cemetery->description }}</p>
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


            <!-- Recent Tributes -->
            <div class="card border" style="background-color: #fafaf8; border-color: #d4d0c8; box-shadow: none;">
                <div class="card-body">
                    <h3 class="font-bold text-lg mb-4" style="color: #2b2b2b;">Lời tưởng niệm gần đây</h3>
                    <div id="recentTributes" class="space-y-3">
                        <!-- Tributes will be loaded here -->
                        <div class="text-center py-4" style="color: #2b2b2b; opacity: 0.6;">
                            <div>Đang tải...</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <!-- Quick Actions -->
            <div class="card border" style="background-color: #fafaf8; border-color: #d4d0c8; box-shadow: none;">
                <div class="card-body">
                    <h3 class="font-bold text-lg mb-3" style="color: #2b2b2b;">Cần hỗ trợ?</h3>
                    <p class="text-sm mb-4" style="color: #2b2b2b; opacity: 0.7;">
                        Nếu bạn phát hiện thông tin không chính xác hoặc cần cập nhật, vui lòng gửi yêu cầu sửa đổi.
                    </p>
                    <a href="{{ route('modification-request.create', $grave->id) }}"
                        class="inline-flex items-center justify-center gap-2 px-6 py-3 text-white font-semibold rounded w-full"
                        style="background-color: #3b82f6;" onmouseover="this.style.backgroundColor='#1e40af'"
                        onmouseout="this.style.backgroundColor='#3b82f6'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                        Gửi yêu cầu sửa đổi
                    </a>
                </div>
            </div> --}}
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black/90 z-[9999] flex items-center justify-center p-4"
        style="display: none;" onclick="closeImageModal()">
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
                document.getElementById('imageModal').style.display = 'flex';
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

            document.getElementById('imageModal').style.display = 'flex';
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
            document.getElementById('imageModal').style.display = 'none';
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
            if (document.getElementById('imageModal').style.display === 'none') return;

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

    </script>

    <!-- Tribute Modal -->
    <div id="tributeModal" class="fixed inset-0 bg-black/50 z-[9999] flex items-center justify-center p-4"
        style="display: none;">
        <div class="bg-white max-w-md w-full border" style="border-color: #d4d0c8;">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 border-b" style="border-color: #d4d0c8;">
                <h3 id="tributeModalTitle" class="text-lg font-semibold" style="color: #2b2b2b;">Thắp hương tưởng nhớ
                </h3>
                <button onclick="closeTributeModal()" style="color: #2b2b2b; opacity: 0.6;"
                    onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.6'">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-4">
                <form id="tributeForm" onsubmit="submitTribute(event)">
                    <!-- Name Field -->
                    <div class="mb-4">
                        <label for="tributeName" class="block text-sm font-medium mb-2" style="color: #2b2b2b;">
                            Họ tên (không bắt buộc)
                        </label>
                        <input type="text" id="tributeName" name="name" placeholder="Để trống nếu muốn ẩn danh"
                            class="w-full px-3 py-2 border focus:outline-none focus:ring-1" style="border-color: #d4d0c8;"
                            onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 1px #3b82f6'"
                            onblur="this.style.borderColor='#d4d0c8'; this.style.boxShadow='none'">
                    </div>

                    <!-- Message Field -->
                    <div class="mb-4">
                        <label for="tributeMessage" class="block text-sm font-medium mb-2" style="color: #2b2b2b;">
                            Lời tưởng niệm (không bắt buộc)
                        </label>
                        <textarea id="tributeMessage" name="message" rows="4" maxlength="500" placeholder="Nhập lời tưởng niệm..."
                            class="w-full px-3 py-2 border resize-none focus:outline-none focus:ring-1" style="border-color: #d4d0c8;"
                            onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 1px #3b82f6'"
                            onblur="this.style.borderColor='#d4d0c8'; this.style.boxShadow='none'"></textarea>
                        <div class="text-right text-sm mt-1" style="color: #2b2b2b; opacity: 0.6;">
                            <span id="charCount">0</span>/500
                        </div>
                    </div>

                    <!-- Sound Toggle -->
                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" checked id="soundToggle" class="mr-2">
                            <span class="text-sm" style="color: #2b2b2b;">Bật âm thanh</span>
                        </label>
                    </div>

                    <!-- Error Message -->
                    <div id="tributeError" class="mb-4 text-sm" style="color: #8b0000; display: none;"></div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="flex gap-3 p-4 border-t" style="border-color: #d4d0c8;">
                <button type="button" onclick="closeTributeModal()" class="flex-1 px-4 py-2 border transition-colors"
                    style="color: #2b2b2b; border-color: #d4d0c8;" onmouseover="this.style.backgroundColor='#f5f3e7'"
                    onmouseout="this.style.backgroundColor='transparent'">
                    Hủy
                </button>
                <button type="submit" form="tributeForm" id="submitTributeBtn"
                    class="flex-1 px-4 py-2 text-white transition-colors" style="background-color: #3b82f6;"
                    onmouseover="this.style.backgroundColor='#1e40af'" onmouseout="this.style.backgroundColor='#3b82f6'">
                    Thắp hương
                </button>
            </div>
        </div>
    </div>

    <!-- Smoke Animation Element -->
    <div id="smokeAnimation" class="fixed inset-0 pointer-events-none z-[10000]" style="display: none;">
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
            <div class="smoke-particle">🕯️</div>
        </div>
    </div>
@endsection
