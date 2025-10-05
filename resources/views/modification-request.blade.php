@extends('layouts.app')

@section('title', 'Yêu cầu sửa đổi thông tin - Quản lý Nghĩa Địa')

@section('content')
<!-- Breadcrumb -->
<div class="text-sm breadcrumbs mb-6">
    <ul>
        <li>
            <a href="{{ route('home') }}" class="text-primary hover:underline">Trang chủ</a>
        </li>
        <li>
            <a href="{{ route('grave.show', $grave->id) }}" class="text-primary hover:underline">{{ $grave->grave_number }}</a>
        </li>
        <li class="text-base-content/60">Yêu cầu sửa đổi</li>
    </ul>
</div>

<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center gap-3 mb-4">
        <div class="p-3 bg-accent/10 rounded-xl">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-8 w-8 text-accent">
                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
            </svg>
        </div>
        <div>
            <h1 class="text-3xl font-bold text-neutral">Yêu cầu sửa đổi thông tin</h1>
            <p class="text-base-content/60">Lăng mộ {{ $grave->grave_number }} - {{ $grave->cemetery->name }}</p>
        </div>
    </div>

    <!-- Info Alert -->
    <div class="alert bg-info/10 border border-info/20 mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6 text-info shrink-0">
            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
        </svg>
        <div class="text-sm">
            <p class="font-medium mb-1">Vui lòng cung cấp đầy đủ thông tin</p>
            <p class="text-base-content/70">Đơn yêu cầu của bạn sẽ được xem xét và xử lý trong vòng 3-5 ngày làm việc. Chúng tôi sẽ liên hệ với bạn qua thông tin đã cung cấp.</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Form -->
    <div class="lg:col-span-2">
        <form action="{{ route('modification-request.store') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="grave_id" value="{{ $grave->id }}">

            <!-- Current Information -->
            <div class="card bg-base-100 shadow-lg border border-base-300">
                <div class="card-body">
                    <h2 class="card-title text-xl mb-4">Thông tin hiện tại</h2>
                    
                    <div class="bg-base-200 rounded-lg p-4 space-y-3">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-base-content/60 mb-1">Số lăng mộ</p>
                                <p class="font-medium">{{ $grave->grave_number }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-base-content/60 mb-1">Chủ lăng mộ</p>
                                <p class="font-medium">{{ $grave->owner_name }}</p>
                            </div>
                        </div>
                        @if($grave->deceased_full_name)
                            <div>
                                <p class="text-xs text-base-content/60 mb-1">Người đã khuất</p>
                                <p class="font-medium">{{ $grave->deceased_full_name }}</p>
                                @if($grave->deceased_birth_date && $grave->deceased_death_date)
                                    <p class="text-xs text-base-content/60">
                                        {{ $grave->deceased_birth_date->format('d/m/Y') }} - {{ $grave->deceased_death_date->format('d/m/Y') }}
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Requester Information -->
            <div class="card bg-base-100 shadow-lg border border-base-300">
                <div class="card-body">
                    <h2 class="card-title text-xl mb-4">Thông tin người yêu cầu</h2>
                    
                    <div class="space-y-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Họ và tên <span class="text-error">*</span></span>
                            </label>
                            <input type="text" name="requester_name" class="input input-bordered @error('requester_name') input-error @enderror" placeholder="Nhập họ tên đầy đủ" value="{{ old('requester_name') }}" required>
                            @error('requester_name')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Số điện thoại <span class="text-error">*</span></span>
                                </label>
                                <input type="tel" name="requester_phone" class="input input-bordered @error('requester_phone') input-error @enderror" placeholder="Ví dụ: 0912345678" value="{{ old('requester_phone') }}" required>
                                @error('requester_phone')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Email</span>
                                </label>
                                <input type="email" name="requester_email" class="input input-bordered @error('requester_email') input-error @enderror" placeholder="email@example.com" value="{{ old('requester_email') }}">
                                @error('requester_email')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Mối quan hệ với người đã khuất</span>
                            </label>
                            <select name="requester_relationship" class="select select-bordered @error('requester_relationship') select-error @enderror">
                                <option value="">-- Chọn mối quan hệ --</option>
                                <option value="con" {{ old('requester_relationship') === 'con' ? 'selected' : '' }}>Con</option>
                                <option value="cháu" {{ old('requester_relationship') === 'cháu' ? 'selected' : '' }}>Cháu</option>
                                <option value="vợ/chồng" {{ old('requester_relationship') === 'vợ/chồng' ? 'selected' : '' }}>Vợ/Chồng</option>
                                <option value="anh/chị/em" {{ old('requester_relationship') === 'anh/chị/em' ? 'selected' : '' }}>Anh/Chị/Em</option>
                                <option value="họ hàng" {{ old('requester_relationship') === 'họ hàng' ? 'selected' : '' }}>Họ hàng</option>
                                <option value="bạn bè" {{ old('requester_relationship') === 'bạn bè' ? 'selected' : '' }}>Bạn bè</option>
                                <option value="khác" {{ old('requester_relationship') === 'khác' ? 'selected' : '' }}>Khác</option>
                            </select>
                            @error('requester_relationship')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Request Details -->
            <div class="card bg-base-100 shadow-lg border border-base-300">
                <div class="card-body">
                    <h2 class="card-title text-xl mb-4">Chi tiết yêu cầu</h2>
                    
                    <div class="space-y-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Loại yêu cầu <span class="text-error">*</span></span>
                            </label>
                            <select name="request_type" class="select select-bordered @error('request_type') select-error @enderror" required>
                                <option value="">-- Chọn loại yêu cầu --</option>
                                <option value="sửa_thông_tin" {{ old('request_type') === 'sửa_thông_tin' ? 'selected' : '' }}>Sửa thông tin</option>
                                <option value="thêm_người" {{ old('request_type') === 'thêm_người' ? 'selected' : '' }}>Thêm người</option>
                                <option value="xóa_người" {{ old('request_type') === 'xóa_người' ? 'selected' : '' }}>Xóa người</option>
                                <option value="sửa_vị_trí" {{ old('request_type') === 'sửa_vị_trí' ? 'selected' : '' }}>Sửa vị trí</option>
                                <option value="khác" {{ old('request_type') === 'khác' ? 'selected' : '' }}>Khác</option>
                            </select>
                            @error('request_type')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Thông tin cần sửa đổi <span class="text-error">*</span></span>
                                <span class="label-text-alt text-base-content/60">Nhập theo định dạng: tên_trường: giá trị mới</span>
                            </label>
                            <textarea name="requested_data_text" rows="4" class="textarea textarea-bordered @error('requested_data') textarea-error @enderror" placeholder="Ví dụ:&#10;tên: Nguyễn Văn A&#10;ngày_sinh: 15/03/1950&#10;ngày_mất: 20/10/2020" required>{{ old('requested_data_text') }}</textarea>
                            <label class="label">
                                <span class="label-text-alt text-base-content/60">Mỗi thông tin một dòng, định dạng: tên_trường: giá trị</span>
                            </label>
                            @error('requested_data')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Lý do yêu cầu <span class="text-error">*</span></span>
                            </label>
                            <textarea name="reason" rows="4" class="textarea textarea-bordered @error('reason') textarea-error @enderror" placeholder="Vui lòng mô tả chi tiết lý do bạn yêu cầu sửa đổi thông tin..." required>{{ old('reason') }}</textarea>
                            @error('reason')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-3 justify-end">
                <a href="{{ route('grave.show', $grave->id) }}" class="btn btn-ghost">
                    Hủy bỏ
                </a>
                <button type="submit" class="btn btn-primary gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                    </svg>
                    Gửi yêu cầu
                </button>
            </div>
        </form>
    </div>

    <!-- Sidebar Info -->
    <div class="space-y-6">
        <!-- Grave Quick Info -->
        <div class="card bg-base-100 shadow-lg border border-base-300">
            <div class="card-body">
                <h3 class="font-bold text-lg mb-3">Thông tin lăng mộ</h3>
                
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-base-content/60">Số lăng mộ</p>
                        <p class="font-bold text-lg">{{ $grave->grave_number }}</p>
                    </div>
                    
                    <div>
                        <p class="text-xs text-base-content/60">Nghĩa trang</p>
                        <p class="font-medium">{{ $grave->cemetery->name }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-base-content/60">Chủ lăng mộ</p>
                        <p class="font-medium">{{ $grave->owner_name }}</p>
                    </div>
                </div>

                <div class="divider my-2"></div>

                <a href="{{ route('grave.show', $grave->id) }}" class="btn btn-outline btn-sm w-full gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                    </svg>
                    Quay lại chi tiết
                </a>
            </div>
        </div>

        <!-- Guidelines -->
        <div class="card bg-warning/10 border border-warning/20">
            <div class="card-body">
                <div class="flex items-center gap-2 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-warning">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>
                    <h3 class="font-bold">Lưu ý quan trọng</h3>
                </div>
                
                <ul class="space-y-2 text-sm text-base-content/80">
                    <li class="flex gap-2">
                        <span class="text-warning">•</span>
                        <span>Vui lòng cung cấp thông tin chính xác và đầy đủ</span>
                    </li>
                    <li class="flex gap-2">
                        <span class="text-warning">•</span>
                        <span>Đơn yêu cầu sẽ được xem xét trong 3-5 ngày làm việc</span>
                    </li>
                    <li class="flex gap-2">
                        <span class="text-warning">•</span>
                        <span>Chúng tôi có thể liên hệ để xác minh thông tin</span>
                    </li>
                    <li class="flex gap-2">
                        <span class="text-warning">•</span>
                        <span>Giữ điện thoại thông suốt để nhận phản hồi</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Help -->
        <div class="card bg-info/10 border border-info/20">
            <div class="card-body">
                <div class="flex items-center gap-2 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-info">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                    </svg>
                    <h3 class="font-bold">Cần hỗ trợ?</h3>
                </div>
                
                <p class="text-sm text-base-content/70 mb-3">
                    Nếu bạn gặp khó khăn khi điền form, vui lòng liên hệ:
                </p>
                
                <div class="space-y-2 text-sm">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4 text-info">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                        </svg>
                        <span class="font-medium">1900-xxxx</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4 text-info">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>
                        <span class="font-medium">support@example.com</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

