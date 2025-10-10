<?php

namespace App\Filament\Resources\ModificationRequests\Tables;

use App\Models\ModificationRequest;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ModificationRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('grave.grave_number')
                    ->label('Số lăng mộ')
                    ->sortable()
                    ->searchable()
                    ->weight('bold')
                    ->color('primary'),

                TextColumn::make('grave.cemetery.name')
                    ->label('Nghĩa trang')
                    ->sortable()
                    ->searchable()
                    ->limit(30)
                    ->wrap(),

                TextColumn::make('requester_name')
                    ->label('Người yêu cầu')
                    ->sortable()
                    ->searchable()
                    ->limit(25),

                TextColumn::make('requester_phone')
                    ->label('Số ĐT')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-phone'),

                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Chờ xử lý',
                        'approved' => 'Đã duyệt',
                        'rejected' => 'Từ chối',
                        default => $state,
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('Ngày gửi')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->since(),

                TextColumn::make('processed_at')
                    ->label('Ngày xử lý')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'pending' => 'Chờ xử lý',
                        'approved' => 'Đã duyệt',
                        'rejected' => 'Từ chối',
                    ])
                    ->default('pending'),
            ])
            ->actions([
                ViewAction::make()
                    ->label('Xem'),

                Action::make('approve')
                    ->label('Phê duyệt')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (ModificationRequest $record): bool => $record->status === 'pending')
                    ->form([
                        Textarea::make('admin_notes')
                            ->label('Ghi chú (không bắt buộc)')
                            ->placeholder('Nhập ghi chú nếu cần...')
                            ->rows(2),
                    ])
                    ->action(function (ModificationRequest $record, array $data): void {
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
                    })
                    ->requiresConfirmation()
                    ->modalHeading('⚠️ Xác nhận phê duyệt')
                    ->modalDescription('Thông tin lăng mộ sẽ được cập nhật NGAY LẬP TỨC. Bạn có chắc chắn muốn phê duyệt?')
                    ->modalSubmitActionLabel('Phê duyệt')
                    ->modalCancelActionLabel('Hủy'),

                Action::make('reject')
                    ->label('Từ chối')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (ModificationRequest $record): bool => $record->status === 'pending')
                    ->form([
                        Textarea::make('admin_notes')
                            ->label('Lý do từ chối')
                            ->required()
                            ->placeholder('Nhập lý do từ chối yêu cầu này...')
                            ->rows(3),
                    ])
                    ->action(function (ModificationRequest $record, array $data): void {
                        $record->update([
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
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Xác nhận từ chối')
                    ->modalDescription('Bạn có chắc chắn muốn từ chối yêu cầu này?')
                    ->modalSubmitActionLabel('Từ chối')
                    ->modalCancelActionLabel('Hủy'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
