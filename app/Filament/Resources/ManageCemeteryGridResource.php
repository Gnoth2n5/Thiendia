<?php

namespace App\Filament\Resources;

use App\Models\Cemetery;
use App\Models\CemeteryPlot;
use Filament\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class ManageCemeteryGridResource extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static string $view = 'filament.manage-cemetery-grid.pages.manage-cemetery-grid';

    protected static ?string $navigationLabel = 'Quản lý lưới lô';

    protected static ?string $title = 'Quản lý lưới lô nghĩa trang';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationGroup = 'Quản lý nghĩa trang';

    public ?array $data = [];

    public Cemetery $cemetery;

    public ?array $plots = null;

    public ?array $gridDimensions = null;

    public int $gridVersion = 0;

    public function mount(?int $cemetery = null): void
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // Get cemetery from URL parameter or first cemetery as default
        if ($cemetery) {
            $this->cemetery = Cemetery::findOrFail($cemetery);

            // Kiểm tra quyền truy cập nghĩa trang
            if ($user->isCommuneStaff() && $this->cemetery->commune !== $user->commune) {
                abort(403, 'Bạn không có quyền truy cập nghĩa trang này.');
            }
        } else {
            // Lấy nghĩa trang đầu tiên theo quyền của user
            $query = Cemetery::query();
            if ($user->isCommuneStaff()) {
                $query->where('commune', $user->commune);
            }
            $this->cemetery = $query->first();
        }

        if ($this->cemetery) {
            $this->loadPlots();
        }

        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Cài đặt lưới')
                    ->schema([
                        TextInput::make('rows')
                            ->label('Số hàng')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(50)
                            ->default(10),

                        TextInput::make('columns')
                            ->label('Số cột')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(50)
                            ->default(15),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    protected function loadPlots(): void
    {
        $this->gridDimensions = $this->cemetery->getGridDimensions();

        $plots = CemeteryPlot::where('cemetery_id', $this->cemetery->id)
            ->with('grave:id,plot_id,deceased_full_name')
            ->orderBy('row')
            ->orderBy('column')
            ->get();

        // Convert to array and ensure grave relationship is properly formatted
        $this->plots = $plots->map(function ($plot) {
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

        // Increment version to force re-render
        $this->gridVersion++;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('select_cemetery')
                ->label('Chọn nghĩa trang')
                ->icon('heroicon-o-building-office-2')
                ->form([
                    \Filament\Forms\Components\Select::make('cemetery_id')
                        ->label('Nghĩa trang')
                        ->options(function () {
                            /** @var \App\Models\User $user */
                            $user = auth()->user();
                            $query = Cemetery::query();

                            // Nếu là cán bộ xã/phường, chỉ hiển thị nghĩa trang của xã/phường mình
                            if ($user->isCommuneStaff()) {
                                $query->where('commune', $user->commune);
                            }

                            return $query->pluck('name', 'id');
                        })
                        ->required()
                        ->searchable()
                        ->default($this->cemetery->id),
                ])
                ->action(function (array $data): void {
                    /** @var \App\Models\User $user */
                    $user = auth()->user();
                    $cemetery = Cemetery::findOrFail($data['cemetery_id']);

                    // Kiểm tra quyền truy cập
                    if ($user->isCommuneStaff() && $cemetery->commune !== $user->commune) {
                        Notification::make()
                            ->title('Không có quyền truy cập')
                            ->danger()
                            ->body('Bạn không có quyền truy cập nghĩa trang này.')
                            ->send();

                        return;
                    }

                    $this->cemetery = $cemetery;
                    $this->loadPlots();

                    Notification::make()
                        ->title('Đã chuyển sang nghĩa trang: ' . $this->cemetery->name)
                        ->success()
                        ->send();
                }),

            Action::make('create_grid')
                ->label('Tạo lưới')
                ->icon('heroicon-o-plus-circle')
                ->color('success')
                ->requiresConfirmation()
                ->form([
                    TextInput::make('rows')
                        ->label('Số hàng')
                        ->required()
                        ->numeric()
                        ->minValue(1)
                        ->maxValue(50)
                        ->default(10),

                    TextInput::make('columns')
                        ->label('Số cột')
                        ->required()
                        ->numeric()
                        ->minValue(1)
                        ->maxValue(50)
                        ->default(15),

                    \Filament\Forms\Components\Checkbox::make('clear_existing')
                        ->label('Xóa lưới hiện tại')
                        ->helperText('Nếu chọn, tất cả lô cũ sẽ bị xóa trước khi tạo mới')
                        ->default(false),
                ])
                ->action(function (array $data): void {
                    $count = $this->cemetery->initializePlots(
                        rows: $data['rows'],
                        columns: $data['columns'],
                        clearExisting: $data['clear_existing'] ?? false
                    );

                    $this->loadPlots();

                    Notification::make()
                        ->title("Đã tạo {$count} lô mộ")
                        ->success()
                        ->send();
                }),

            Action::make('reset_grid')
                ->label('Xóa toàn bộ lưới')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Xác nhận xóa lưới')
                ->modalDescription('Bạn có chắc muốn xóa toàn bộ lưới? Hành động này không thể hoàn tác.')
                ->action(function (): void {
                    $count = CemeteryPlot::where('cemetery_id', $this->cemetery->id)->count();
                    CemeteryPlot::where('cemetery_id', $this->cemetery->id)->delete();

                    $this->loadPlots();

                    Notification::make()
                        ->title("Đã xóa {$count} lô mộ")
                        ->warning()
                        ->send();
                }),
        ];
    }

    public function changePlotStatus(int $plotId, string $newStatus): void
    {
        $plot = CemeteryPlot::findOrFail($plotId);

        // Không cho phép thay đổi status của lô đã có mộ
        if ($plot->grave_id && $newStatus !== 'occupied') {
            Notification::make()
                ->title('Không thể thay đổi trạng thái')
                ->body('Lô này đang có mộ liệt sĩ.')
                ->warning()
                ->send();

            return;
        }

        $plot->update(['status' => $newStatus]);
        $this->loadPlots();

        Notification::make()
            ->title('Đã cập nhật trạng thái lô ' . $plot->plot_code)
            ->success()
            ->send();
    }

    public function togglePlotStatus(int $plotId, string $newStatus): void
    {
        $this->changePlotStatus($plotId, $newStatus);
    }

    public function bulkSetStatus(array $plotIds, string $status): void
    {
        $count = CemeteryPlot::whereIn('id', $plotIds)
            ->whereDoesntHave('grave') // Chỉ update các lô chưa có mộ
            ->update(['status' => $status]);

        $this->loadPlots();

        Notification::make()
            ->title("Đã cập nhật {$count} lô mộ")
            ->success()
            ->send();
    }

    public function insertRows(int $position, int $count, string $direction): void
    {
        DB::transaction(function () use ($position, $count, $direction) {
            // Tính toán vị trí bắt đầu shift
            $startRow = $direction === 'before' ? $position : $position + 1;

            // Shift tất cả các hàng từ vị trí đó trở đi
            CemeteryPlot::where('cemetery_id', $this->cemetery->id)
                ->where('row', '>=', $startRow)
                ->increment('row', $count);

            // Tạo các lô mới cho hàng vừa chèn
            $maxColumn = $this->gridDimensions['columns'] ?? 0;
            $plotsData = [];

            for ($i = 0; $i < $count; $i++) {
                $newRow = $startRow + $i;
                for ($col = 1; $col <= $maxColumn; $col++) {
                    $plotsData[] = [
                        'cemetery_id' => $this->cemetery->id,
                        'plot_code' => CemeteryPlot::generatePlotCode($newRow, $col),
                        'row' => $newRow,
                        'column' => $col,
                        'status' => 'available',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            if (!empty($plotsData)) {
                CemeteryPlot::insert($plotsData);
            }

            // Cập nhật lại plot_code cho tất cả lô bị ảnh hưởng
            $this->updatePlotCodesAfterShift();
        });

        $this->loadPlots();

        Notification::make()
            ->title("Đã chèn {$count} hàng")
            ->success()
            ->send();
    }

    public function insertColumns(int $position, int $count, string $direction): void
    {
        DB::transaction(function () use ($position, $count, $direction) {
            // Tính toán vị trí bắt đầu shift
            $startColumn = $direction === 'before' ? $position : $position + 1;

            // Shift tất cả các cột từ vị trí đó trở đi
            CemeteryPlot::where('cemetery_id', $this->cemetery->id)
                ->where('column', '>=', $startColumn)
                ->increment('column', $count);

            // Tạo các lô mới cho cột vừa chèn
            $maxRow = $this->gridDimensions['rows'] ?? 0;
            $plotsData = [];

            for ($i = 0; $i < $count; $i++) {
                $newColumn = $startColumn + $i;
                for ($row = 1; $row <= $maxRow; $row++) {
                    $plotsData[] = [
                        'cemetery_id' => $this->cemetery->id,
                        'plot_code' => CemeteryPlot::generatePlotCode($row, $newColumn),
                        'row' => $row,
                        'column' => $newColumn,
                        'status' => 'available',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            if (!empty($plotsData)) {
                CemeteryPlot::insert($plotsData);
            }

            // Cập nhật lại plot_code cho tất cả lô bị ảnh hưởng
            $this->updatePlotCodesAfterShift();
        });

        $this->loadPlots();

        Notification::make()
            ->title("Đã chèn {$count} cột")
            ->success()
            ->send();
    }

    public function deleteRow(int $rowNumber): void
    {
        if (!$this->canDeleteRow($rowNumber)) {
            Notification::make()
                ->title('Không thể xóa hàng')
                ->body('Hàng này có lô đang được sử dụng (có mộ liệt sĩ).')
                ->warning()
                ->send();

            return;
        }

        DB::transaction(function () use ($rowNumber) {
            // Xóa tất cả lô trong hàng đó
            CemeteryPlot::where('cemetery_id', $this->cemetery->id)
                ->where('row', $rowNumber)
                ->delete();

            // Shift các hàng sau: row = row - 1
            CemeteryPlot::where('cemetery_id', $this->cemetery->id)
                ->where('row', '>', $rowNumber)
                ->decrement('row');

            // Cập nhật lại plot_code cho tất cả lô bị ảnh hưởng
            $this->updatePlotCodesAfterShift();
        });

        $this->loadPlots();

        Notification::make()
            ->title("Đã xóa hàng {$rowNumber}")
            ->success()
            ->send();
    }

    public function deleteColumn(int $columnNumber): void
    {
        if (!$this->canDeleteColumn($columnNumber)) {
            Notification::make()
                ->title('Không thể xóa cột')
                ->body('Cột này có lô đang được sử dụng (có mộ liệt sĩ).')
                ->warning()
                ->send();

            return;
        }

        DB::transaction(function () use ($columnNumber) {
            // Xóa tất cả lô trong cột đó
            CemeteryPlot::where('cemetery_id', $this->cemetery->id)
                ->where('column', $columnNumber)
                ->delete();

            // Shift các cột sau: column = column - 1
            CemeteryPlot::where('cemetery_id', $this->cemetery->id)
                ->where('column', '>', $columnNumber)
                ->decrement('column');

            // Cập nhật lại plot_code cho tất cả lô bị ảnh hưởng
            $this->updatePlotCodesAfterShift();
        });

        $this->loadPlots();

        Notification::make()
            ->title("Đã xóa cột {$columnNumber}")
            ->success()
            ->send();
    }

    protected function canDeleteRow(int $rowNumber): bool
    {
        return !CemeteryPlot::where('cemetery_id', $this->cemetery->id)
            ->where('row', $rowNumber)
            ->whereHas('grave')
            ->exists();
    }

    protected function canDeleteColumn(int $columnNumber): bool
    {
        return !CemeteryPlot::where('cemetery_id', $this->cemetery->id)
            ->where('column', $columnNumber)
            ->whereHas('grave')
            ->exists();
    }

    protected function updatePlotCodesAfterShift(): void
    {
        // Lấy tất cả lô và cập nhật lại plot_code
        // Cần cập nhật theo batch để tránh xung đột unique constraint
        $plots = CemeteryPlot::where('cemetery_id', $this->cemetery->id)->get();

        // Bước 1: Đổi tất cả plot_code thành giá trị tạm để tránh xung đột
        foreach ($plots as $plot) {
            $newPlotCode = CemeteryPlot::generatePlotCode($plot->row, $plot->column);
            if ($plot->plot_code !== $newPlotCode) {
                $tempCode = 'temp_' . $plot->id . '_' . time();
                $plot->update(['plot_code' => $tempCode]);
            }
        }

        // Bước 2: Refresh để lấy giá trị mới
        $plots->each->refresh();

        // Bước 3: Cập nhật lại với plot_code đúng
        foreach ($plots as $plot) {
            $newPlotCode = CemeteryPlot::generatePlotCode($plot->row, $plot->column);
            if ($plot->plot_code !== $newPlotCode) {
                $plot->update(['plot_code' => $newPlotCode]);
            }
        }
    }

    public static function canAccess(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = auth()->user();

        if (!$user) {
            return false;
        }

        // Cho phép admin và cán bộ xã/phường truy cập
        return $user->isAdmin() || $user->isCommuneStaff();
    }

    public static function shouldRegisterNavigation(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = auth()->user();

        if (!$user) {
            return false;
        }

        // Chỉ hiển thị menu cho admin và cán bộ xã/phường
        return $user->isAdmin() || $user->isCommuneStaff();
    }
}
