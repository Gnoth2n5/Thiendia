@php
    $record = $getRecord();
    $currentData = $record->current_data ?? [];
    $requestedData = $record->requested_data ?? [];
    
    // Định nghĩa label tiếng Việt cho các trường
    $fieldLabels = [
        'owner_name' => 'Tên chủ lăng mộ',
        'deceased_full_name' => 'Họ tên người đã khuất',
        'deceased_birth_date' => 'Ngày sinh',
        'deceased_death_date' => 'Ngày mất',
        'deceased_gender' => 'Giới tính',
        'deceased_relationship' => 'Quan hệ với chủ lăng mộ',
        'deceased_photo' => 'Ảnh người đã khuất',
        'location_description' => 'Vị trí lăng mộ',
        'notes' => 'Ghi chú',
    ];
@endphp

@if($requestedData && count($requestedData) > 0)
    <div class="space-y-4">
        @foreach($requestedData as $key => $newValue)
            <div class="border-2 border-gray-200 dark:border-gray-700 rounded-xl p-4 bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900">
                <h4 class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-blue-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    {{ $fieldLabels[$key] ?? ucfirst(str_replace('_', ' ', $key)) }}
                </h4>
                
                <div class="grid grid-cols-2 gap-4">
                    <!-- Giá trị cũ -->
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-red-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                            <p class="text-xs font-semibold text-red-600 dark:text-red-400 uppercase">
                                Hiện tại
                            </p>
                        </div>
                        <div class="bg-red-50 dark:bg-red-900/20 border-2 border-red-200 dark:border-red-800 rounded-lg p-3 min-h-[60px] flex items-center">
                            @if($key === 'deceased_photo' && isset($currentData[$key]) && $currentData[$key])
                                <img src="{{ Storage::url($currentData[$key]) }}" alt="Ảnh cũ" class="w-20 h-24 object-cover rounded-lg shadow-md">
                            @else
                                <p class="text-sm text-gray-700 dark:text-gray-300">
                                    {{ $currentData[$key] ?? 'Chưa có dữ liệu' }}
                                </p>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Giá trị mới -->
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-green-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            <p class="text-xs font-semibold text-green-600 dark:text-green-400 uppercase">
                                Yêu cầu thay đổi
                            </p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900/20 border-2 border-green-200 dark:border-green-800 rounded-lg p-3 min-h-[60px] flex items-center">
                            @if($key === 'deceased_photo')
                                <img src="{{ Storage::url($newValue) }}" alt="Ảnh mới" class="w-20 h-24 object-cover rounded-lg shadow-md">
                            @else
                                <p class="text-sm font-bold text-gray-900 dark:text-gray-100">
                                    {{ $newValue }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
        <div class="flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
            </svg>
            <div class="text-sm text-blue-800 dark:text-blue-200">
                <p class="font-semibold mb-1">💡 Hướng dẫn xử lý:</p>
                <p>Nhấn nút <strong>"Phê duyệt"</strong> ở trên để chấp nhận và tự động cập nhật thông tin lăng mộ ngay lập tức.</p>
            </div>
        </div>
    </div>
@else
    <div class="text-center py-12 text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-700">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mx-auto mb-3 text-gray-400">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
        </svg>
        <p class="font-medium">Chưa có thông tin cần sửa đổi</p>
    </div>
@endif
