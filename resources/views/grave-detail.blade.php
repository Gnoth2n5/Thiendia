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
            <p class="text-lg mb-6" style="color: #2b2b2b;">{{ $grave->plot && $grave->plot->cemetery ? $grave->plot->cemetery->name : $grave->cemetery->name }}</p>

        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
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
            <div class="card border" style="background-color: #fafaf8; border-color: #d4d0c8; box-shadow: none;">
                <div class="card-body">
                    <h2 class="card-title text-xl mb-4" style="color: #2b2b2b;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="h-6 w-6" style="color: #3b82f6;">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                        Hình ảnh lăng mộ
                    </h2>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Bên trái: Mô phỏng bia liệt sĩ -->
                        <div>
                            {{-- <h3 class="text-lg font-semibold mb-3" style="color: #2b2b2b;">Mô phỏng bia liệt sĩ</h3> --}}
                            <div class="relative flex justify-center">
                                <div id="tombstoneContainer" class="tombstone-wrapper" style="box-shadow: 0 4px 15px rgba(0,0,0,0.3); border: 2px solid #444; position: relative; width: 350px; min-height: 500px;">
                                    <!-- Nền granite -->
                                    <div class="tombstone-background"></div>
                                    
                                    <!-- Viền trang trí -->
                                    <div class="tombstone-border"></div>
                                    
                                    <!-- Nội dung bia -->
                                    <div class="tombstone-content">
                                        <!-- Ngôi sao -->
                                        <div class="tombstone-star-wrapper">
                                            <svg class="tombstone-star" viewBox="0 0 100 100" width="52" height="52">
                                                <defs>
                                                    <filter id="starGlow">
                                                        <feGaussianBlur stdDeviation="2" result="coloredBlur"/>
                                                        <feMerge>
                                                            <feMergeNode in="coloredBlur"/>
                                                            <feMergeNode in="SourceGraphic"/>
                                                        </feMerge>
                                                    </filter>
                                                </defs>
                                                <circle cx="50" cy="50" r="34" fill="none" stroke="#FFD700" stroke-width="2"/>
                                                <path d="M50,10 L61,38 L90,38 L68,56 L79,84 L50,66 L21,84 L32,56 L10,38 L39,38 Z" 
                                                      fill="#e30000" stroke="#FFFF00" stroke-width="1" filter="url(#starGlow)"/>
                                            </svg>
                                        </div>
                                        
                                        <!-- Tiêu đề -->
                                        <h2 class="tombstone-title">LIỆT SỸ</h2>
                                        
                                        <!-- Tên liệt sỹ -->
                                        <h3 class="tombstone-name" id="tombstoneName"></h3>
                                        
                                        <!-- Divider -->
                                        <div class="tombstone-divider"></div>
                                        
                                        <!-- Thông tin chi tiết -->
                                        <div class="tombstone-info">
                                            <div class="tombstone-field" data-field="birthYear" style="display: none;">
                                                <span class="tombstone-label">Sinh năm:</span>
                                                <span class="tombstone-value"></span>
                                            </div>
                                            <div class="tombstone-field" data-field="hometown" style="display: none;">
                                                <span class="tombstone-label">Nguyên quán:</span>
                                                <span class="tombstone-value"></span>
                                            </div>
                                            <div class="tombstone-field" data-field="rank" style="display: none;">
                                                <span class="tombstone-label">Cấp bậc:</span>
                                                <span class="tombstone-value"></span>
                                            </div>
                                            <div class="tombstone-field" data-field="unit" style="display: none;">
                                                <span class="tombstone-label">Đơn vị:</span>
                                                <span class="tombstone-value"></span>
                                            </div>
                                            <div class="tombstone-field" data-field="position" style="display: none;">
                                                <span class="tombstone-label">Chức vụ:</span>
                                                <span class="tombstone-value"></span>
                                            </div>
                                            <div class="tombstone-field" data-field="enlistmentDate" style="display: none;">
                                                <span class="tombstone-label">Ngày nhập ngũ:</span>
                                                <span class="tombstone-value"></span>
                                            </div>
                                            <div class="tombstone-field" data-field="sacrificeDate" style="display: none;">
                                                <span class="tombstone-label">Hy sinh ngày:</span>
                                                <span class="tombstone-value"></span>
                                            </div>
                                        </div>
                                        
                                        <!-- Dòng kết -->
                                        <div class="tombstone-footer">TỔ QUỐC GHI CÔNG</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bên phải: Ảnh lăng mộ thực tế -->
                        <div>
                            @if ($grave->grave_photos && count($grave->grave_photos) > 0)
                                <div class="grid grid-cols-2 gap-4">
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
                            @else
                                <p class="text-sm text-gray-500"></p>
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
                                            - Hàng {{ $grave->plot->column }}, Cột {{ $grave->plot->row }}</div>
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
                                        @php
                                            // Đảo 90 độ: số hàng hiển thị = số cột dữ liệu, số cột hiển thị = số hàng dữ liệu
                                            $displayRows = $plotGrid['columns']; // Hàng hiển thị = Cột dữ liệu
                                            $displayCols = $plotGrid['rows'];    // Cột hiển thị = Hàng dữ liệu
                                            
                                            // Tính toán chiều rộng và vị trí cho hàng rào và cổng
                                            $gridWidth = ($displayCols * 40) + (($displayCols - 1) * 4);
                                            $leftWidth = floor($gridWidth / 2) - 50;
                                            $rightWidth = $gridWidth - $leftWidth - 100;
                                            $gatePosition = $leftWidth;
                                            $fenceCount = floor($leftWidth / 20);
                                        @endphp
                                        
                                        <!-- Entrance Line and Labels (hàng rào và tượng đài) -->
                                        <div style="display: flex; margin-bottom: 12px; margin-left: 40px; position: relative; min-height: 100px; overflow: visible;">
                                            <div style="width: {{ $gridWidth }}px; position: relative; min-width: {{ $gridWidth }}px;">
                                                <!-- Hàng rào bên trái -->
                                                <div style="position: absolute; top: 30px; left: 0; width: {{ $leftWidth }}px; display: flex; align-items: center; gap: 2px;">
                                                    @for ($i = 0; $i < $fenceCount; $i++)
                                                        <img src="/images/fence.png" alt="Hàng rào" style="width: 18px; height: 18px; object-fit: contain;">
                                                    @endfor
                                                </div>
                                                
                                                <!-- Tượng đài (ở giữa) -->
                                                <div style="position: absolute; top: 0; left: {{ $gatePosition }}px; display: flex; flex-direction: column; align-items: center; gap: 4px; width: 100px;">
                                                    <div style="display: flex; align-items: center; gap: 4px; white-space: nowrap;">
                                                        <span style="font-size: 12px; font-weight: 700; color: #dc2626; white-space: nowrap;">Đài tưởng niệm</span>
                                                    </div>
                                                    <img src="/images/rizal-park.png" alt="Tượng đài" style="width: 32px; height: 32px; object-fit: contain;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" style="width: 20px; height: 20px; color: #dc2626;">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5L12 21m0 0l-7.5-7.5M12 21V3" />
                                                    </svg>
                                                </div>
                                                
                                                <!-- Hàng rào bên phải -->
                                                <div style="position: absolute; top: 30px; right: 0; width: {{ $rightWidth }}px; display: flex; align-items: center; gap: 2px;">
                                                    @for ($i = 0; $i < $fenceCount; $i++)
                                                        <img src="/images/fence.png" alt="Hàng rào" style="width: 18px; height: 18px; object-fit: contain;">
                                                    @endfor
                                                </div>
                                                
                                                <!-- Label Bên trái -->
                                                <div style="position: absolute; top: 0; left: 0; display: flex; align-items: center; gap: 4px;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 16px; height: 16px; color: #16a34a;">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
                                                    </svg>
                                                    <span style="font-size: 12px; font-weight: 700; color: #16a34a;">Bên trái</span>
                                                </div>
                                                
                                                <!-- Label Bên phải -->
                                                <div style="position: absolute; top: 0; right: 0; display: flex; align-items: center; gap: 4px;">
                                                    <span style="font-size: 12px; font-weight: 700; color: #16a34a;">Bên phải</span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 16px; height: 16px; color: #16a34a;">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Column Headers (hiển thị chữ cái) -->
                                        <div style="display: flex; gap: 4px; margin-bottom: 4px; margin-left: 40px;">
                                            @for ($col = 1; $col <= $displayCols; $col++)
                                                <div
                                                    style="width: 40px; text-align: center; font-weight: 600; color: #6b7280; font-size: 11px;">
                                                    {{ chr(64 + $col) }}
                                                </div>
                                            @endfor
                                        </div>

                                        <!-- Grid Rows (hiển thị số) -->
                                        @for ($row = 1; $row <= $displayRows; $row++)
                                            <div style="display: flex; gap: 4px; margin-bottom: 4px;">
                                                <!-- Row Label (số) -->
                                                <div
                                                    style="width: 36px; display: flex; align-items: center; justify-content: center; font-weight: 600; color: #6b7280; font-size: 13px;">
                                                    {{ $row }}
                                                </div>

                                                <!-- Plot Cells - đảo 90 độ: khi hiển thị ở (row, col), tìm plot có (row dữ liệu = col, column dữ liệu = row) -->
                                                @for ($col = 1; $col <= $displayCols; $col++)
                                                    @if (isset($plotMap[$col][$row]))
                                                        @php
                                                            $plot = $plotMap[$col][$row];
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
                                        
                                        <!-- Exit Line and Labels (hàng rào và cổng vào) - Đặt dưới lưới -->
                                        <div style="display: flex; margin-top: 12px; margin-left: 40px; position: relative; min-height: 100px; overflow: visible;">
                                            <div style="width: {{ $gridWidth }}px; position: relative; min-width: {{ $gridWidth }}px;">
                                                <!-- Hàng rào bên trái -->
                                                <div style="position: absolute; top: 30px; left: 0; width: {{ $leftWidth }}px; display: flex; align-items: center; gap: 2px;">
                                                    @for ($i = 0; $i < $fenceCount; $i++)
                                                        <img src="/images/fence.png" alt="Hàng rào" style="width: 18px; height: 18px; object-fit: contain;">
                                                    @endfor
                                                </div>
                                                
                                                <!-- Cổng vào (ở giữa) -->
                                                <div style="position: absolute; top: 0; left: {{ $gatePosition }}px; display: flex; flex-direction: column; align-items: center; gap: 4px; width: 100px;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" style="width: 20px; height: 20px; color: #dc2626;">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5L12 3m0 0l7.5 7.5M12 3v18" />
                                                    </svg>
                                                    <img src="/images/gate.png" alt="Cổng vào" style="width: 32px; height: 32px; object-fit: contain;">
                                                    <div style="display: flex; align-items: center; gap: 4px; white-space: nowrap;">
                                                        <span style="font-size: 12px; font-weight: 700; color: #dc2626; white-space: nowrap;">Cổng vào</span>
                                                    </div>
                                                </div>
                                                
                                                <!-- Hàng rào bên phải -->
                                                <div style="position: absolute; top: 30px; right: 0; width: {{ $rightWidth }}px; display: flex; align-items: center; gap: 2px;">
                                                    @for ($i = 0; $i < $fenceCount; $i++)
                                                        <img src="/images/fence.png" alt="Hàng rào" style="width: 18px; height: 18px; object-fit: contain;">
                                                    @endfor
                                                </div>
                                                
                                                <!-- Label Bên trái -->
                                                <div style="position: absolute; top: 0; left: 0; display: flex; align-items: center; gap: 4px;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 16px; height: 16px; color: #16a34a;">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
                                                    </svg>
                                                    <span style="font-size: 12px; font-weight: 700; color: #16a34a;">Bên trái</span>
                                                </div>
                                                
                                                <!-- Label Bên phải -->
                                                <div style="position: absolute; top: 0; right: 0; display: flex; align-items: center; gap: 4px;">
                                                    <span style="font-size: 12px; font-weight: 700; color: #16a34a;">Bên phải</span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 16px; height: 16px; color: #16a34a;">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                            <p class="font-medium" style="color: #2b2b2b;">{{ $grave->plot && $grave->plot->cemetery ? $grave->plot->cemetery->name : $grave->cemetery->name }}</p>
                        </div>

                        <div>
                            <p class="text-sm mb-1" style="color: #2b2b2b; opacity: 0.6;">Địa chỉ</p>
                            <p class="text-sm" style="color: #2b2b2b;">{{ $grave->plot && $grave->plot->cemetery ? $grave->plot->cemetery->address : $grave->cemetery->address }}</p>
                        </div>

                        @if ($grave->plot)
                            <div>
                                <p class="text-sm mb-1" style="color: #2b2b2b; opacity: 0.6;">Lô mộ</p>
                                <p class="font-medium text-primary">{{ $grave->plot->plot_code }}</p>
                            </div>

                            <div>
                                <p class="text-sm mb-1" style="color: #2b2b2b; opacity: 0.6;">Vị trí</p>
                                <p class="text-sm" style="color: #2b2b2b;">Hàng {{ $grave->plot->column }}, Cột {{ $grave->plot->row }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Cemetery Map Card -->
            <div class="card border" style="background-color: #fafaf8; border-color: #d4d0c8; box-shadow: none;">
                <div class="card-body">
                    <h3 class="font-bold text-lg mb-4" style="color: #2b2b2b;">Sơ đồ nghĩa trang</h3>
                    <p class="text-sm mb-4" style="color: #2b2b2b; opacity: 0.7;">
                        Xem toàn bộ sơ đồ lưới lô của nghĩa trang
                    </p>
                    <a href="{{ route('cemetery.map', ['id' => ($grave->plot && $grave->plot->cemetery ? $grave->plot->cemetery->id : $grave->cemetery_id)]) }}"
                        class="btn btn-primary w-full gap-2"
                        style="background-color: #3b82f6; border-color: #1e40af;"
                        onmouseover="this.style.backgroundColor='#1e40af'"
                        onmouseout="this.style.backgroundColor='#3b82f6'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                        </svg>
                        Xem sơ đồ nghĩa trang
                    </a>
                </div>
            </div>

            <!-- Cemetery Location Map Card -->
            @php
                $cemetery = $grave->plot && $grave->plot->cemetery ? $grave->plot->cemetery : $grave->cemetery;
                $cemeteryName = $cemetery->name ?? '';
            @endphp
            <div class="card border" style="background-color: #fafaf8; border-color: #d4d0c8; box-shadow: none;">
                <div class="card-body">
                    <h3 class="font-bold text-lg mb-4" style="color: #2b2b2b;">Vị trí nghĩa trang</h3>
                    <div id="cemeteryLocationMapContainer" 
                         style="height: 300px; width: 100%; border: 1px solid #d1d5db; border-radius: 0.5rem; margin-bottom: 12px; position: relative; z-index: 1;"></div>
                    <p class="text-xs text-center mb-3" style="color: #2b2b2b; opacity: 0.6;">
                        {{ $cemeteryName ?: 'Vị trí nghĩa trang' }}
                    </p>
                    <a id="openGoogleMapsBtn" 
                       href="#" 
                       target="_blank"
                       class="btn btn-sm w-full gap-2"
                       style="background-color: #4285f4; border-color: #4285f4; color: white;"
                       onmouseover="this.style.backgroundColor='#357ae8'"
                       onmouseout="this.style.backgroundColor='#4285f4'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                        Mở Google Maps
                    </a>
                </div>
            </div>
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

    <style>
        /* Tombstone Styles */
        .tombstone-wrapper {
            position: relative;
            background: #0a0a0a;
            overflow: hidden;
        }

        .tombstone-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 30%, rgba(255,255,255,0.03) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(255,255,255,0.02) 0%, transparent 50%),
                linear-gradient(135deg, #0a0a0a 0%, #141414 100%);
            background-size: 200% 200%, 150% 150%, 100% 100%;
            animation: graniteShift 20s ease-in-out infinite;
        }

        @keyframes graniteShift {
            0%, 100% { background-position: 0% 0%, 0% 0%, 0% 0%; }
            50% { background-position: 100% 100%, 50% 50%, 0% 0%; }
        }

        .tombstone-background::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(255,255,255,0.02) 2px, rgba(255,255,255,0.02) 4px),
                repeating-linear-gradient(90deg, transparent, transparent 2px, rgba(255,255,255,0.02) 2px, rgba(255,255,255,0.02) 4px);
            pointer-events: none;
        }

        .tombstone-border {
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            bottom: 15px;
            border: 2px solid #C5A059;
            pointer-events: none;
        }

        .tombstone-border::before {
            content: '';
            position: absolute;
            top: 4px;
            left: 4px;
            right: 4px;
            bottom: 4px;
            border: 1px solid #C5A059;
        }

        .tombstone-content {
            position: relative;
            z-index: 1;
            padding: 30px 30px 35px;
            min-height: 500px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .tombstone-star-wrapper {
            margin-bottom: 20px;
        }

        .tombstone-star {
            filter: drop-shadow(0 0 8px rgba(255, 0, 0, 0.6));
        }

        .tombstone-title {
            font-family: 'Cinzel', serif;
            font-weight: 700;
            font-size: 30px;
            background: linear-gradient(90deg, #BF953F 0%, #FCF6BA 30%, #B38728 50%, #FBF5B7 70%, #AA771C 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.9);
            margin: -5px 0;
            text-align: center;
        }

        .tombstone-name {
            font-family: 'Noto Serif', 'Times New Roman', serif;
            font-weight: 700;
            font-size: 26px;
            background: linear-gradient(90deg, #BF953F 0%, #FCF6BA 30%, #B38728 50%, #FBF5B7 70%, #AA771C 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.9);
            margin: 10px 0;
            text-align: center;
            text-transform: none !important;
            font-variant: normal !important;
            text-rendering: optimizeLegibility;
            letter-spacing: 0.5px;
        }
        
        #tombstoneName {
            text-transform: none !important;
        }

        .tombstone-divider {
            width: 120px;
            height: 2px;
            background: linear-gradient(90deg, transparent 0%, #FFD700 50%, transparent 100%);
            margin: 10px 0 20px;
        }

        .tombstone-info {
            width: 100%;
            margin-top: 10px;
            margin-bottom: auto;
            padding: 0 5px;
        }

        .tombstone-field {
            display: flex;
            margin-bottom: 14px;
            align-items: center;
            gap: 8px;
        }

        .tombstone-label {
            font-family: 'Noto Serif', serif;
            font-weight: 700;
            font-size: 14px;
            color: #cccccc;
            min-width: 115px;
            max-width: 115px;
            flex-shrink: 0;
            text-align: left;
            line-height: 1.2;
        }

        .tombstone-value {
            font-family: 'Noto Serif', serif;
            font-weight: 400;
            font-size: 15px;
            background: linear-gradient(90deg, #BF953F 0%, #FCF6BA 30%, #B38728 50%, #FBF5B7 70%, #AA771C 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            flex: 1;
            word-wrap: break-word;
            text-align: left;
            line-height: 1.2;
        }

        .tombstone-footer {
            font-family: 'Cinzel', serif;
            font-weight: 700;
            font-size: 22px;
            background: linear-gradient(90deg, #BF953F 0%, #FCF6BA 30%, #B38728 50%, #FBF5B7 70%, #AA771C 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.9);
            text-align: center;
            margin-top: auto;
            padding-top: 20px;
        }
    </style>

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

        // Cemetery Location Map
        document.addEventListener('DOMContentLoaded', function() {
            // Fix z-index cho Leaflet map để không đè lên navbar
            const style = document.createElement('style');
            style.textContent = `
                #cemeteryLocationMapContainer .leaflet-container,
                #cemeteryLocationMapContainer .leaflet-pane,
                #cemeteryLocationMapContainer .leaflet-map-pane,
                #cemeteryLocationMapContainer .leaflet-tile-pane,
                #cemeteryLocationMapContainer .leaflet-overlay-pane,
                #cemeteryLocationMapContainer .leaflet-shadow-pane,
                #cemeteryLocationMapContainer .leaflet-marker-pane,
                #cemeteryLocationMapContainer .leaflet-tooltip-pane,
                #cemeteryLocationMapContainer .leaflet-popup-pane,
                #cemeteryLocationMapContainer .leaflet-control-container {
                    z-index: 1 !important;
                }
            `;
            document.head.appendChild(style);

            function initCemeteryLocationMap() {
                // Wait for Leaflet to be available
                if (typeof L === 'undefined') {
                    setTimeout(initCemeteryLocationMap, 100);
                    return;
                }

                const mapContainer = document.getElementById('cemeteryLocationMapContainer');
                if (!mapContainer) {
                    setTimeout(initCemeteryLocationMap, 100);
                    return;
                }

                try {
                    // Mapping từ tên xã đến tọa độ
                    const communeCoordinates = {
                        'Chính Lý': {
                            lat: 20.6003355,
                            lng: 105.9976607,
                            color: '#2563eb'
                        },
                        'Hợp Lý': {
                            lat: 20.6102271,
                            lng: 105.9815351,
                            color: '#16a34a'
                        },
                        'Văn Lý': {
                            lat: 20.585758,
                            lng: 105.9737588,
                            color: '#dc2626'
                        }
                    };

                    // Lấy tên nghĩa trang từ PHP
                    const cemeteryName = @json($cemeteryName ?? '');
                    
                    // Tìm xã phù hợp (match tên nghĩa trang)
                    let selectedCommune = null;
                    if (cemeteryName) {
                        // Thử match tên nghĩa trang với tên xã
                        for (const [name, coords] of Object.entries(communeCoordinates)) {
                            // Match nếu tên nghĩa trang chứa tên xã hoặc ngược lại
                            if (cemeteryName.includes(name) || name.includes(cemeteryName)) {
                                selectedCommune = { name, ...coords };
                                break;
                            }
                        }
                    }

                    // Nếu không tìm thấy, sử dụng xã đầu tiên làm mặc định
                    if (!selectedCommune) {
                        const firstCommune = Object.entries(communeCoordinates)[0];
                        selectedCommune = {
                            name: firstCommune[0],
                            ...firstCommune[1]
                        };
                    }

                    // Initialize map centered on the selected commune
                    const map = L.map(mapContainer, {
                        zoomControl: true
                    }).setView([selectedCommune.lat, selectedCommune.lng], 13);

                    // Add OpenStreetMap tiles
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                        maxZoom: 19
                    }).addTo(map);

                    // Add marker for the selected commune
                    L.marker([selectedCommune.lat, selectedCommune.lng], {
                        icon: L.divIcon({
                            className: 'custom-marker',
                            html: `<div style="background-color: ${selectedCommune.color}; width: 24px; height: 24px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>`,
                            iconSize: [24, 24],
                            iconAnchor: [12, 12]
                        })
                    })
                    .addTo(map)
                    .bindPopup(`<strong>${selectedCommune.name}</strong><br>Tọa độ: ${selectedCommune.lat.toFixed(4)}°N, ${selectedCommune.lng.toFixed(4)}°E`);

                    // Update Google Maps button with coordinates
                    const googleMapsBtn = document.getElementById('openGoogleMapsBtn');
                    if (googleMapsBtn) {
                        const googleMapsUrl = `https://www.google.com/maps?q=${selectedCommune.lat},${selectedCommune.lng}`;
                        googleMapsBtn.href = googleMapsUrl;
                    }

                    // Invalidate size after a short delay to ensure proper rendering
                    setTimeout(() => {
                        map.invalidateSize();
                    }, 300);

                    console.log('Cemetery location map initialized successfully');

                } catch (error) {
                    console.error('Error initializing cemetery location map:', error);
                }
            }

            // Initialize map
            initCemeteryLocationMap();
        });

        // Tombstone Generator Script - HTML/CSS Version
        document.addEventListener('DOMContentLoaded', function() {
            // Import fonts
            const link = document.createElement('link');
            link.href = 'https://fonts.googleapis.com/css2?family=Cinzel:wght@700&family=Noto+Serif:ital,wght@0,400;0,700;1,400&display=swap';
            link.rel = 'stylesheet';
            document.head.appendChild(link);

            // Prepare martyr data from PHP
            const martyrData = {
                name: @json($grave->deceased_full_name ?? ''),
                birthYear: @json($grave->deceased_birth_date ? $grave->deceased_birth_date->format('Y') : ''),
                hometown: @json($grave->hometown ?? ''),
                rank: @json($grave->rank ?? ''),
                unit: @json($grave->unit ?? ''),
                position: @json($grave->position ?? ''),
                enlistmentDate: @json($grave->enlistment_date ? $grave->enlistment_date->format('d/m/Y') : ''),
                sacrificeDate: @json($grave->deceased_death_date ? $grave->deceased_death_date->format('d/m/Y') : ''),
                note: @json($grave->notes ?? '')
            };

            function populateTombstone(data) {
                console.log('Populating tombstone with data:', data);
                
                // Set name - ensure no uppercase transformation
                const nameEl = document.getElementById('tombstoneName');
                if (nameEl) {
                    if (data.name) {
                        // Set text content directly without any transformation
                        nameEl.textContent = data.name;
                        // Force no text-transform via inline style
                        nameEl.style.textTransform = 'none';
                    } else {
                        nameEl.textContent = '';
                    }
                }

                // Map field names
                const fieldMap = {
                    'birthYear': data.birthYear,
                    'hometown': data.hometown,
                    'rank': data.rank,
                    'unit': data.unit,
                    'position': data.position,
                    'enlistmentDate': data.enlistmentDate,
                    'sacrificeDate': data.sacrificeDate
                };

                // Populate fields
                Object.keys(fieldMap).forEach(fieldName => {
                    const fieldEl = document.querySelector(`[data-field="${fieldName}"]`);
                    if (fieldEl) {
                        const valueEl = fieldEl.querySelector('.tombstone-value');
                        if (valueEl) {
                            if (fieldMap[fieldName]) {
                                valueEl.textContent = fieldMap[fieldName];
                                fieldEl.style.display = 'flex';
                            } else {
                                fieldEl.style.display = 'none';
                            }
                        }
                    }
                });
            }

            // Populate immediately
            populateTombstone(martyrData);
            
            // Also populate when fonts are ready (for better rendering)
            document.fonts.ready.then(function() {
                populateTombstone(martyrData);
            });
        });

    </script>

@endsection
