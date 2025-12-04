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
                            @endphp
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
