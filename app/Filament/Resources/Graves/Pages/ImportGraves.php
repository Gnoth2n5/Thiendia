<?php

namespace App\Filament\Resources\Graves\Pages;

use App\Filament\Resources\Graves\GraveResource;
use App\Models\Cemetery;
use App\Services\GravesImportParser;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ImportGraves extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = GraveResource::class;

    protected static string $view = 'filament.resources.graves.pages.import-graves';

    protected static ?string $title = 'Import Liệt sỹ từ Excel';

    public ?array $data = [];

    public string $step = 'upload'; // 'upload' | 'preview'

    public array $previewData = [];

    public bool $hasErrors = false;

    public int $successCount = 0;

    public int $errorCount = 0;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('cemetery_id')
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
                    ->searchable()
                    ->required()
                    ->helperText('Chọn nghĩa trang để import liệt sỹ'),

                FileUpload::make('file')
                    ->label('File Excel')
                    ->acceptedFileTypes([
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    ])
                    ->required()
                    ->maxSize(10240) // 10MB
                    ->helperText('Tải lên file Excel (.xlsx, .xls) theo template mẫu'),
            ])
            ->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('downloadTemplate')
                ->label('Tải file mẫu')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('info')
                ->action(function () {
                    $filePath = public_path('template/TemplateLietSy.xlsx');

                    if (! file_exists($filePath)) {
                        Notification::make()
                            ->title('Lỗi')
                            ->danger()
                            ->body('Không tìm thấy file template.')
                            ->send();

                        return;
                    }

                    return response()->download($filePath, 'TemplateLietSy.xlsx');
                }),
        ];
    }

    public function preview(): void
    {
        $data = $this->form->getState();

        if (empty($data['cemetery_id']) || empty($data['file'])) {
            Notification::make()
                ->title('Lỗi')
                ->danger()
                ->body('Vui lòng chọn nghĩa trang và tải file Excel.')
                ->send();

            return;
        }

        // Kiểm tra quyền truy cập nghĩa trang
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $cemetery = Cemetery::find($data['cemetery_id']);

        if (! $cemetery) {
            Notification::make()
                ->title('Lỗi')
                ->danger()
                ->body('Không tìm thấy nghĩa trang.')
                ->send();

            return;
        }

        if ($user->isCommuneStaff() && $cemetery->commune !== $user->commune) {
            Notification::make()
                ->title('Không có quyền')
                ->danger()
                ->body('Bạn không có quyền import vào nghĩa trang này.')
                ->send();

            return;
        }

        try {
            // Get file path
            $file = $data['file'];
            if ($file instanceof TemporaryUploadedFile) {
                $filePath = $file->getRealPath();
            } else {
                $filePath = storage_path('app/public/'.$file);
            }

            // Parse và validate
            $parser = new GravesImportParser($filePath, $data['cemetery_id']);
            $this->previewData = $parser->parse();
            $this->hasErrors = $parser->hasErrors();
            $this->successCount = $parser->getSuccessCount();
            $this->errorCount = $parser->getErrorCount();

            // Chuyển sang step preview
            $this->step = 'preview';

            if ($this->hasErrors) {
                Notification::make()
                    ->title('Có lỗi trong dữ liệu')
                    ->warning()
                    ->body("Tìm thấy {$this->errorCount} dòng có lỗi. Vui lòng kiểm tra và sửa trước khi lưu.")
                    ->send();
            }
        } catch (\Exception $e) {
            Notification::make()
                ->title('Lỗi xử lý file')
                ->danger()
                ->body('Có lỗi xảy ra khi xử lý file: '.$e->getMessage())
                ->send();
        }
    }

    public function save(): void
    {
        if ($this->hasErrors) {
            Notification::make()
                ->title('Không thể lưu')
                ->danger()
                ->body('Vui lòng sửa tất cả các lỗi trước khi lưu.')
                ->send();

            return;
        }

        try {
            $data = $this->form->getState();

            // Kiểm tra quyền truy cập nghĩa trang lần nữa trước khi lưu
            /** @var \App\Models\User $user */
            $user = auth()->user();
            $cemetery = Cemetery::find($data['cemetery_id']);

            if (! $cemetery) {
                Notification::make()
                    ->title('Lỗi')
                    ->danger()
                    ->body('Không tìm thấy nghĩa trang.')
                    ->send();

                return;
            }

            if ($user->isCommuneStaff() && $cemetery->commune !== $user->commune) {
                Notification::make()
                    ->title('Không có quyền')
                    ->danger()
                    ->body('Bạn không có quyền import vào nghĩa trang này.')
                    ->send();

                return;
            }

            // Get file path
            $file = $data['file'];
            if ($file instanceof TemporaryUploadedFile) {
                $filePath = $file->getRealPath();
            } else {
                $filePath = storage_path('app/public/'.$file);
            }

            // Parse và save
            $parser = new GravesImportParser($filePath, $data['cemetery_id']);
            $parser->parse();
            $result = $parser->save();

            // Clean up uploaded file
            if (! ($file instanceof TemporaryUploadedFile) && file_exists($filePath)) {
                unlink($filePath);
            }

            Notification::make()
                ->title('Import thành công')
                ->success()
                ->body("Đã import thành công {$result['saved']} liệt sỹ.")
                ->send();

            // Reset form
            $this->reset(['data', 'step', 'previewData', 'hasErrors', 'successCount', 'errorCount']);
            $this->form->fill();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Import thất bại')
                ->danger()
                ->body('Có lỗi xảy ra: '.$e->getMessage())
                ->send();
        }
    }

    public function back(): void
    {
        $this->step = 'upload';
        $this->previewData = [];
        $this->hasErrors = false;
        $this->successCount = 0;
        $this->errorCount = 0;
    }

    public function getBreadcrumbs(): array
    {
        return [
            GraveResource::getUrl('index') => 'Liệt sỹ',
            '#' => 'Import từ Excel',
        ];
    }

    public static function canAccess(): bool
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // Cho phép admin và cán bộ xã/phường import liệt sỹ
        return $user->isAdmin() || $user->isCommuneStaff();
    }
}
