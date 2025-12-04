<x-filament-panels::page>
    @if ($step === 'upload')
        {{-- Step 1: Upload Form --}}
        <x-filament-panels::form wire:submit="preview">
            {{ $this->form }}

            <x-filament-panels::form.actions
                :actions="[
                    \Filament\Actions\Action::make('preview')
                        ->label('Xem trước')
                        ->icon('heroicon-o-eye')
                        ->color('primary')
                        ->submit('preview'),
                ]"
            />
        </x-filament-panels::form>
    @else
        {{-- Step 2: Preview Table --}}
        <div class="space-y-4 filament-body" >
            {{-- Summary --}}
            <div class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Kết quả xem trước
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Tổng: <span class="font-semibold">{{ count($previewData) }}</span> dòng
                            @if ($errorCount > 0)
                                | <span style="color: rgb(255, 35, 35); font-weight: bold;" class="text-red-600 font-semibold">{{ $errorCount }}</span> lỗi
                            @endif
                            @if ($successCount > 0)
                                | <span style="color: rgb(28, 188, 28); font-weight: bold;" class="text-green-600 font-semibold">{{ $successCount }}</span> hợp lệ
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            {{-- Preview Table --}}
            <div class="overflow-x-auto rounded-lg border border-gray-300 dark:border-gray-600">
                <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-600">
                    <thead class="bg-gray-50 dark:bg-gray-800 sticky top-0">
                        <tr>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                STT
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                Họ và tên
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                Nguyên Quán
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                Ngày sinh
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                Ngày nhập ngũ
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                Ngày hy sinh
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                Cấp bậc
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                Chức vụ
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                Đơn vị
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                Ghi chú
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                Lô
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                Ảnh liệt sỹ
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                Ảnh mộ
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                Trạng thái
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($previewData as $row)
                            <tr class="{{ $row['is_valid'] ? 'bg-green-50 dark:bg-green-900/10' : 'bg-red-50 dark:bg-red-900/10' }}">
                                <td class="px-3 py-3 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $row['row_number'] }}
                                </td>
                                <td class="px-3 py-3 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $row['data'][0] ?? '' }}
                                </td>
                                <td class="px-3 py-3 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $row['data'][1] ?? '' }}
                                </td>
                                <td class="px-3 py-3 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $row['data'][2] ?? '' }}
                                </td>
                                <td class="px-3 py-3 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $row['data'][3] ?? '' }}
                                </td>
                                <td class="px-3 py-3 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $row['data'][4] ?? '' }}
                                </td>
                                <td class="px-3 py-3 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $row['data'][5] ?? '' }}
                                </td>
                                <td class="px-3 py-3 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $row['data'][6] ?? '' }}
                                </td>
                                <td class="px-3 py-3 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $row['data'][7] ?? '' }}
                                </td>
                                <td class="px-3 py-3 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $row['data'][8] ?? '' }}
                                </td>
                                <td class="px-3 py-3 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $row['data'][9] ?? '' }}
                                </td>
                                <td class="px-3 py-3 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $row['data'][10] ?? '' }}
                                </td>
                                <td class="px-3 py-3 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $row['data'][11] ?? '' }}
                                </td>
                                <td class="px-3 py-3 text-sm">
                                    @if ($row['is_valid'])
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100" style="color: rgb(28, 188, 28); font-weight: bold;">
                                            ✓ OK
                                        </span>
                                    @else
                                        <div class="space-y-1">
                                            @foreach ($row['errors'] as $error)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100" style="color: rgb(255, 35, 35); font-weight: bold;">
                                                    {{ $error }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-3 justify-end">
                <x-filament::button
                    color="gray"
                    wire:click="back"
                >
                    Quay lại
                </x-filament::button>

                <x-filament::button
                    color="success"
                    wire:click="save"
                    :disabled="$hasErrors"
                >
                    Lưu
                </x-filament::button>
            </div>
        </div>
    @endif
</x-filament-panels::page>

