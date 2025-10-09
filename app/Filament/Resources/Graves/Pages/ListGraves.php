<?php

namespace App\Filament\Resources\Graves\Pages;

use App\Exports\GravesTemplateExport;
use App\Filament\Resources\Graves\GraveResource;
use App\Imports\GravesImport;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ListGraves extends ListRecords
{
    protected static string $resource = GraveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('downloadTemplate')
                ->label('Tải file mẫu')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('info')
                ->action(function (): BinaryFileResponse {
                    return Excel::download(new GravesTemplateExport, 'mau_import_lang_mo.xlsx');
                }),

            Action::make('importExcel')
                ->label('Import từ Excel')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('success')
                ->form([
                    FileUpload::make('file')
                        ->label('File Excel')
                        ->acceptedFileTypes([
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'text/csv',
                        ])
                        ->required()
                        ->helperText('Tải lên file Excel (.xlsx, .xls) hoặc CSV chứa dữ liệu lăng mộ'),
                ])
                ->action(function (array $data): void {
                    try {
                        $file = storage_path('app/public/' . $data['file']);

                        $import = new GravesImport;
                        Excel::import($import, $file);

                        $failures = $import->failures();
                        $errors = $import->errors();

                        if ($failures->count() > 0 || $errors->count() > 0) {
                            $errorMessages = [];

                            foreach ($failures as $failure) {
                                $errorMessages[] = "Dòng {$failure->row()}: " . implode(', ', $failure->errors());
                            }

                            foreach ($errors as $error) {
                                $errorMessages[] = $error->getMessage();
                            }

                            Notification::make()
                                ->title('Import hoàn tất với một số lỗi')
                                ->warning()
                                ->body(implode("\n", array_slice($errorMessages, 0, 5)))
                                ->persistent()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Import thành công')
                                ->success()
                                ->body('Dữ liệu đã được import thành công từ file Excel.')
                                ->send();
                        }

                        // Clean up uploaded file
                        if (file_exists($file)) {
                            unlink($file);
                        }
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Import thất bại')
                            ->danger()
                            ->body('Có lỗi xảy ra: ' . $e->getMessage())
                            ->persistent()
                            ->send();
                    }
                }),

            CreateAction::make(),
        ];
    }
}
