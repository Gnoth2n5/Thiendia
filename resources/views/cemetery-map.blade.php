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
        <div class="card bg-base-100 shadow-xl"
            x-data="{
                cemeteryId: {{ $cemetery->id }},
                plots: [],
                gridDimensions: { rows: 0, columns: 0 },
                selectedPlot: null,
                hoveredPlot: null,
                loading: true,
                filterStatus: 'all',
            
                async init() {
                    await this.loadPlots();
                },
            
                async loadPlots() {
                    this.loading = true;
                    try {
                        const response = await fetch(`/api/cemeteries/${this.cemeteryId}/plots`);
                        const data = await response.json();
            
                        this.plots = data.plots;
                        this.gridDimensions = data.grid;
                    } catch (error) {
                        console.error('Error loading plots:', error);
                    } finally {
                        this.loading = false;
                    }
                },
            
                getPlotColor(status) {
                    const colors = {
                        'available': 'bg-green-500 hover:bg-green-600',
                        'occupied': 'bg-gray-500 hover:bg-gray-600',
                        'reserved': 'bg-yellow-500 hover:bg-yellow-600',
                        'unavailable': 'bg-red-500 hover:bg-red-600'
                    };
                    return colors[status] || 'bg-gray-300';
                },
            
                selectPlot(plot) {
                    this.selectedPlot = plot;
                },
            
                closeModal() {
                    this.selectedPlot = null;
                },
            
                filteredPlots() {
                    if (this.filterStatus === 'all') {
                        return this.plots;
                    }
                    return this.plots.filter(p => p.status === this.filterStatus);
                }
            }">

            <div class="card-body">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="card-title text-2xl">Sơ đồ lô mộ</h2>

                    <!-- Filter -->
                    <select x-model="filterStatus"
                        class="select select-bordered select-sm">
                        <option value="all">Tất cả</option>
                        <option value="available">Còn trống</option>
                        <option value="occupied">Đã sử dụng</option>
                        <option value="reserved">Đã đặt trước</option>
                        <option value="unavailable">Không khả dụng</option>
                    </select>
                </div>

                <!-- Legend -->
                <div class="flex flex-wrap items-center gap-4 mb-6 text-sm">
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-green-500 rounded"></div>
                        <span>Còn trống</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-gray-500 rounded"></div>
                        <span>Đã sử dụng</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-yellow-500 rounded"></div>
                        <span>Đã đặt trước</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-red-500 rounded"></div>
                        <span>Không khả dụng</span>
                    </div>
                </div>

                <!-- Loading State -->
                <div x-show="loading" class="text-center py-12">
                    <span class="loading loading-spinner loading-lg"></span>
                    <p class="mt-4 text-base-content/60">Đang tải sơ đồ...</p>
                </div>

                <!-- Grid -->
                <div x-show="!loading && plots.length > 0" class="overflow-x-auto">
                    <div class="inline-block min-w-full">
                        <template x-for="row in gridDimensions.rows" :key="'row-' + row">
                            <div class="flex gap-1 mb-1">
                                <template x-for="col in gridDimensions.columns" :key="'cell-' + row + '-' + col">
                                    <template x-for="plot in filteredPlots().filter(p => p.row === row && p.column === col)"
                                        :key="plot.id">
                                        <div @click="selectPlot(plot)" @mouseenter="hoveredPlot = plot"
                                            @mouseleave="hoveredPlot = null"
                                            :class="['w-12 h-12 sm:w-14 sm:h-14 rounded cursor-pointer transition-all duration-150 flex items-center justify-center text-white text-xs font-bold', getPlotColor(plot.status)]"
                                            :title="plot.plot_code + ' - ' + plot.status_label">
                                            <span x-text="plot.plot_code" class="text-[10px] sm:text-xs"></span>
                                        </div>
                                    </template>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Empty State -->
                <div x-show="!loading && plots.length === 0" class="text-center py-12">
                    <p class="text-base-content/60">Chưa có sơ đồ lô cho nghĩa trang này.</p>
                </div>

                <!-- Hovered Plot Info -->
                <div x-show="hoveredPlot" x-transition
                    class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                    <template x-if="hoveredPlot">
                        <div class="space-y-1 text-sm">
                            <div><strong>Mã lô:</strong> <span x-text="hoveredPlot.plot_code"></span></div>
                            <div><strong>Vị trí:</strong> Hàng <span x-text="hoveredPlot.row"></span>, Cột <span
                                    x-text="hoveredPlot.column"></span></div>
                            <div><strong>Trạng thái:</strong> <span x-text="hoveredPlot.status_label"></span></div>
                            <template x-if="hoveredPlot.grave">
                                <div><strong>Liệt sĩ:</strong> <span x-text="hoveredPlot.grave.deceased_full_name"></span>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>

                <!-- Plot Detail Modal -->
                <div x-show="selectedPlot" @click.away="closeModal()" x-transition
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
                    <div @click.stop class="bg-base-100 rounded-lg shadow-2xl max-w-md w-full p-6">
                        <template x-if="selectedPlot">
                            <div>
                                <h3 class="text-2xl font-bold mb-4" x-text="'Lô ' + selectedPlot.plot_code"></h3>

                                <div class="space-y-3 mb-6">
                                    <div class="flex justify-between">
                                        <span class="font-medium">Vị trí:</span>
                                        <span>Hàng <span x-text="selectedPlot.row"></span>, Cột <span
                                                x-text="selectedPlot.column"></span></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium">Trạng thái:</span>
                                        <span x-text="selectedPlot.status_label"></span>
                                    </div>

                                    <template x-if="selectedPlot.grave">
                                        <div class="pt-4 border-t">
                                            <p class="font-medium mb-2">Thông tin liệt sĩ:</p>
                                            <p class="text-lg font-bold text-primary"
                                                x-text="selectedPlot.grave.deceased_full_name"></p>
                                            <a :href="'/grave/' + selectedPlot.grave.id"
                                                class="btn btn-primary btn-sm mt-3">
                                                Xem chi tiết
                                            </a>
                                        </div>
                                    </template>
                                </div>

                                <button @click="closeModal()" class="btn btn-ghost w-full">Đóng</button>
                            </div>
                        </template>
                    </div>
                </div>
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

