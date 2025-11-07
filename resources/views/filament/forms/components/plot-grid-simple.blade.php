@php
    $livewire = $getLivewire();
    $cemeteryId = $livewire->data['cemetery_id'] ?? null;
    $selectedPlotId = $livewire->data['plot_id'] ?? null;
    
    $plots = [];
    $gridDimensions = ['rows' => 0, 'columns' => 0];
    $plotMap = [];
    
    if ($cemeteryId) {
        $cemetery = \App\Models\Cemetery::find($cemeteryId);
        if ($cemetery) {
            $gridDimensions = $cemetery->getGridDimensions();
            $plotsCollection = \App\Models\CemeteryPlot::where('cemetery_id', $cemeteryId)
                ->with('grave:id,plot_id,deceased_full_name')
                ->orderBy('row')
                ->orderBy('column')
                ->get();
            
            $plots = $plotsCollection->map(function ($plot) {
                return [
                    'id' => $plot->id,
                    'plot_code' => $plot->plot_code,
                    'row' => $plot->row,
                    'column' => $plot->column,
                    'status' => $plot->status,
                    'grave' => $plot->grave ? [
                        'id' => $plot->grave->id,
                        'deceased_full_name' => $plot->grave->deceased_full_name,
                    ] : null,
                ];
            })->toArray();
            
            // Pre-compute plot map for O(1) lookups
            foreach ($plots as $plot) {
                $plotMap["{$plot['row']}-{$plot['column']}"] = $plot;
            }
        }
    }
    
    // Create unique render key with timestamp for better cache busting
    $renderVersion = now()->timestamp;
    $renderKey = md5($cemeteryId . '_' . $selectedPlotId . '_' . $renderVersion . '_' . count($plots));
@endphp

<div 
    wire:key="plot-picker-{{ $renderKey }}"
    x-data="{
        plots: @js($plots),
        plotMap: @js($plotMap),
        selectedPlotId: @js($selectedPlotId),
        maxRow: @js($gridDimensions['rows']),
        maxCol: @js($gridDimensions['columns']),
        hoveredPlot: null,
        isRendering: false,
        renderError: null,
        
        init() {
            try {
                console.log('[PlotGrid] Initialized with', this.plots.length, 'plots');
                this.setupLivewireListeners();
            } catch (error) {
                console.error('[PlotGrid] Init error:', error);
                this.renderError = error.message;
            }
        },
        
        setupLivewireListeners() {
            // Listen for Livewire updates and debounce re-renders
            document.addEventListener('livewire:update', () => {
                this.scheduleRender();
            });
        },
        
        scheduleRender() {
            if (this.isRendering) return;
            
            this.isRendering = true;
            requestAnimationFrame(() => {
                try {
                    // Render will happen naturally through Alpine reactivity
                    this.isRendering = false;
                } catch (error) {
                    console.error('[PlotGrid] Render error:', error);
                    this.renderError = error.message;
                    this.isRendering = false;
                }
            });
        },
        
        getPlotByPosition(row, col) {
            try {
                const key = `${row}-${col}`;
                return this.plotMap[key] || null;
            } catch (error) {
                console.error('[PlotGrid] Error getting plot:', error);
                return null;
            }
        },
        
        getPlotColor(plot) {
            try {
                if (!plot) return '#d1d5db';
                
                if (plot.id === this.selectedPlotId) {
                    return '#3b82f6'; // blue-500 - đã chọn
                }
                
                const colors = {
                    'available': '#22c55e',
                    'occupied': '#6b7280',
                    'reserved': '#eab308',
                    'unavailable': '#ef4444'
                };
                return colors[plot.status] || '#d1d5db';
            } catch (error) {
                console.error('[PlotGrid] Error getting color:', error);
                return '#d1d5db';
            }
        },
        
        canSelectPlot(plot) {
            try {
                if (!plot) return false;
                return plot.status === 'available' || plot.id === this.selectedPlotId;
            } catch (error) {
                console.error('[PlotGrid] Error checking selectability:', error);
                return false;
            }
        },
        
        selectPlot(plot) {
            try {
                if (!plot || !this.canSelectPlot(plot)) {
                    return;
                }
                
                this.selectedPlotId = plot.id;
                $wire.set('data.plot_id', plot.id);
                
                // Auto-fill location description
                $wire.get('data.location_description').then(currentLocation => {
                    if (!currentLocation || currentLocation === '') {
                        $wire.set('data.location_description', 
                            `Lô ${plot.plot_code} - Hàng ${plot.row}, Cột ${plot.column}`
                        );
                    }
                }).catch(error => {
                    console.error('[PlotGrid] Error setting location:', error);
                });
            } catch (error) {
                console.error('[PlotGrid] Error selecting plot:', error);
                this.renderError = 'Không thể chọn lô. Vui lòng thử lại.';
            }
        },
        
        getPlotInfo(plot) {
            try {
                if (!plot) return '';
                let info = `Lô ${plot.plot_code} - Hàng ${plot.row}, Cột ${plot.column}`;
                if (plot.grave) {
                    info += `\\n👤 ${plot.grave.deceased_full_name}`;
                }
                return info;
            } catch (error) {
                console.error('[PlotGrid] Error getting plot info:', error);
                return 'Lỗi hiển thị thông tin';
            }
        },
        
        getSelectedPlot() {
            try {
                return this.plots.find(p => p.id === this.selectedPlotId) || null;
            } catch (error) {
                console.error('[PlotGrid] Error getting selected plot:', error);
                return null;
            }
        }
    }"
    class="space-y-4"
>
    <!-- Error Banner -->
    <div x-show="renderError" x-transition class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
        <div class="flex items-center gap-2 text-red-700 dark:text-red-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-semibold">Lỗi render:</span>
            <span x-text="renderError"></span>
        </div>
    </div>
    
    @if($cemeteryId && count($plots) > 0)
        <!-- Legend -->
        <div class="flex items-center gap-4 text-xs p-3 bg-gray-50 dark:bg-gray-900 rounded-lg">
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded" style="background-color: #3b82f6;"></div>
                <span>Đã chọn</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded" style="background-color: #22c55e;"></div>
                <span>Trống</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded" style="background-color: #6b7280;"></div>
                <span>Đã dùng</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded" style="background-color: #eab308;"></div>
                <span>Đặt trước</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded" style="background-color: #ef4444;"></div>
                <span>Không dùng</span>
            </div>
        </div>

        <!-- Plot Info Panel - Combined Selected & Hovered -->
        <div 
            class="p-4 rounded-lg border-2 transition-all"
            style="min-height: 120px;"
            :style="selectedPlotId || hoveredPlot ? 'background-color: #dbeafe; border-color: #3b82f6;' : 'background-color: #f3f4f6; border-color: #d1d5db;'"
        >
            <!-- Selected Plot (Priority) -->
            <template x-if="selectedPlotId && getSelectedPlot()">
                <div>
                    <div>
                        <div class="font-semibold text-blue-700 dark:text-blue-300 mb-2">✓ Lô đã chọn:</div>
                        <div class="text-lg font-bold" x-text="`Lô ${getSelectedPlot().plot_code}`"></div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            Vị trí: Hàng <span x-text="getSelectedPlot().row"></span>, Cột <span x-text="getSelectedPlot().column"></span>
                        </div>
                        <div class="text-sm mt-1">
                            Trạng thái: 
                            <span class="px-2 py-1 rounded text-xs font-medium"
                                  :style="getSelectedPlot().status === 'available' ? 'background-color: #dcfce7; color: #166534;' :
                                          getSelectedPlot().status === 'occupied' ? 'background-color: #f3f4f6; color: #374151;' :
                                          getSelectedPlot().status === 'reserved' ? 'background-color: #fef3c7; color: #92400e;' :
                                          'background-color: #fee2e2; color: #991b1b;'"
                                  x-text="getSelectedPlot().status === 'available' ? 'Còn trống' : 
                                         getSelectedPlot().status === 'occupied' ? 'Đã sử dụng' : 
                                         getSelectedPlot().status === 'reserved' ? 'Đã đặt trước' : 'Không khả dụng'"></span>
                        </div>
                    </div>
                </div>
            </template>
            
            <!-- Hovered Plot (when no selection) -->
            <template x-if="!selectedPlotId && hoveredPlot">
                <div>
                    <div class="font-bold text-sm mb-2" style="color: #1e40af;">
                        <span x-text="'Lô ' + hoveredPlot.plot_code"></span>
                    </div>
                    <div class="text-sm">
                        <div>Vị trí: Hàng <span x-text="hoveredPlot.row"></span>, Cột <span x-text="hoveredPlot.column"></span></div>
                        <div class="mt-1">
                            Trạng thái: 
                            <span x-text="hoveredPlot.status === 'available' ? 'Còn trống' : 
                                         hoveredPlot.status === 'occupied' ? 'Đã sử dụng' : 
                                         hoveredPlot.status === 'reserved' ? 'Đã đặt trước' : 'Không khả dụng'"></span>
                        </div>
                        <template x-if="hoveredPlot.grave">
                            <div class="mt-1 font-semibold">👤 <span x-text="hoveredPlot.grave.deceased_full_name"></span></div>
                        </template>
                    </div>
                </div>
            </template>
            
            <!-- Empty State -->
            <template x-if="!selectedPlotId && !hoveredPlot">
                <div class="text-center text-gray-500 dark:text-gray-400 flex items-center justify-center" style="min-height: 90px;">
                    <p>Click vào ô xanh lá để chọn lô mộ</p>
                </div>
            </template>
        </div>

        <!-- Grid -->
        <div class="overflow-x-auto p-4 bg-white dark:bg-gray-800 rounded-lg border-2 border-gray-200 dark:border-gray-700">
            <div class="inline-block">
                <!-- Column Headers -->
                <div style="display: flex; gap: 4px; margin-bottom: 4px; margin-left: 40px;">
                    <template x-for="col in maxCol" :key="'col-' + col">
                        <div style="width: 48px; text-align: center; font-weight: 600; color: #6b7280; font-size: 11px;">
                            <span x-text="col"></span>
                        </div>
                    </template>
                </div>

                <!-- Grid Rows -->
                <template x-for="row in maxRow" :key="'row-' + row">
                    <div style="display: flex; gap: 4px; margin-bottom: 4px;">
                        <!-- Row Label -->
                        <div style="width: 36px; display: flex; align-items: center; justify-content: center; font-weight: 600; color: #6b7280; font-size: 13px;">
                            <span x-text="String.fromCharCode(64 + row)"></span>
                        </div>

                        <!-- Plot Cells - Using plotMap for O(1) lookup instead of filter -->
                        <template x-for="col in maxCol" :key="'cell-' + row + '-' + col">
                            <div
                                x-data="{ plot: getPlotByPosition(row, col) }"
                                @click="plot && selectPlot(plot)"
                                @mouseenter="plot && (hoveredPlot = plot)"
                                @mouseleave="hoveredPlot = null"
                                :style="plot ? {
                                    width: '48px',
                                    height: '48px',
                                    borderRadius: '6px',
                                    cursor: canSelectPlot(plot) ? 'pointer' : 'not-allowed',
                                    display: 'flex',
                                    alignItems: 'center',
                                    justifyContent: 'center',
                                    fontSize: '10px',
                                    fontWeight: 'bold',
                                    color: '#ffffff',
                                    backgroundColor: getPlotColor(plot),
                                    border: plot.id === selectedPlotId ? '3px solid #1e40af' : '1px solid rgba(0,0,0,0.1)',
                                    boxShadow: plot.id === selectedPlotId ? '0 4px 12px rgba(59, 130, 246, 0.4)' : '0 1px 2px rgba(0,0,0,0.1)',
                                    transition: 'all 0.15s',
                                    opacity: canSelectPlot(plot) ? '1' : '0.5'
                                } : {
                                    width: '48px',
                                    height: '48px',
                                    backgroundColor: 'transparent'
                                }"
                                :title="plot ? getPlotInfo(plot) : ''"
                            >
                                <span x-show="plot" x-text="plot ? plot.plot_code : ''"></span>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </div>

        <!-- Stats -->
        <div class="text-sm text-gray-600 dark:text-gray-400 text-center">
            <span x-text="`Tổng số lô: ${plots.length}`"></span>
            <span class="mx-2">•</span>
            <span x-text="`Còn trống: ${plots.filter(p => p.status === 'available').length}`"></span>
            <span class="mx-2">•</span>
            <span x-text="`Đã sử dụng: ${plots.filter(p => p.status === 'occupied').length}`"></span>
        </div>
    @elseif($cemeteryId && count($plots) === 0)
        <div class="p-6 text-center bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border-2 border-yellow-200 dark:border-yellow-800">
            <div class="text-yellow-700 dark:text-yellow-300 font-semibold mb-2">
                ⚠️ Nghĩa trang chưa có lưới lô
            </div>
            <div class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                Admin cần tạo lưới lô trước khi thêm liệt sĩ
            </div>
            <a 
                href="{{ \App\Filament\Pages\ManageCemeteryGrid::getUrl(['cemetery' => $cemeteryId]) }}" 
                target="_blank"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 010 2H6v2a1 1 0 01-2 0V5zM20 5a1 1 0 00-1-1h-4a1 1 0 100 2h2v2a1 1 0 102 0V5zM4 19a1 1 0 001 1h4a1 1 0 100-2H6v-2a1 1 0 10-2 0v3zM20 19a1 1 0 01-1 1h-4a1 1 0 110-2h2v-2a1 1 0 112 0v3z"></path>
                </svg>
                Đi tới quản lý lưới lô
            </a>
        </div>
    @else
        <div class="p-4 text-center text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900 rounded-lg">
            Vui lòng chọn nghĩa trang trước để hiển thị lưới lô
        </div>
    @endif
</div>

