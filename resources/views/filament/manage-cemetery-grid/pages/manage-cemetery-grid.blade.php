
<x-filament::page>
    {{-- @vite(['resources/css/frontend.css', 'resources/js/app.js']) --}}

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
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <span>Sơ đồ lưới lô mộ</span>
                        <button
                            type="button"
                            wire:click="toggleEditMode"
                            style="padding: 6px 12px; background-color: {{ $isEditMode ? '#ef4444' : '#3b82f6' }}; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 500;"
                            onmouseover="this.style.opacity='0.9'"
                            onmouseout="this.style.opacity='1'"
                        >
                            {{ $isEditMode ? 'Hủy chỉnh sửa' : 'Chỉnh sửa lưới' }}
                        </button>
                    </div>
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

                <!-- Instruction Box khi ở Edit Mode -->
                <div 
                    x-show="isEditMode"
                    x-transition
                    style="margin-bottom: 16px; padding: 12px 16px; background-color: #fef3c7; border: 1px solid #fbbf24; border-radius: 8px; display: none;"
                >
                    <div style="display: flex; align-items: start; gap: 12px;">
                        <div style="width: 20px; height: 20px; flex-shrink: 0; margin-top: 2px;">
                            <svg style="width: 100%; height: 100%; color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 600; color: #92400e; margin-bottom: 4px;">Chế độ chỉnh sửa lưới</div>
                            <div style="font-size: 14px; color: #78350f;">Click vào label hàng (A, B, C...) hoặc cột (1, 2, 3...) để chèn hoặc xóa. Sau khi hoàn tất, nhấn nút "Lưu thay đổi" để áp dụng.</div>
                        </div>
                    </div>
                </div>

                <!-- Save/Cancel Buttons -->
                <div 
                    x-show="isEditMode && (pendingChanges.insertedRows.length > 0 || pendingChanges.insertedColumns.length > 0 || pendingChanges.deletedRows.length > 0 || pendingChanges.deletedColumns.length > 0)"
                    x-transition
                    style="margin-bottom: 16px; padding: 12px 16px; background-color: #dbeafe; border: 1px solid #3b82f6; border-radius: 8px; display: none;"
                >
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div style="font-weight: 500; color: #1e40af;">
                            Có <span x-text="pendingChanges.insertedRows.length + pendingChanges.insertedColumns.length + pendingChanges.deletedRows.length + pendingChanges.deletedColumns.length"></span> thay đổi chờ lưu
                        </div>
                        <div style="display: flex; gap: 8px;">
                            <button
                                type="button"
                                @click="cancelChanges()"
                                style="padding: 8px 16px; background-color: #6b7280; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 500;"
                                onmouseover="this.style.backgroundColor='#4b5563'"
                                onmouseout="this.style.backgroundColor='#6b7280'"
                            >
                                Hủy
                            </button>
                            <button
                                type="button"
                                @click="saveChanges()"
                                style="padding: 8px 16px; background-color: #10b981; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 500;"
                                onmouseover="this.style.backgroundColor='#059669'"
                                onmouseout="this.style.backgroundColor='#10b981'"
                            >
                                Lưu thay đổi
                            </button>
                        </div>
                    </div>
                </div>

                <div
                    wire:key="cemetery-grid-{{ $cemetery->id }}-{{ $gridVersion }}-{{ now()->timestamp }}"
                    x-data="{
                        plots: @js($plots ?? []),
                        plotMap: {},
                        selectedPlots: [],
                        selectedPlot: null,
                        maxRow: @js($gridDimensions['rows'] ?? 0),
                        maxCol: @js($gridDimensions['columns'] ?? 0),
                        isRendering: false,
                        renderError: null,
                        isEditMode: @js($isEditMode ?? false),
                        pendingChanges: {
                            insertedRows: [],
                            insertedColumns: [],
                            deletedRows: [],
                            deletedColumns: []
                        },
                        selectedRowForAction: null,
                        selectedColumnForAction: null,
                        showRowActionModal: false,
                        showColumnActionModal: false,
                        showInsertRowModal: false,
                        showInsertColumnModal: false,
                        insertForm: {
                            count: 1,
                            direction: 'after'
                        },
                        
                        get hasPendingChanges() {
                            const hasChanges = this.pendingChanges.insertedRows.length > 0 ||
                                   this.pendingChanges.insertedColumns.length > 0 ||
                                   this.pendingChanges.deletedRows.length > 0 ||
                                   this.pendingChanges.deletedColumns.length > 0;
                            return hasChanges;
                        },
                        
                        init() {
                            try {
                                console.log('[CemeteryGrid] Initialized with', this.plots.length, 'plots');
                                this.buildPlotMap();
                                this.setupLivewireListeners();
                                
                                // Sync isEditMode từ backend
                                this.$watch('$wire.isEditMode', (value) => {
                                    this.isEditMode = value;
                                });
                            } catch (error) {
                                console.error('[CemeteryGrid] Init error:', error);
                                this.renderError = error.message;
                            }
                        },
                        
                        buildPlotMap() {
                            this.plotMap = {};
                            // Xây dựng map, ưu tiên plot có id (từ DB) hơn plot mới (id: null)
                            // Sắp xếp để plots có id được xử lý trước
                            const sortedPlots = [...this.plots].sort((a, b) => {
                                // Ưu tiên plots có id (từ DB) trước
                                if (a.id !== null && b.id === null) return -1;
                                if (a.id === null && b.id !== null) return 1;
                                return 0;
                            });
                            
                            sortedPlots.forEach(plot => {
                                const key = `${plot.row}-${plot.column}`;
                                if (!this.plotMap[key] || (plot.id !== null && this.plotMap[key].id === null)) {
                                    this.plotMap[key] = plot;
                                }
                            });
                        },
                        
                        setupLivewireListeners() {
                            document.addEventListener('livewire:update', () => {
                                this.scheduleRender();
                                // Sync isEditMode
                                if ($wire && $wire.isEditMode !== undefined) {
                                    this.isEditMode = $wire.isEditMode;
                                }
                            });
                        },
                        
                        scheduleRender() {
                            if (this.isRendering) return;
                            
                            this.isRendering = true;
                            requestAnimationFrame(() => {
                                try {
                                    this.buildPlotMap();
                                    this.isRendering = false;
                                } catch (error) {
                                    console.error('[CemeteryGrid] Render error:', error);
                                    this.renderError = error.message;
                                    this.isRendering = false;
                                }
                            });
                        },
                        
                        getPlotByPosition(row, col) {
                            try {
                                // Tìm plot theo row và column trực tiếp từ plots array
                                // Ưu tiên plot có id (từ DB) hơn plot mới (id: null)
                                const plotsAtPosition = this.plots.filter(p => p.row === row && p.column === col);
                                if (plotsAtPosition.length === 0) {
                                    return null;
                                }
                                // Nếu có nhiều plots ở cùng vị trí, ưu tiên plot có id
                                const plotWithId = plotsAtPosition.find(p => p.id !== null);
                                return plotWithId || plotsAtPosition[0];
                            } catch (error) {
                                console.error('[CemeteryGrid] Error getting plot:', error);
                                return null;
                            }
                        },
                        
                        getPlotColor(status) {
                            try {
                                const colors = {
                                    'available': '#22c55e',  // green-500
                                    'occupied': '#6b7280',   // gray-500
                                    'reserved': '#eab308',   // yellow-500
                                    'unavailable': '#ef4444' // red-500
                                };
                                return colors[status] || '#d1d5db'; // gray-300
                            } catch (error) {
                                console.error('[CemeteryGrid] Error getting color:', error);
                                return '#d1d5db';
                            }
                        },
                        
                        selectPlot(plotId) {
                            try {
                                const plot = this.plots.find(p => p.id === plotId);
                                if (plot) {
                                    this.selectedPlot = plot;
                                }
                            } catch (error) {
                                console.error('[CemeteryGrid] Error selecting plot:', error);
                            }
                        },
                        
                        toggleSelection(plotId) {
                            try {
                                const index = this.selectedPlots.indexOf(plotId);
                                if (index > -1) {
                                    this.selectedPlots.splice(index, 1);
                                } else {
                                    this.selectedPlots.push(plotId);
                                }
                            } catch (error) {
                                console.error('[CemeteryGrid] Error toggling selection:', error);
                            }
                        },
                        
                        isSelected(plotId) {
                            return this.selectedPlots.includes(plotId);
                        },
                        
                        clearSelection() {
                            this.selectedPlots = [];
                        },
                        
                        bulkSetStatus(status) {
                            try {
                                if (this.selectedPlots.length === 0) {
                                    return;
                                }
                                
                                $wire.bulkSetStatus(this.selectedPlots, status);
                                this.clearSelection();
                            } catch (error) {
                                console.error('[CemeteryGrid] Error bulk setting status:', error);
                                this.renderError = 'Không thể cập nhật. Vui lòng thử lại.';
                            }
                        },
                        
                        changePlotStatus(plotId, newStatus) {
                            try {
                                if (!plotId || !newStatus) {
                                    return;
                                }
                                
                                const plot = this.plots.find(p => p.id === plotId);

                                if (plot?.grave) {
                                    console.warn('[CemeteryGrid] Plot has grave, status change blocked');
                                    return;
                                }

                                // Call Livewire and let it refresh the component
                                $wire.changePlotStatus(plotId, newStatus);
                            } catch (error) {
                                console.error('[CemeteryGrid] Error changing status:', error);
                                this.renderError = 'Không thể thay đổi trạng thái. Vui lòng thử lại.';
                            }
                        },
                        
                        openRowActionModal(row) {
                            this.selectedRowForAction = row;
                            this.showRowActionModal = true;
                        },
                        
                        openColumnActionModal(col) {
                            this.selectedColumnForAction = col;
                            this.showColumnActionModal = true;
                        },
                        
                        closeRowActionModal() {
                            this.showRowActionModal = false;
                            this.selectedRowForAction = null;
                        },
                        
                        closeColumnActionModal() {
                            this.showColumnActionModal = false;
                            this.selectedColumnForAction = null;
                        },
                        
                        openInsertRowModal(direction) {
                            this.insertForm.count = 1;
                            this.insertForm.direction = direction;
                            this.insertForm.position = this.selectedRowForAction;
                            this.showRowActionModal = false;
                            this.showInsertRowModal = true;
                        },
                        
                        openInsertColumnModal(direction) {
                            this.insertForm.count = 1;
                            this.insertForm.direction = direction;
                            this.insertForm.position = this.selectedColumnForAction;
                            this.showColumnActionModal = false;
                            this.showInsertColumnModal = true;
                        },
                        
                        insertRow() {
                            try {
                                if (!this.insertForm.position || !this.insertForm.count) {
                                    return;
                                }
                                
                                // Thêm vào pendingChanges
                                this.pendingChanges.insertedRows.push({
                                    position: this.insertForm.position,
                                    count: this.insertForm.count,
                                    direction: this.insertForm.direction
                                });
                                
                                // Cập nhật trong memory
                                this.applyRowInsertInMemory(this.insertForm.position, this.insertForm.count, this.insertForm.direction);
                                
                                this.showInsertRowModal = false;
                            } catch (error) {
                                console.error('[CemeteryGrid] Error inserting row:', error);
                                this.renderError = 'Không thể chèn hàng. Vui lòng thử lại.';
                            }
                        },
                        
                        insertColumn() {
                            try {
                                if (!this.insertForm.position || !this.insertForm.count) {
                                    return;
                                }
                                
                                // Thêm vào pendingChanges
                                this.pendingChanges.insertedColumns.push({
                                    position: this.insertForm.position,
                                    count: this.insertForm.count,
                                    direction: this.insertForm.direction
                                });
                                
                                // Cập nhật trong memory
                                this.applyColumnInsertInMemory(this.insertForm.position, this.insertForm.count, this.insertForm.direction);
                                
                                this.showInsertColumnModal = false;
                            } catch (error) {
                                console.error('[CemeteryGrid] Error inserting column:', error);
                                this.renderError = 'Không thể chèn cột. Vui lòng thử lại.';
                            }
                        },
                        
                        deleteRow(row) {
                            if (!confirm('Bạn có chắc muốn xóa hàng ' + String.fromCharCode(64 + row) + '?')) {
                                return;
                            }
                            
                            // Kiểm tra có thể xóa không
                            if (!this.canDeleteRow(row)) {
                                alert('Không thể xóa hàng này vì có lô đang được sử dụng.');
                                return;
                            }
                            
                            // Thêm vào pendingChanges
                            if (!this.pendingChanges.deletedRows.includes(row)) {
                                this.pendingChanges.deletedRows.push(row);
                            }
                            
                            // Cập nhật trong memory
                            this.applyRowDeleteInMemory(row);
                            this.closeRowActionModal();
                        },
                        
                        deleteColumn(col) {
                            if (!confirm('Bạn có chắc muốn xóa cột ' + col + '?')) {
                                return;
                            }
                            
                            // Kiểm tra có thể xóa không
                            if (!this.canDeleteColumn(col)) {
                                alert('Không thể xóa cột này vì có lô đang được sử dụng.');
                                return;
                            }
                            
                            // Thêm vào pendingChanges
                            if (!this.pendingChanges.deletedColumns.includes(col)) {
                                this.pendingChanges.deletedColumns.push(col);
                            }
                            
                            // Cập nhật trong memory
                            this.applyColumnDeleteInMemory(col);
                            this.closeColumnActionModal();
                        },
                        
                        applyRowInsertInMemory(position, count, direction) {
                            // Tính vị trí bắt đầu chèn
                            const startRow = direction === 'before' ? position : position + 1;
                            
                            // Bước 1: Xóa các plots mới (id: null) ở vị trí sẽ bị shift để tránh conflict
                            this.plots = this.plots.filter(plot => {
                                if (plot.id === null && plot.row >= startRow) {
                                    return false; // Xóa plot mới ở vị trí sẽ bị shift
                                }
                                return true;
                            });
                            
                            // Bước 2: Shift TẤT CẢ các plots còn lại (có id từ DB) có row >= startRow
                            // Đẩy lùi các hàng ra sau và đổi tên (plot_code)
                            // Sắp xếp theo row giảm dần để tránh conflict khi shift
                            const plotsToShift = this.plots.filter(p => p.row >= startRow)
                                .sort((a, b) => b.row - a.row); // Sort giảm dần
                            
                            plotsToShift.forEach(plot => {
                                plot.row += count;
                                plot.plot_code = this.generatePlotCode(plot.row, plot.column);
                            });
                            
                            // Bước 3: Tạo plots mới HOÀN TOÀN cho các hàng vừa chèn ở vị trí startRow
                            // Các plots mới này sẽ có status: 'available' (KHÔNG copy từ hàng cũ)
                            const newPlots = [];
                            for (let i = 0; i < count; i++) {
                                const newRow = startRow + i;
                                for (let col = 1; col <= this.maxCol; col++) {
                                    // Luôn tạo plot mới ở vị trí này (đã xóa plots mới ở bước 1, đã shift plots cũ ở bước 2)
                                    newPlots.push({
                                        id: null,
                                        plot_code: this.generatePlotCode(newRow, col),
                                        row: newRow,
                                        column: col,
                                        status: 'available',
                                        grave: null
                                    });
                                }
                            }
                            
                            // Thêm plots mới vào array
                            this.plots.push(...newPlots);
                            
                            this.maxRow += count;
                            this.buildPlotMap();
                        },
                        
                        applyColumnInsertInMemory(position, count, direction) {
                            // Tính vị trí bắt đầu chèn
                            const startColumn = direction === 'before' ? position : position + 1;
                            
                            // Bước 1: Xóa các plots mới (id: null) ở vị trí sẽ bị shift để tránh conflict
                            this.plots = this.plots.filter(plot => {
                                if (plot.id === null && plot.column >= startColumn) {
                                    return false; // Xóa plot mới ở vị trí sẽ bị shift
                                }
                                return true;
                            });
                            
                            // Bước 2: Shift TẤT CẢ các plots còn lại (có id từ DB) có column >= startColumn
                            // Đẩy lùi các cột ra sau và đổi tên (plot_code)
                            // Sắp xếp theo column giảm dần để tránh conflict khi shift
                            const plotsToShift = this.plots.filter(p => p.column >= startColumn)
                                .sort((a, b) => b.column - a.column); // Sort giảm dần
                            
                            plotsToShift.forEach(plot => {
                                plot.column += count;
                                plot.plot_code = this.generatePlotCode(plot.row, plot.column);
                            });
                            
                            // Bước 3: Tạo plots mới HOÀN TOÀN cho các cột vừa chèn ở vị trí startColumn
                            // Các plots mới này sẽ có status: 'available' (KHÔNG copy từ cột cũ)
                            const newPlots = [];
                            for (let i = 0; i < count; i++) {
                                const newColumn = startColumn + i;
                                for (let row = 1; row <= this.maxRow; row++) {
                                    // Luôn tạo plot mới ở vị trí này (đã xóa plots mới ở bước 1, đã shift plots cũ ở bước 2)
                                    newPlots.push({
                                        id: null,
                                        plot_code: this.generatePlotCode(row, newColumn),
                                        row: row,
                                        column: newColumn,
                                        status: 'available',
                                        grave: null
                                    });
                                }
                            }
                            
                            // Thêm plots mới vào array
                            this.plots.push(...newPlots);
                            
                            this.maxCol += count;
                            this.buildPlotMap();
                        },
                        
                        applyRowDeleteInMemory(rowNumber) {
                            // Xóa plots trong hàng
                            this.plots = this.plots.filter(plot => plot.row !== rowNumber);
                            
                            // Shift các hàng sau
                            this.plots.forEach(plot => {
                                if (plot.row > rowNumber) {
                                    plot.row -= 1;
                                    plot.plot_code = this.generatePlotCode(plot.row, plot.column);
                                }
                            });
                            
                            this.maxRow -= 1;
                            this.buildPlotMap();
                        },
                        
                        applyColumnDeleteInMemory(columnNumber) {
                            // Xóa plots trong cột
                            this.plots = this.plots.filter(plot => plot.column !== columnNumber);
                            
                            // Shift các cột sau
                            this.plots.forEach(plot => {
                                if (plot.column > columnNumber) {
                                    plot.column -= 1;
                                    plot.plot_code = this.generatePlotCode(plot.row, plot.column);
                                }
                            });
                            
                            this.maxCol -= 1;
                            this.buildPlotMap();
                        },
                        
                        generatePlotCode(row, column) {
                            // Convert row to letter (1=A, 2=B, ..., 26=Z, 27=AA, etc.)
                            let letter = '';
                            let temp = row;
                            while (temp > 0) {
                                temp--;
                                letter = String.fromCharCode(65 + (temp % 26)) + letter;
                                temp = Math.floor(temp / 26);
                            }
                            return letter + column;
                        },
                        
                        saveChanges() {
                            if (!this.hasPendingChanges) {
                                return;
                            }
                            
                            $wire.saveGridChanges(this.pendingChanges).then(() => {
                                // Reset pendingChanges
                                this.pendingChanges = {
                                    insertedRows: [],
                                    insertedColumns: [],
                                    deletedRows: [],
                                    deletedColumns: []
                                };
                                
                                // Refresh plots từ server
                                this.plots = $wire.plots || this.plots;
                                this.maxRow = $wire.gridDimensions?.rows || this.maxRow;
                                this.maxCol = $wire.gridDimensions?.columns || this.maxCol;
                                this.buildPlotMap();
                                this.isEditMode = false;
                            });
                        },
                        
                        cancelChanges() {
                            if (!confirm('Bạn có chắc muốn hủy tất cả thay đổi?')) {
                                return;
                            }
                            
                            // Reset pendingChanges
                            this.pendingChanges = {
                                insertedRows: [],
                                insertedColumns: [],
                                deletedRows: [],
                                deletedColumns: []
                            };
                            
                            // Reload từ server và tắt edit mode
                            $wire.toggleEditMode().then(() => {
                                this.plots = $wire.plots || this.plots;
                                this.maxRow = $wire.gridDimensions?.rows || this.maxRow;
                                this.maxCol = $wire.gridDimensions?.columns || this.maxCol;
                                this.buildPlotMap();
                                this.isEditMode = false;
                            });
                        },
                        
                        canDeleteRow(row) {
                            // Kiểm tra xem hàng có lô nào có grave không
                            for (let col = 1; col <= this.maxCol; col++) {
                                const plot = this.getPlotByPosition(row, col);
                                if (plot && plot.grave) {
                                    return false;
                                }
                            }
                            return true;
                        },
                        
                        canDeleteColumn(col) {
                            // Kiểm tra xem cột có lô nào có grave không
                            for (let row = 1; row <= this.maxRow; row++) {
                                const plot = this.getPlotByPosition(row, col);
                                if (plot && plot.grave) {
                                    return false;
                                }
                            }
                            return true;
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
                                                :disabled="selectedPlot.status === 'available' || selectedPlot.grave"
                                                class="px-3 py-1.5 text-xs font-medium rounded"
                                                :style="selectedPlot.status === 'available' || selectedPlot.grave ? 
                                                        'background-color: #22c55e; color: white; cursor: not-allowed; opacity: 0.6;' :
                                                        'background-color: #dcfce7; color: #166534; hover:bg-green-200;'"
                                            >
                                                Còn trống
                                            </button>
                                            <button
                                                type="button"
                                                @click="changePlotStatus(selectedPlot.id, 'reserved')"
                                                :disabled="selectedPlot.status === 'reserved' || selectedPlot.grave"
                                                class="px-3 py-1.5 text-xs font-medium rounded"
                                                :style="selectedPlot.status === 'reserved' || selectedPlot.grave ? 
                                                        'background-color: #eab308; color: white; cursor: not-allowed; opacity: 0.6;' :
                                                        'background-color: #fef3c7; color: #92400e; hover:bg-yellow-200;'"
                                            >
                                                Đặt trước
                                            </button>
                                            <button
                                                type="button"
                                                @click="changePlotStatus(selectedPlot.id, 'unavailable')"
                                                :disabled="selectedPlot.status === 'unavailable' || selectedPlot.grave"
                                                class="px-3 py-1.5 text-xs font-medium rounded"
                                                :style="selectedPlot.status === 'unavailable' || selectedPlot.grave ? 
                                                        'background-color: #ef4444; color: white; cursor: not-allowed; opacity: 0.6;' :
                                                        'background-color: #fee2e2; color: #991b1b; hover:bg-red-200;'"
                                            >
                                                Không khả dụng
                                            </button>
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            <template x-if="selectedPlot.grave">
                                                <span>Lô này đang có mộ, không thể thay đổi trạng thái</span>
                                            </template>
                                            <template x-if="!selectedPlot.grave">
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
                                    <div 
                                        :style="isEditMode ? 
                                            'width: 48px; text-align: center; font-weight: 600; color: #92400e; font-size: 12px; position: relative; cursor: pointer; user-select: none; background-color: #fef3c7; border: 2px solid #fbbf24; border-radius: 6px;' :
                                            'width: 48px; text-align: center; font-weight: 600; color: #6b7280; font-size: 12px; position: relative; cursor: default; user-select: none;'"
                                        @click.stop="isEditMode && openColumnActionModal(col)"
                                        :onmouseover="isEditMode ? 'this.style.backgroundColor=\'#fde68a\'' : ''"
                                        :onmouseout="isEditMode ? 'this.style.backgroundColor=\'#fef3c7\'' : ''"
                                    >
                                        <span x-text="col"></span>
                                    </div>
                                </template>
                            </div>

                            <!-- Grid Rows -->
                            <template x-for="row in maxRow" :key="'row-' + row">
                                <div style="display: flex; gap: 4px; margin-bottom: 4px;">
                                    <!-- Row Label -->
                                    <div 
                                        :style="isEditMode ? 
                                            'width: 48px; display: flex; align-items: center; justify-content: center; font-weight: 600; color: #92400e; font-size: 14px; position: relative; cursor: pointer; user-select: none; background-color: #fef3c7; border: 2px solid #fbbf24; border-radius: 6px;' :
                                            'width: 48px; display: flex; align-items: center; justify-content: center; font-weight: 600; color: #6b7280; font-size: 14px; position: relative; cursor: default; user-select: none;'"
                                        @click.stop="isEditMode && openRowActionModal(row)"
                                        :onmouseover="isEditMode ? 'this.style.backgroundColor=\'#fde68a\'' : ''"
                                        :onmouseout="isEditMode ? 'this.style.backgroundColor=\'#fef3c7\'' : ''"
                                    >
                                        <span x-text="String.fromCharCode(64 + row)"></span>
                                    </div>

                                    <!-- Plot Cells - Using plotMap for O(1) lookup -->
                                    <template x-for="col in maxCol" :key="'cell-' + row + '-' + col">
                                        <div
                                            x-data="{ plot: getPlotByPosition(row, col) }"
                                            @click="plot && selectPlot(plot.id)"
                                            :style="plot ? {
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
                                            } : {
                                                width: '48px',
                                                height: '48px',
                                                backgroundColor: 'transparent'
                                            }"
                                            :title="plot ? (plot.plot_code + ' - ' + plot.status + (plot.grave ? ' (' + plot.grave.deceased_full_name + ')' : '')) : ''"
                                        >
                                            <span x-show="plot" x-text="plot ? plot.plot_code : ''"></span>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- No Grid Message -->
                    <div class="text-center py-8" style="color: #9ca3af;" x-show="plots.length === 0 || maxRow === 0 || maxCol === 0">
                        <p>Không có dữ liệu lưới. Vui lòng tạo lưới bằng nút "Tạo lưới" phía trên.</p>
                    </div>

                    <!-- Modal action hàng -->
                    <div 
                        x-show="showRowActionModal"
                        x-transition
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
                        @click.self="closeRowActionModal()"
                        style="display: none;"
                    >
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 w-full max-w-sm" @click.stop>
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold">Hàng <span x-text="selectedRowForAction ? String.fromCharCode(64 + selectedRowForAction) : ''"></span></h3>
                                <button
                                    type="button"
                                    @click="closeRowActionModal()"
                                    class="text-gray-500 hover:text-gray-700"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="space-y-3">
                                <button
                                    type="button"
                                    @click="openInsertRowModal('before')"
                                    class="w-full px-4 py-3 text-left bg-orange-50 dark:bg-orange-900/20 hover:bg-orange-100 dark:hover:bg-orange-900/30 rounded-lg transition-colors flex items-center gap-3"
                                >
                                    <div style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background-color: #f97316; border-radius: 6px;">
                                        <svg style="width: 18px; height: 18px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium">Chèn hàng trước</div>
                                        <div class="text-sm text-gray-500">Thêm hàng mới trước hàng này</div>
                                    </div>
                                </button>
                                <button
                                    type="button"
                                    @click="openInsertRowModal('after')"
                                    class="w-full px-4 py-3 text-left bg-orange-50 dark:bg-orange-900/20 hover:bg-orange-100 dark:hover:bg-orange-900/30 rounded-lg transition-colors flex items-center gap-3"
                                >
                                    <div style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background-color: #f97316; border-radius: 6px;">
                                        <svg style="width: 18px; height: 18px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium">Chèn hàng sau</div>
                                        <div class="text-sm text-gray-500">Thêm hàng mới sau hàng này</div>
                                    </div>
                                </button>
                                <button
                                    type="button"
                                    @click="deleteRow(selectedRowForAction); closeRowActionModal()"
                                    :disabled="!canDeleteRow(selectedRowForAction)"
                                    :class="canDeleteRow(selectedRowForAction) ? 'bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30' : 'bg-gray-100 dark:bg-gray-700 opacity-50 cursor-not-allowed'"
                                    class="w-full px-4 py-3 text-left rounded-lg transition-colors flex items-center gap-3"
                                    :title="canDeleteRow(selectedRowForAction) ? 'Xóa hàng' : 'Không thể xóa hàng (có lô đang sử dụng)'"
                                >
                                    <div style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background-color: #ef4444; border-radius: 6px;">
                                        <svg style="width: 18px; height: 18px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium">Xóa hàng</div>
                                        <div class="text-sm text-gray-500">Xóa hàng này (chỉ khi không có lô đang sử dụng)</div>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal action cột -->
                    <div 
                        x-show="showColumnActionModal"
                        x-transition
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
                        @click.self="closeColumnActionModal()"
                        style="display: none;"
                    >
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 w-full max-w-sm" @click.stop>
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold">Cột <span x-text="selectedColumnForAction || ''"></span></h3>
                                <button
                                    type="button"
                                    @click="closeColumnActionModal()"
                                    class="text-gray-500 hover:text-gray-700"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="space-y-3">
                                <button
                                    type="button"
                                    @click="openInsertColumnModal('before')"
                                    class="w-full px-4 py-3 text-left bg-orange-50 dark:bg-orange-900/20 hover:bg-orange-100 dark:hover:bg-orange-900/30 rounded-lg transition-colors flex items-center gap-3"
                                >
                                    <div style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background-color: #f97316; border-radius: 6px;">
                                        <svg style="width: 18px; height: 18px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium">Chèn cột trước</div>
                                        <div class="text-sm text-gray-500">Thêm cột mới trước cột này</div>
                                    </div>
                                </button>
                                <button
                                    type="button"
                                    @click="openInsertColumnModal('after')"
                                    class="w-full px-4 py-3 text-left bg-orange-50 dark:bg-orange-900/20 hover:bg-orange-100 dark:hover:bg-orange-900/30 rounded-lg transition-colors flex items-center gap-3"
                                >
                                    <div style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background-color: #f97316; border-radius: 6px;">
                                        <svg style="width: 18px; height: 18px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium">Chèn cột sau</div>
                                        <div class="text-sm text-gray-500">Thêm cột mới sau cột này</div>
                                    </div>
                                </button>
                                <button
                                    type="button"
                                    @click="deleteColumn(selectedColumnForAction); closeColumnActionModal()"
                                    :disabled="!canDeleteColumn(selectedColumnForAction)"
                                    :class="canDeleteColumn(selectedColumnForAction) ? 'bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30' : 'bg-gray-100 dark:bg-gray-700 opacity-50 cursor-not-allowed'"
                                    class="w-full px-4 py-3 text-left rounded-lg transition-colors flex items-center gap-3"
                                    :title="canDeleteColumn(selectedColumnForAction) ? 'Xóa cột' : 'Không thể xóa cột (có lô đang sử dụng)'"
                                >
                                    <div style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background-color: #ef4444; border-radius: 6px;">
                                        <svg style="width: 18px; height: 18px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium">Xóa cột</div>
                                        <div class="text-sm text-gray-500">Xóa cột này (chỉ khi không có lô đang sử dụng)</div>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal chèn hàng -->
                    <div 
                        x-show="showInsertRowModal"
                        x-transition
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
                        @click.self="showInsertRowModal = false"
                        style="display: none;"
                    >
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 w-full max-w-md" @click.stop>
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold">Chèn hàng</h3>
                                <button
                                    type="button"
                                    @click="showInsertRowModal = false"
                                    class="text-gray-500 hover:text-gray-700"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium mb-2">Số lượng hàng muốn chèn</label>
                                    <input
                                        type="number"
                                        x-model.number="insertForm.count"
                                        min="1"
                                        max="10"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white"
                                    />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-2">Vị trí chèn</label>
                                    <div class="space-y-2">
                                        <label class="flex items-center">
                                            <input
                                                type="radio"
                                                x-model="insertForm.direction"
                                                value="before"
                                                class="mr-2"
                                            />
                                            <span>Trước hàng <span x-text="insertForm.position ? String.fromCharCode(64 + insertForm.position) : ''"></span></span>
                                        </label>
                                        <label class="flex items-center">
                                            <input
                                                type="radio"
                                                x-model="insertForm.direction"
                                                value="after"
                                                class="mr-2"
                                            />
                                            <span>Sau hàng <span x-text="insertForm.position ? String.fromCharCode(64 + insertForm.position) : ''"></span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="flex gap-2 justify-end">
                                    <button
                                        type="button"
                                        @click="showInsertRowModal = false"
                                        class="px-4 py-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300 dark:text-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600"
                                    >
                                        Hủy
                                    </button>
                                    <button
                                        type="button"
                                        @click="insertRow()"
                                        class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700"
                                    >
                                        Chèn
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal chèn cột -->
                    <div 
                        x-show="showInsertColumnModal"
                        x-transition
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
                        @click.self="showInsertColumnModal = false"
                        style="display: none;"
                    >
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 w-full max-w-md" @click.stop>
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold">Chèn cột</h3>
                                <button
                                    type="button"
                                    @click="showInsertColumnModal = false"
                                    class="text-gray-500 hover:text-gray-700"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium mb-2">Số lượng cột muốn chèn</label>
                                    <input
                                        type="number"
                                        x-model.number="insertForm.count"
                                        min="1"
                                        max="10"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white"
                                    />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-2">Vị trí chèn</label>
                                    <div class="space-y-2">
                                        <label class="flex items-center">
                                            <input
                                                type="radio"
                                                x-model="insertForm.direction"
                                                value="before"
                                                class="mr-2"
                                            />
                                            <span>Trước cột <span x-text="insertForm.position || ''"></span></span>
                                        </label>
                                        <label class="flex items-center">
                                            <input
                                                type="radio"
                                                x-model="insertForm.direction"
                                                value="after"
                                                class="mr-2"
                                            />
                                            <span>Sau cột <span x-text="insertForm.position || ''"></span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="flex gap-2 justify-end">
                                    <button
                                        type="button"
                                        @click="showInsertColumnModal = false"
                                        class="px-4 py-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300 dark:text-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600"
                                    >
                                        Hủy
                                    </button>
                                    <button
                                        type="button"
                                        @click="insertColumn()"
                                        class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700"
                                    >
                                        Chèn
                                    </button>
                                </div>
                            </div>
                        </div>
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

