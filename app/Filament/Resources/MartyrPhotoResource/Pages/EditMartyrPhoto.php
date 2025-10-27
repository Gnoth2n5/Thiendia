<?php

namespace App\Filament\Resources\MartyrPhotoResource\Pages;

use App\Filament\Resources\MartyrPhotoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMartyrPhoto extends EditRecord
{
    protected static string $resource = MartyrPhotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load ảnh hiện tại vào form field photo_single
        $data['photo_single'] = $data['photo_path'] ?? null;

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Nếu có ảnh mới được upload thông qua photo_single, cập nhật photo_path
        if (isset($data['photo_single']) && $data['photo_single']) {
            $data['photo_path'] = $data['photo_single'];
        }

        // Xóa field photo_single khỏi data để không lưu vào DB
        unset($data['photo_single']);

        return $data;
    }
}
