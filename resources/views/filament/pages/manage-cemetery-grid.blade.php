<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Cemetery Info -->
        <x-filament::section>
            <x-slot name="heading">
                Nghĩa trang: {{ $cemetery->name }}
            </x-slot>

            <x-slot name="description">
                <div class="space-y-1">
                    <div>Địa chỉ: {{ $cemetery->address }}</div>
                    <div>Xã/Phường: {{ $cemetery->commune }}</div>
                    @if($gridDimensions && $gridDimensions['rows'] > 0)
                        <div class="mt-2 text-sm font-semibold">
                            Kích thước lưới: {{ $gridDimensions['rows'] }} hàng × {{ $gridDimensions['columns'] }} cột
                            = {{ $gridDimensions['rows'] * $gridDimensions['columns'] }} lô
                        </div>
                    @endif
                </div>
            </x-slot>
        </x-filament::section>

        <!-- Grid Display -->
        @if($plots && count($plots) > 0)
            <x-filament::section>
                <x-slot name="heading">
                    Sơ đồ lưới lô mộ
                </x-slot>

                <x-slot name="description">
                    <div class="flex items-center gap-4 text-sm">
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
                </x-slot>

                <div
                    wire:key="cemetery-grid-{{ $cemetery->id }}-{{ $gridVersion }}"
                    x-data="{
                        plots: @js($plots ?? []),
                        selectedPlots: [],
                        selectedPlot: null,
                        maxRow: @js($gridDimensions['rows'] ?? 0),
                        maxCol: @js($gridDimensions['columns'] ?? 0),
                        
                        getPlotColor(status) {
                            // Return CSS color values
                            const colors = {
                                'available': '#22c55e',  // green-500
                                'occupied': '#6b7280',   // gray-500
                                'reserved': '#eab308',   // yellow-500
                                'unavailable': '#ef4444' // red-500
                            };
                            return colors[status] || '#d1d5db'; // gray-300
                        },
                        
                        selectPlot(plotId) {
                            const plot = this.plots.find(p => p.id === plotId);
                            if (plot) {
                                this.selectedPlot = plot;
                            }
                        },
                        
                        toggleSelection(plotId) {
                            const index = this.selectedPlots.indexOf(plotId);
                            if (index > -1) {
                                this.selectedPlots.splice(index, 1);
                            } else {
                                this.selectedPlots.push(plotId);
                            }
                        },
                        
                        isSelected(plotId) {
                            return this.selectedPlots.includes(plotId);
                        },
                        
                        clearSelection() {
                            this.selectedPlots = [];
                        },
                        
                        bulkSetStatus(status) {
                            if (this.selectedPlots.length === 0) {
                                return;
                            }
                            
                            $wire.bulkSetStatus(this.selectedPlots, status);
                            this.clearSelection();
                        },
                        
                        changePlotStatus(plotId, newStatus) {
                            if (!plotId || !newStatus) {
                                return;
                            }
                            
                            // Call Livewire and let it refresh the component
                            $wire.changePlotStatus(plotId, newStatus);
                        }
                    }"
                    class="space-y-4"
                >
                    <!-- Bulk Actions -->
                    <div x-show="selectedPlots.length > 0" class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium">
                                Đã chọn <span x-text="selectedPlots.length"></span> lô
                            </span>
                            <div class="flex gap-2">
                                <button
                                    type="button"
                                    @click="bulkSetStatus('available')"
                                    class="px-3 py-1.5 text-xs font-medium text-white bg-green-600 rounded hover:bg-green-700"
                                >
                                    Đặt trống
                                </button>
                                <button
                                    type="button"
                                    @click="bulkSetStatus('unavailable')"
                                    class="px-3 py-1.5 text-xs font-medium text-white bg-red-600 rounded hover:bg-red-700"
                                >
                                    Không khả dụng
                                </button>
                                <button
                                    type="button"
                                    @click="clearSelection()"
                                    class="px-3 py-1.5 text-xs font-medium text-gray-700 bg-gray-200 rounded hover:bg-gray-300 dark:text-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600"
                                >
                                    Bỏ chọn
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Plot Management Panel - Hiển thị thông tin và quản lý lô -->
                    <div class="mb-4 p-4 rounded-lg border-2" 
                        :style="selectedPlot ? 'background-color: #dbeafe; border-color: #3b82f6;' : 'background-color: #f3f4f6; border-color: #d1d5db;'"
                        x-show="plots.length > 0"
                        style="transition: background-color 0.2s, border-color 0.2s;">
                        <template x-if="selectedPlot">
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <div class="font-bold text-lg" x-text="'Lô: ' + selectedPlot.plot_code" style="color: #1e40af;"></div>
                                    <button
                                        type="button"
                                        @click="selectedPlot = null"
                                        class="text-gray-500 hover:text-gray-700"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Thông tin lô -->
                                    <div class="space-y-2">
                                        <div class="text-sm">
                                            <strong>Vị trí:</strong> Hàng <span x-text="selectedPlot.row"></span>, Cột <span x-text="selectedPlot.column"></span>
                                        </div>
                                        <div class="text-sm">
                                            <strong>Trạng thái hiện tại:</strong> 
                                            <span class="px-2 py-1 rounded text-xs font-medium"
                                                  :style="selectedPlot.status === 'available' ? 'background-color: #dcfce7; color: #166534;' :
                                                          selectedPlot.status === 'occupied' ? 'background-color: #f3f4f6; color: #374151;' :
                                                          selectedPlot.status === 'reserved' ? 'background-color: #fef3c7; color: #92400e;' :
                                                          'background-color: #fee2e2; color: #991b1b;'"
                                                  x-text="selectedPlot.status === 'available' ? 'Còn trống' : 
                                                         selectedPlot.status === 'occupied' ? 'Đã sử dụng' : 
                                                         selectedPlot.status === 'reserved' ? 'Đã đặt trước' : 'Không khả dụng'"></span>
                                        </div>
                                        <template x-if="selectedPlot.grave">
                                            <div class="text-sm">
                                                <strong>Liệt sĩ:</strong> <span x-text="selectedPlot.grave.deceased_full_name"></span>
                                            </div>
                                        </template>
                                    </div>
                                    
                                    <!-- Quản lý trạng thái -->
                                    <div class="space-y-3">
                                        <div class="text-sm font-medium">Thay đổi trạng thái:</div>
                                        <div class="flex flex-wrap gap-2">
                                            <button
                                                type="button"
                                                @click="changePlotStatus(selectedPlot.id, 'available')"
                                                :disabled="selectedPlot.status === 'available'"
                                                class="px-3 py-1.5 text-xs font-medium rounded"
                                                :style="selectedPlot.status === 'available' ? 
                                                        'background-color: #22c55e; color: white; cursor: not-allowed; opacity: 0.6;' :
                                                        'background-color: #dcfce7; color: #166534; hover:bg-green-200;'"
                                            >
                                                Còn trống
                                            </button>
                                            <button
                                                type="button"
                                                @click="changePlotStatus(selectedPlot.id, 'reserved')"
                                                :disabled="selectedPlot.status === 'reserved'"
                                                class="px-3 py-1.5 text-xs font-medium rounded"
                                                :style="selectedPlot.status === 'reserved' ? 
                                                        'background-color: #eab308; color: white; cursor: not-allowed; opacity: 0.6;' :
                                                        'background-color: #fef3c7; color: #92400e; hover:bg-yellow-200;'"
                                            >
                                                Đặt trước
                                            </button>
                                            <button
                                                type="button"
                                                @click="changePlotStatus(selectedPlot.id, 'unavailable')"
                                                :disabled="selectedPlot.status === 'unavailable'"
                                                class="px-3 py-1.5 text-xs font-medium rounded"
                                                :style="selectedPlot.status === 'unavailable' ? 
                                                        'background-color: #ef4444; color: white; cursor: not-allowed; opacity: 0.6;' :
                                                        'background-color: #fee2e2; color: #991b1b; hover:bg-red-200;'"
                                            >
                                                Không khả dụng
                                            </button>
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            <template x-if="selectedPlot.status === 'occupied'">
                                                <span>Lô này đang có mộ, không thể thay đổi trạng thái</span>
                                            </template>
                                            <template x-if="selectedPlot.status !== 'occupied'">
                                                <span>Click vào nút để thay đổi trạng thái lô</span>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template x-if="!selectedPlot">
                            <div class="text-center text-gray-500">
                                <p>Click vào một ô trong lưới để quản lý lô mộ</p>
                            </div>
                        </template>
                    </div>

                    <!-- Grid with Row/Column Labels -->
                    <div class="overflow-x-auto" x-show="plots.length > 0 && maxRow > 0 && maxCol > 0">
                        <div class="inline-block">
                            <!-- Column Headers -->
                            <div style="display: flex; gap: 4px; margin-bottom: 4px; margin-left: 52px;">
                                <template x-for="col in maxCol" :key="'col-header-' + col">
                                    <div style="width: 48px; text-align: center; font-weight: 600; color: #6b7280; font-size: 12px;">
                                        <span x-text="col"></span>
                                    </div>
                                </template>
                            </div>

                            <!-- Grid Rows -->
                            <template x-for="row in maxRow" :key="'row-' + row">
                                <div style="display: flex; gap: 4px; margin-bottom: 4px;">
                                    <!-- Row Label -->
                                    <div style="width: 48px; display: flex; align-items: center; justify-content: center; font-weight: 600; color: #6b7280; font-size: 14px;">
                                        <span x-text="String.fromCharCode(64 + row)"></span>
                                    </div>

                                    <!-- Plot Cells -->
                                    <template x-for="col in maxCol" :key="'cell-' + row + '-' + col">
                                        <template x-for="plot in plots.filter(p => p.row === row && p.column === col)" :key="plot.id">
                                            <div
                                                @click="selectPlot(plot.id)"
                                                :style="{
                                                    width: '48px',
                                                    height: '48px',
                                                    borderRadius: '6px',
                                                    cursor: 'pointer',
                                                    display: 'flex',
                                                    alignItems: 'center',
                                                    justifyContent: 'center',
                                                    fontSize: '10px',
                                                    fontWeight: 'bold',
                                                    color: '#ffffff',
                                                    backgroundColor: getPlotColor(plot.status),
                                                    border: selectedPlot && selectedPlot.id === plot.id ? '3px solid #3b82f6' : '1px solid rgba(0,0,0,0.1)',
                                                    boxShadow: selectedPlot && selectedPlot.id === plot.id ? '0 4px 6px rgba(0,0,0,0.2)' : '0 1px 2px rgba(0,0,0,0.1)',
                                                    transition: 'all 0.15s'
                                                }"
                                                :title="plot.plot_code + ' - ' + plot.status + (plot.grave ? ' (' + plot.grave.deceased_full_name + ')' : '')"
                                            >
                                                <span x-text="plot.plot_code"></span>
                                            </div>
                                        </template>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- No Grid Message -->
                    <div class="text-center py-8" style="color: #9ca3af;" x-show="plots.length === 0 || maxRow === 0 || maxCol === 0">
                        <p>Không có dữ liệu lưới. Vui lòng tạo lưới bằng nút "Tạo lưới" phía trên.</p>
                    </div>
                </div>
            </x-filament::section>
        @else
            <x-filament::section>
                <div class="text-center py-12">
                    <div class="mb-4" style="color: #9ca3af;">
                        <svg class="mx-auto" style="width: 64px; height: 64px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium mb-2" style="color: #374151;">Chưa có lưới lô</h3>
                    <p class="text-sm" style="color: #9ca3af;">
                        Nhấn nút "Tạo lưới" ở góc trên để bắt đầu tạo lưới lô mộ.
                    </p>
                </div>
            </x-filament::section>
        @endif
    </div>
</x-filament-panels::page>

