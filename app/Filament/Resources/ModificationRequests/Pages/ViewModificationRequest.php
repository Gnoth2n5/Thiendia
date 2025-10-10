<?php

namespace App\Filament\Resources\ModificationRequests\Pages;

use App\Filament\Resources\ModificationRequests\ModificationRequestResource;
use Filament\Actions;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewModificationRequest extends ViewRecord
{
    protected static string $resource = ModificationRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('approve')
                ->label('Phê duyệt')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn () => $this->record->status === 'pending')
                ->form([
                    Textarea::make('admin_notes')
                        ->label('Ghi chú (không bắt buộc)')
                        ->placeholder('Nhập ghi chú nếu cần...')
                        ->rows(2),
                ])
                ->action(function (array $data): void {
                    $record = $this->record;

                    // Cập nhật thông tin lăng mộ
                    $grave = $record->grave;
                    $requestedData = $record->requested_data;

                    if ($grave && ! empty($requestedData)) {
                        $updateData = [];

                        foreach ($requestedData as $key => $value) {
                            if (! empty($value)) {
                                $updateData[$key] = $value;
                            }
                        }

                        if (! empty($updateData)) {
                            $grave->update($updateData);
                        }
                    }

                    // Cập nhật trạng thái yêu cầu
                    $record->update([
                        'status' => 'approved',
                        'admin_notes' => $data['admin_notes'] ?? null,
                        'processed_by' => auth()->id(),
                        'processed_at' => now(),
                    ]);

                    Notification::make()
                        ->title('✅ Đã phê duyệt và cập nhật thông tin')
                        ->body('Thông tin lăng mộ đã được cập nhật thành công')
                        ->success()
                        ->send();

                    $this->redirect($this->getResource()::getUrl('index'));
                })
                ->requiresConfirmation()
                ->modalHeading('⚠️ Xác nhận phê duyệt')
                ->modalDescription('Thông tin lăng mộ sẽ được cập nhật NGAY LẬP TỨC. Bạn có chắc chắn muốn phê duyệt?')
                ->modalSubmitActionLabel('Phê duyệt')
                ->modalCancelActionLabel('Hủy'),

            Actions\Action::make('reject')
                ->label('Từ chối')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn () => $this->record->status === 'pending')
                ->form([
                    Textarea::make('admin_notes')
                        ->label('Lý do từ chối')
                        ->required()
                        ->placeholder('Nhập lý do từ chối yêu cầu này...')
                        ->rows(3),
                ])
                ->action(function (array $data): void {
                    $this->record->update([
                        'status' => 'rejected',
                        'admin_notes' => $data['admin_notes'],
                        'processed_by' => auth()->id(),
                        'processed_at' => now(),
                    ]);

                    Notification::make()
                        ->title('❌ Đã từ chối yêu cầu')
                        ->body('Yêu cầu đã bị từ chối')
                        ->warning()
                        ->send();

                    $this->redirect($this->getResource()::getUrl('index'));
                })
                ->requiresConfirmation()
                ->modalHeading('Xác nhận từ chối')
                ->modalDescription('Bạn có chắc chắn muốn từ chối yêu cầu này?')
                ->modalSubmitActionLabel('Từ chối')
                ->modalCancelActionLabel('Hủy'),
        ];
    }
}
