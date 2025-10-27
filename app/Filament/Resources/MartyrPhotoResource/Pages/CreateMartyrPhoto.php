<?php

namespace App\Filament\Resources\MartyrPhotoResource\Pages;

use App\Filament\Resources\MartyrPhotoResource;
use App\Models\MartyrPhoto;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateMartyrPhoto extends CreateRecord
{
    protected static string $resource = MartyrPhotoResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Thêm uploaded_by
        $data['uploaded_by'] = auth()->id();

        // Lấy photos từ form state
        $photos = $data['photos'] ?? [];

        // Nếu có nhiều ảnh, lưu vào property để xử lý sau
        if (is_array($photos) && count($photos) > 0) {
            $this->photosToCreate = $photos;
            // Set photo_path cho record đầu tiên
            $data['photo_path'] = $photos[0];
        }

        unset($data['photos']);

        return $data;
    }

    protected ?array $photosToCreate = null;

    protected function afterCreate(): void
    {
        // Tạo records cho các ảnh còn lại (từ ảnh thứ 2 trở đi)
        if ($this->photosToCreate && count($this->photosToCreate) > 1) {
            $cemeteryId = $this->record->cemetery_id;
            $uploadedBy = $this->record->uploaded_by;

            for ($i = 1; $i < count($this->photosToCreate); $i++) {
                MartyrPhoto::create([
                    'cemetery_id' => $cemeteryId,
                    'photo_path' => $this->photosToCreate[$i],
                    'uploaded_by' => $uploadedBy,
                ]);
            }

            $totalPhotos = count($this->photosToCreate);

            // Gửi notification với số lượng ảnh
            Notification::make()
                ->title("Đã upload thành công {$totalPhotos} ảnh")
                ->success()
                ->send();
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        // Nếu chỉ 1 ảnh, return message mặc định
        if (! $this->photosToCreate || count($this->photosToCreate) <= 1) {
            return 'Đã tạo ảnh';
        }

        // Notification cho nhiều ảnh sẽ được gửi trong afterCreate()
        return null;
    }
}
