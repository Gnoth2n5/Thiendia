@extends('layouts.app')

@section('title', 'Yêu cầu sửa đổi thông tin - Quản lý Nghĩa Địa')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Breadcrumb -->
    <div class="text-sm breadcrumbs mb-6">
        <ul>
            <li>
                <a href="{{ route('home') }}" class="text-primary hover:underline flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Trang chủ
                </a>
            </li>
            <li>
                <a href="{{ route('grave.show', $grave->id) }}" class="text-primary hover:underline">{{ $grave->grave_number }}</a>
            </li>
            <li class="text-base-content/60">Yêu cầu sửa đổi</li>
        </ul>
    </div>

    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center gap-4 mb-6">
            <div class="flex items-center gap-4">
                <div class="p-4 bg-gradient-to-br from-accent to-warning rounded-2xl shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-10 w-10 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-neutral mb-1">Yêu cầu sửa đổi thông tin</h1>
                    <p class="text-base-content/60 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                        Lăng mộ <span class="font-semibold">{{ $grave->grave_number }}</span> - {{ $grave->cemetery->name }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Info Alert -->
        <div class="alert bg-gradient-to-r from-info/10 to-info/5 border border-info/30 shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6 text-info shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
            </svg>
            <div class="text-sm">
                <p class="font-semibold mb-1 text-base">📋 Vui lòng cung cấp đầy đủ thông tin</p>
                <p class="text-base-content/70">Đơn yêu cầu của bạn sẽ được xem xét và xử lý trong vòng <strong>3-5 ngày làm việc</strong>. Chúng tôi sẽ liên hệ với bạn qua thông tin đã cung cấp.</p>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form -->
        <div class="lg:col-span-2 space-y-6">
            <form action="{{ route('modification-request.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <input type="hidden" name="grave_id" value="{{ $grave->id }}">

                <!-- Current Information -->
                <div class="card bg-base-100 shadow-xl border border-base-300 hover:shadow-2xl transition-shadow">
                    <div class="card-body">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-primary/10 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6 text-primary">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-neutral">Thông tin hiện tại</h2>
                        </div>
                        
                        <div class="bg-gradient-to-br from-base-200 to-base-300/50 rounded-xl p-6 space-y-4 border border-base-300">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-1">
                                    <p class="text-xs font-medium text-base-content/50 uppercase tracking-wider">Số lăng mộ</p>
                                    <p class="text-lg font-bold text-primary">{{ $grave->grave_number }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-xs font-medium text-base-content/50 uppercase tracking-wider">Chủ lăng mộ</p>
                                    <p class="text-lg font-semibold text-neutral">{{ $grave->owner_name }}</p>
                                </div>
                            </div>
                            @if($grave->deceased_full_name)
                                <div class="divider my-2"></div>
                                <div class="space-y-2">
                                    <p class="text-xs font-medium text-base-content/50 uppercase tracking-wider">Người đã khuất</p>
                                    <p class="text-lg font-semibold text-neutral">{{ $grave->deceased_full_name }}</p>
                                    @if($grave->deceased_birth_date && $grave->deceased_death_date)
                                        <p class="text-sm text-base-content/60 flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                            </svg>
                                            {{ $grave->deceased_birth_date->format('d/m/Y') }} - {{ $grave->deceased_death_date->format('d/m/Y') }}
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Requester Information -->
                <div class="card bg-base-100 shadow-xl border border-base-300 hover:shadow-2xl transition-shadow">
                    <div class="card-body">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-accent/10 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6 text-accent">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-neutral">Thông tin người yêu cầu</h2>
                        </div>
                        
                        <div class="space-y-6">
                            <div class="form-control w-full">
                                <label class="block mb-2">
                                    <span class="text-sm font-semibold text-neutral">Họ và tên <span class="text-error">*</span></span>
                                </label>
                                <input type="text" name="requester_name" class="input input-bordered w-full @error('requester_name') input-error @enderror" placeholder="Nhập họ tên đầy đủ" value="{{ old('requester_name') }}" required>
                                @error('requester_name')
                                    <div class="mt-1">
                                        <span class="text-xs text-error">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="form-control w-full">
                                    <label class="block mb-2">
                                        <span class="text-sm font-semibold text-neutral">Số điện thoại <span class="text-error">*</span></span>
                                    </label>
                                    <input type="tel" name="requester_phone" class="input input-bordered w-full @error('requester_phone') input-error @enderror" placeholder="Ví dụ: 0912345678" value="{{ old('requester_phone') }}" required>
                                    @error('requester_phone')
                                        <div class="mt-1">
                                            <span class="text-xs text-error">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-control w-full">
                                    <label class="block mb-2">
                                        <span class="text-sm font-semibold text-neutral">Email</span>
                                    </label>
                                    <input type="email" name="requester_email" class="input input-bordered w-full @error('requester_email') input-error @enderror" placeholder="email@example.com" value="{{ old('requester_email') }}">
                                    @error('requester_email')
                                        <div class="mt-1">
                                            <span class="text-xs text-error">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-control w-full">
                                <label class="block mb-2">
                                    <span class="text-sm font-semibold text-neutral">Mối quan hệ với người đã khuất</span>
                                </label>
                                <select name="requester_relationship" class="select select-bordered w-full @error('requester_relationship') select-error @enderror">
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
                                    <div class="mt-1">
                                        <span class="text-xs text-error">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                </div>
            </div>

                <!-- Request Details -->
                <div class="card bg-gradient-to-br from-white via-slate-50/50 to-green-50/30 shadow-xl border border-green-200/50">
                    <div class="card-body">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-green-500/10 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6 text-green-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-slate-800">Thông tin cần sửa đổi</h2>
                        </div>
                        
                        <div class="alert bg-blue-50 border-blue-200 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-blue-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                            </svg>
                            <span class="text-sm text-slate-700">Chỉ điền vào các trường bạn muốn sửa đổi. Để trống nếu không thay đổi.</span>
                        </div>
                        
                        <div class="space-y-6">
                            <!-- Thông tin chủ lăng mộ -->
                            <div class="bg-white rounded-xl p-4 border border-slate-200">
                                <h3 class="font-bold text-lg mb-4 text-slate-700">Thông tin chủ lăng mộ</h3>
                                <div class="space-y-4">
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text font-medium">Tên chủ lăng mộ mới</span>
                                        </label>
                                        <input type="text" name="new_owner_name" class="input input-bordered w-full" placeholder="Nhập tên mới nếu muốn thay đổi" value="{{ old('new_owner_name') }}">
                                        <label class="label">
                                            <span class="label-text-alt text-slate-500">Hiện tại: {{ $grave->owner_name }}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Thông tin người đã khuất -->
                            <div class="bg-white rounded-xl p-4 border border-slate-200">
                                <h3 class="font-bold text-lg mb-4 text-slate-700">Thông tin người đã khuất</h3>
                                <div class="space-y-4">
                                    <!-- Ảnh người đã khuất -->
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text font-medium">Ảnh người đã khuất</span>
                                        </label>
                                        @if($grave->deceased_photo)
                                            <div class="mb-3">
                                                <p class="text-xs text-slate-500 mb-2">Ảnh hiện tại:</p>
                                                <div class="w-32 h-40 rounded-lg overflow-hidden shadow-md border-2 border-slate-200">
                                                    <img src="{{ Storage::url($grave->deceased_photo) }}" alt="Ảnh hiện tại" class="w-full h-full object-cover">
                                                </div>
                                            </div>
                                        @endif
                                        <input type="file" name="new_deceased_photo" class="file-input file-input-bordered w-full" accept="image/*">
                                        <label class="label">
                                            <span class="label-text-alt text-slate-500">Chọn ảnh mới nếu muốn thay đổi (JPG, PNG, tối đa 2MB)</span>
                                        </label>
                                    </div>

                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text font-medium">Họ và tên</span>
                                        </label>
                                        <input type="text" name="new_deceased_full_name" class="input input-bordered w-full" placeholder="Nhập họ tên mới" value="{{ old('new_deceased_full_name') }}">
                                        <label class="label">
                                            <span class="label-text-alt text-slate-500">Hiện tại: {{ $grave->deceased_full_name ?? 'Chưa có' }}</span>
                                        </label>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="form-control">
                                            <label class="label">
                                                <span class="label-text font-medium">Ngày sinh</span>
                                            </label>
                                            <input type="date" name="new_deceased_birth_date" class="input input-bordered w-full" value="{{ old('new_deceased_birth_date') }}">
                                            <label class="label">
                                                <span class="label-text-alt text-slate-500">Hiện tại: {{ $grave->deceased_birth_date?->format('d/m/Y') ?? 'Chưa có' }}</span>
                                            </label>
                                        </div>

                                        <div class="form-control">
                                            <label class="label">
                                                <span class="label-text font-medium">Ngày mất</span>
                                            </label>
                                            <input type="date" name="new_deceased_death_date" class="input input-bordered w-full" value="{{ old('new_deceased_death_date') }}">
                                            <label class="label">
                                                <span class="label-text-alt text-slate-500">Hiện tại: {{ $grave->deceased_death_date?->format('d/m/Y') ?? 'Chưa có' }}</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text font-medium">Giới tính</span>
                                        </label>
                                        <select name="new_deceased_gender" class="select select-bordered w-full">
                                            <option value="">-- Không thay đổi --</option>
                                            <option value="nam" {{ old('new_deceased_gender') === 'nam' ? 'selected' : '' }}>Nam</option>
                                            <option value="nữ" {{ old('new_deceased_gender') === 'nữ' ? 'selected' : '' }}>Nữ</option>
                                        </select>
                                        <label class="label">
                                            <span class="label-text-alt text-slate-500">Hiện tại: {{ ucfirst($grave->deceased_gender ?? 'Chưa có') }}</span>
                                        </label>
                                    </div>

                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text font-medium">Quan hệ với chủ lăng mộ</span>
                                        </label>
                                        <input type="text" name="new_deceased_relationship" class="input input-bordered w-full" placeholder="Ví dụ: Cha, Mẹ, Vợ, Chồng..." value="{{ old('new_deceased_relationship') }}">
                                        <label class="label">
                                            <span class="label-text-alt text-slate-500">Hiện tại: {{ $grave->deceased_relationship ?? 'Chưa có' }}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Thông tin khác -->
                            <div class="bg-white rounded-xl p-4 border border-slate-200">
                                <h3 class="font-bold text-lg mb-4 text-slate-700">Thông tin khác</h3>
                                <div class="space-y-4">
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text font-medium">Vị trí lăng mộ</span>
                                        </label>
                                        <textarea name="new_location_description" rows="2" class="textarea textarea-bordered w-full" placeholder="Mô tả vị trí chi tiết">{{ old('new_location_description') }}</textarea>
                                        <label class="label">
                                            <span class="label-text-alt text-slate-500">Hiện tại: {{ $grave->location_description ?? 'Chưa có' }}</span>
                                        </label>
                                    </div>

                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text font-medium">Ghi chú</span>
                                        </label>
                                        <textarea name="new_notes" rows="2" class="textarea textarea-bordered w-full" placeholder="Ghi chú bổ sung">{{ old('new_notes') }}</textarea>
                                        <label class="label">
                                            <span class="label-text-alt text-slate-500">Hiện tại: {{ Str::limit($grave->notes ?? 'Chưa có', 50) }}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Lý do yêu cầu -->
                            <div class="form-control w-full">
                                <label class="block mb-2">
                                    <span class="text-sm font-semibold text-neutral">Lý do yêu cầu sửa đổi <span class="text-error">*</span></span>
                                </label>
                                <textarea name="reason" rows="4" class="textarea textarea-bordered w-full @error('reason') textarea-error @enderror" placeholder="Vui lòng mô tả chi tiết lý do bạn yêu cầu sửa đổi thông tin..." required>{{ old('reason') }}</textarea>
                                @error('reason')
                                    <div class="mt-1">
                                        <span class="text-xs text-error">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                </div>
            </div>

                <!-- Actions -->
                <div class="card bg-gradient-to-br from-base-100 to-base-200 shadow-lg border border-base-300">
                    <div class="card-body">
                        <div class="flex flex-col sm:flex-row gap-3 justify-end">
                            <a href="{{ route('grave.show', $grave->id) }}" class="btn btn-outline btn-lg gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                                </svg>
                                Hủy bỏ
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg gap-2 shadow-lg hover:shadow-xl transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                </svg>
                                Gửi yêu cầu
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sidebar Info -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Grave Quick Info -->
            <div class="card bg-gradient-to-br from-primary/10 to-primary/5 shadow-xl border border-primary/20">
                <div class="card-body">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="p-2 bg-primary/10 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-primary">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-xl text-primary">Thông tin lăng mộ</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="bg-base-100 rounded-lg p-3 border border-primary/10">
                            <p class="text-xs font-medium text-base-content/50 uppercase tracking-wider mb-1">Số lăng mộ</p>
                            <p class="font-bold text-xl text-primary">{{ $grave->grave_number }}</p>
                        </div>
                        
                        <div class="bg-base-100 rounded-lg p-3 border border-primary/10">
                            <p class="text-xs font-medium text-base-content/50 uppercase tracking-wider mb-1">Nghĩa trang</p>
                            <p class="font-semibold text-neutral">{{ $grave->cemetery->name }}</p>
                        </div>

                        <div class="bg-base-100 rounded-lg p-3 border border-primary/10">
                            <p class="text-xs font-medium text-base-content/50 uppercase tracking-wider mb-1">Chủ lăng mộ</p>
                            <p class="font-semibold text-neutral">{{ $grave->owner_name }}</p>
                        </div>
                    </div>

                    <div class="divider my-3"></div>

                    <a href="{{ route('grave.show', $grave->id) }}" class="btn btn-outline btn-primary w-full gap-2 hover:shadow-lg transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        Xem chi tiết lăng mộ
                    </a>
                </div>
            </div>

            <!-- Guidelines -->
            <div class="card bg-gradient-to-br from-warning/10 to-warning/5 border border-warning/30 shadow-lg">
                <div class="card-body">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="p-2 bg-warning/10 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-warning">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg text-warning">Lưu ý quan trọng</h3>
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-3 bg-base-100 p-3 rounded-lg border border-warning/10 min-h-[60px]">
                            <div class="shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-warning">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                            <span class="text-base-content leading-relaxed">Vui lòng cung cấp thông tin <strong>chính xác và đầy đủ</strong></span>
                        </div>
                        <div class="flex items-center gap-3 bg-base-100 p-3 rounded-lg border border-warning/10 min-h-[60px]">
                            <div class="shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-warning">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                            <span class="text-base-content leading-relaxed">Đơn yêu cầu sẽ được xem xét trong <strong>3-5 ngày làm việc</strong></span>
                        </div>
                        <div class="flex items-center gap-3 bg-base-100 p-3 rounded-lg border border-warning/10 min-h-[60px]">
                            <div class="shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-warning">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                                </svg>
                            </div>
                            <span class="text-base-content leading-relaxed">Chúng tôi có thể liên hệ để <strong>xác minh thông tin</strong></span>
                        </div>
                        <div class="flex items-center gap-3 bg-base-100 p-3 rounded-lg border border-warning/10 min-h-[60px]">
                            <div class="shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-warning">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                </svg>
                            </div>
                            <span class="text-base-content leading-relaxed">Giữ điện thoại thông suốt để <strong>nhận phản hồi</strong></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Help -->
            <div class="card bg-gradient-to-br from-info/10 to-info/5 border border-info/30 shadow-lg">
                <div class="card-body">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="p-2 bg-info/10 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-info">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg text-info">Cần hỗ trợ?</h3>
                    </div>
                    
                    <p class="text-sm text-base-content/70 mb-4">
                        Nếu bạn gặp khó khăn khi điền form, vui lòng liên hệ:
                    </p>
                    
                    <div class="space-y-3 text-sm">
                        <a href="tel:1900xxxx" class="flex items-center gap-3 bg-base-100 p-3 rounded-lg border border-info/10 hover:border-info/30 hover:shadow-md transition-all group">
                            <div class="p-2 bg-info/10 rounded-lg group-hover:bg-info/20 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-info">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-base-content/50 font-medium">Hotline</p>
                                <p class="font-bold text-base text-neutral">1900-xxxx</p>
                            </div>
                        </a>
                        <a href="mailto:support@example.com" class="flex items-center gap-3 bg-base-100 p-3 rounded-lg border border-info/10 hover:border-info/30 hover:shadow-md transition-all group">
                            <div class="p-2 bg-info/10 rounded-lg group-hover:bg-info/20 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-info">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-base-content/50 font-medium">Email</p>
                                <p class="font-semibold text-sm text-neutral">support@example.com</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

