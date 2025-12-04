<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSetting extends EditRecord
{
    protected static string $resource = SettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Nếu là banner, parse JSON value thành array ảnh
        if (isset($data['key']) && $data['key'] === 'banner' && ! empty($data['value'])) {
            $images = json_decode($data['value'], true);
            $data['banner_images'] = is_array($images) ? $images : [];
        } else {
            // Nếu không phải banner, set value_text từ value
            $data['value_text'] = $data['value'] ?? '';
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Lấy record hiện tại để có thể giữ nguyên giá trị cũ nếu cần
        $record = $this->record;
        
        // Nếu là banner, lưu danh sách ảnh vào value dạng JSON
        if (isset($data['key']) && $data['key'] === 'banner') {
            // Lấy ảnh từ form data hoặc giữ nguyên giá trị cũ nếu không có thay đổi
            if (isset($data['banner_images'])) {
                $images = $data['banner_images'];
                // Đảm bảo images là array
                if (! is_array($images)) {
                    $images = [];
                }
                // Lọc bỏ các giá trị null hoặc empty và chỉ giữ lại đường dẫn file
                $images = array_filter($images, fn ($img) => ! empty($img) && is_string($img));
                // Đảm bảo các đường dẫn là relative paths (không có storage/app/public)
                $images = array_map(function ($img) {
                    // Nếu là full path, chỉ lấy phần sau storage/app/public
                    if (str_contains($img, 'storage/app/public/')) {
                        return str_replace('storage/app/public/', '', $img);
                    }

                    // Nếu đã là relative path, giữ nguyên
                    return $img;
                }, array_values($images));
                $data['value'] = json_encode($images);
            } else {
                // Nếu không có banner_images trong data, giữ nguyên value cũ từ record
                $data['value'] = $record->value ?? '[]';
            }
            unset($data['banner_images']); // Xóa field tạm để tránh lỗi
        } else {
            // Nếu không phải banner, lấy giá trị từ value_text hoặc value hoặc giá trị cũ
            $data['value'] = $data['value_text'] ?? $data['value'] ?? $record->value ?? '';
            unset($data['value_text']); // Xóa field tạm
        }

        return $data;
    }
}
