@extends('layouts.app')

@section('title', 'Sơ đồ ' . $cemetery->name)

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="text-sm breadcrumbs mb-6">
            <ul class="flex items-center space-x-2 text-base-content/60">
                <li><a href="{{ route('home') }}" class="hover:text-primary">Trang chủ</a></li>
                <li>/</li>
                <li class="text-base-content/60">{{ $cemetery->name }}</li>
            </ul>
        </nav>

        <!-- Cemetery Header -->
        <div class="card bg-base-100 shadow-xl mb-8">
            <div class="card-body">
                <h1 class="card-title text-3xl font-bold text-primary">
                    {{ $cemetery->name }}
                </h1>
                <div class="space-y-2 text-base-content/80">
                    <p><strong>Địa chỉ:</strong> {{ $cemetery->address }}</p>
                    <p><strong>Xã/Phường:</strong> {{ $cemetery->commune }}</p>
                    @if ($cemetery->description)
                        <p><strong>Mô tả:</strong> {{ $cemetery->description }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Grid Map -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-2xl mb-6">Sơ đồ lô mộ</h2>

                <!-- Legend -->
                <div class="flex flex-wrap items-center gap-4 mb-6 text-sm">
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

                @if ($plotGrid['rows'] > 0 && $plotGrid['columns'] > 0 && $plotGrid['plots']->count() > 0)
                    @php
                        // Helper function for plot colors
                        $getPlotColor = function($status) {
                            $colors = [
                                'available' => '#22c55e',    // green-500
                                'occupied' => '#6b7280',     // gray-500
                                'reserved' => '#eab308',     // yellow-500
                                'unavailable' => '#ef4444'   // red-500
                            ];
                            return $colors[$status] ?? '#d1d5db';
                        };
                        
                        // Build plot lookup map
                        $plotMap = [];
                        foreach ($plotGrid['plots'] as $plot) {
                            $plotMap[$plot->row][$plot->column] = $plot;
                        }
                    @endphp

                    <!-- Grid -->
                    <div class="overflow-x-auto p-4 bg-gray-50 rounded-lg">
                        <div class="inline-block">
                            @php
                                // Đảo 90 độ: số hàng hiển thị = số cột dữ liệu, số cột hiển thị = số hàng dữ liệu
                                $displayRows = $plotGrid['columns']; // Hàng hiển thị = Cột dữ liệu
                                $displayCols = $plotGrid['rows'];    // Cột hiển thị = Hàng dữ liệu
                                
                                // Tính toán chiều rộng và vị trí cho hàng rào và cổng
                                $gridWidth = ($displayCols * 48) + (($displayCols - 1) * 4);
                                $leftWidth = floor($gridWidth / 2) - 40;
                                $rightWidth = $gridWidth - $leftWidth - 80;
                                $gatePosition = $leftWidth;
                                $fenceCount = floor($leftWidth / 20);
                            @endphp
                            
                            <!-- Entrance Line and Labels (hàng rào và cổng vào) -->
                            <div style="display: flex; margin-bottom: 12px; margin-left: 40px; position: relative; min-height: 80px; overflow: visible;">
                                <div style="width: {{ $gridWidth }}px; position: relative; min-width: {{ $gridWidth }}px;">
                                    <!-- Hàng rào bên trái -->
                                    <div style="position: absolute; top: 30px; left: 0; width: {{ $leftWidth }}px; display: flex; align-items: center; gap: 2px;">
                                        @for ($i = 0; $i < $fenceCount; $i++)
                                            <img src="/images/fence.png" alt="Hàng rào" style="width: 18px; height: 18px; object-fit: contain;">
                                        @endfor
                                    </div>
                                    
                                    <!-- Cổng vào (ở giữa) -->
                                    <div style="position: absolute; top: 0; left: {{ $gatePosition }}px; display: flex; flex-direction: column; align-items: center; gap: 4px; width: 80px;">
                                        <div style="display: flex; align-items: center; gap: 4px;">
                                            <span style="font-size: 12px; font-weight: 700; color: #dc2626;">Cổng vào</span>
                                        </div>
                                        <img src="/images/gate.png" alt="Cổng vào" style="width: 32px; height: 32px; object-fit: contain;">
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
                                    <div style="width: 48px; text-align: center; font-weight: 600; color: #6b7280; font-size: 11px;">
                                        {{ chr(64 + $col) }}
                                    </div>
                                @endfor
                            </div>

                            <!-- Grid Rows (hiển thị số) -->
                            @for ($row = 1; $row <= $displayRows; $row++)
                                <div style="display: flex; gap: 4px; margin-bottom: 4px;">
                                    <!-- Row Label (số) -->
                                    <div style="width: 36px; display: flex; align-items: center; justify-content: center; font-weight: 600; color: #6b7280; font-size: 13px;">
                                        {{ $row }}
                                    </div>

                                    <!-- Plot Cells - đảo 90 độ: khi hiển thị ở (row, col), tìm plot có (row dữ liệu = col, column dữ liệu = row) -->
                                    @for ($col = 1; $col <= $displayCols; $col++)
                                        @if (isset($plotMap[$col][$row]))
                                            @php
                                                $plot = $plotMap[$col][$row];
                                                $backgroundColor = $getPlotColor($plot->status);
                                                $title = $plot->plot_code . ' - ' . $plot->status_label;
                                                if ($plot->grave) {
                                                    $title .= ' (' . $plot->grave->deceased_full_name . ')';
                                                }
                                            @endphp
                                            <a
                                                href="{{ $plot->grave ? route('grave.show', $plot->grave->id) : '#' }}"
                                                style="
                                                    width: 48px;
                                                    height: 48px;
                                                    border-radius: 6px;
                                                    display: flex;
                                                    align-items: center;
                                                    justify-content: center;
                                                    font-size: 10px;
                                                    font-weight: bold;
                                                    color: #ffffff;
                                                    background-color: {{ $backgroundColor }};
                                                    border: 1px solid rgba(0,0,0,0.1);
                                                    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
                                                    text-decoration: none;
                                                    transition: all 0.15s;
                                                    {{ $plot->grave ? 'cursor: pointer;' : 'cursor: default;' }}
                                                "
                                                title="{{ $title }}"
                                                @if (!$plot->grave) onclick="return false;" @endif
                                                onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.2)';"
                                                onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 1px 2px rgba(0,0,0,0.1)';"
                                            >
                                                {{ $plot->plot_code }}
                                            </a>
                                        @else
                                            <div style="width: 48px; height: 48px;"></div>
                                        @endif
                                    @endfor
                                </div>
                            @endfor
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="text-sm text-gray-600 text-center mt-6">
                        <span>Tổng số lô: {{ $plotGrid['plots']->count() }}</span>
                        <span class="mx-2">•</span>
                        <span>Còn trống: {{ $plotGrid['plots']->where('status', 'available')->count() }}</span>
                        <span class="mx-2">•</span>
                        <span>Đã sử dụng: {{ $plotGrid['plots']->where('status', 'occupied')->count() }}</span>
                        <span class="mx-2">•</span>
                        <span>Đã đặt trước: {{ $plotGrid['plots']->where('status', 'reserved')->count() }}</span>
                    </div>

                    <!-- Instructions -->
                    <div class="alert alert-info mt-6">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Click vào lô màu xám (đã sử dụng) để xem thông tin chi tiết liệt sĩ</span>
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto text-gray-400 mb-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                        </svg>
                        <p class="text-gray-600 text-lg font-medium">Chưa có sơ đồ lô cho nghĩa trang này</p>
                        <p class="text-gray-500 text-sm mt-2">Vui lòng liên hệ quản trị viên để thiết lập lưới lô</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-8">
            <a href="{{ route('home') }}" class="btn btn-outline">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Quay lại trang chủ
            </a>
        </div>
    </div>
@endsection
