<?php

namespace App\Filament\Pages;

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

class ManageCemeteryGrid extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static string $view = 'filament.pages.manage-cemetery-grid';

    protected static ?string $navigationLabel = 'Quản lý lưới lô';

    protected static ?string $title = 'Quản lý lưới lô nghĩa trang';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationGroup = 'Quản lý nghĩa trang';

    public ?array $data = [];

    public Cemetery $cemetery;

    public ?array $plots = null;

    public ?array $gridDimensions = null;

    public function mount(): void
    {
        // Get the first cemetery by default
        $this->cemetery = Cemetery::first();

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
                        ->options(Cemetery::pluck('name', 'id'))
                        ->required()
                        ->searchable()
                        ->default($this->cemetery->id),
                ])
                ->action(function (array $data): void {
                    $this->cemetery = Cemetery::findOrFail($data['cemetery_id']);
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

    public function togglePlotStatus(int $plotId, string $newStatus): void
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

    public static function canAccess(): bool
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        return $user->isAdmin();
    }
}
