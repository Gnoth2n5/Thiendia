@extends('layouts.app')

@section('title', 'Kết quả tìm kiếm - Tra cứu liệt sĩ tỉnh Ninh Bình')

@section('content')
    <!-- Page Header -->
    <div class="mb-8">
        <div class="text-center mb-8">
            <div class="relative inline-block mb-6">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-green-400 to-blue-500 rounded-full blur-xl opacity-30 animate-pulse">
                </div>
                <div class="relative p-4 bg-gradient-to-br from-purple-500 to-red-500 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="h-12 w-12 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </div>
            </div>
            <h1 class="text-4xl font-bold text-red-600 mb-4">
                Tìm kiếm lăng mộ
            </h1>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                Nhập thông tin để tra cứu lăng mộ tại các nghĩa trang Ninh Bình
            </p>
        </div>
    </div>

    <!-- Search Form -->
    <div class="card bg-gradient-to-br from-white via-slate-50/50 to-green-50/30 shadow-xl mb-8 border border-green-200/50">
        <div class="card-body">
            <h2 class="card-title text-2xl text-slate-800 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="h-6 w-6 text-green-600">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                </svg>
                Bộ lọc tìm kiếm
            </h2>
            <form action="{{ route('search') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Tên người đã khuất</span>
                        </label>
                        <input type="text" name="deceased_name" placeholder="Nhập tên người đã khuất"
                            class="input input-bordered w-full" value="{{ request('deceased_name') }}">
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Tên chủ lăng mộ</span>
                        </label>
                        <input type="text" name="owner_name" placeholder="Nhập tên chủ lăng mộ"
                            class="input input-bordered w-full" value="{{ request('owner_name') }}">
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Số lăng mộ</span>
                        </label>
                        <input type="text" name="grave_number" placeholder="Ví dụ: 1-001"
                            class="input input-bordered w-full" value="{{ request('grave_number') }}">
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Xã/Phường/Thị trấn</span>
                        </label>
                        <select name="commune" id="commune" class="select select-bordered w-full"
                            data-selected="{{ request('commune') }}">
                            <option value="">Tất cả xã/phường</option>
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Nghĩa trang</span>
                        </label>
                        <select name="cemetery_id" id="cemetery_id" class="select select-bordered w-full"
                            data-selected="{{ request('cemetery_id') }}">
                            <option value="">Tất cả nghĩa trang</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-3 justify-end">
                    <a href="{{ route('search') }}" class="btn btn-ghost gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                        Xóa bộ lọc
                    </a>
                    <button type="submit"
                        class="relative inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-500 to-red-500 hover:from-purple-700 hover:to-red-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        Tìm kiếm
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Search Results -->
    <div class="search-results-content">
        @if (request()->hasAny(['grave_number', 'owner_name', 'deceased_name', 'cemetery_id', 'district', 'commune']))
            <div class="mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-neutral">Kết quả tìm kiếm</h2>
                        <p class="text-sm text-base-content/60 search-result-count">Tìm thấy {{ $graves->total() }} lăng
                            mộ</p>
                    </div>
                </div>
            </div>

            @if ($graves->count() > 0)
                <!-- Table Container -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden mb-8">
                    <!-- Desktop Table -->
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="w-full">
                            <!-- Table Header -->
                            <thead class="bg-gradient-to-r from-blue-50 to-green-50 border-b border-gray-200">
                                <tr>
                                    <th
                                        class="px-4 py-4 text-left text-sm font-bold text-gray-700 border-r border-gray-200">
                                        STT
                                    </th>
                                    <th
                                        class="px-4 py-4 text-left text-sm font-bold text-gray-700 border-r border-gray-200">
                                        Họ tên liệt sĩ
                                    </th>
                                    <th
                                        class="px-4 py-4 text-left text-sm font-bold text-gray-700 border-r border-gray-200">
                                        Năm sinh
                                    </th>
                                    <th
                                        class="px-4 py-4 text-left text-sm font-bold text-gray-700 border-r border-gray-200">
                                        Năm hy sinh
                                    </th>
                                    <th
                                        class="px-4 py-4 text-left text-sm font-bold text-gray-700 border-r border-gray-200">
                                        Nghĩa trang
                                    </th>
                                    <th
                                        class="px-4 py-4 text-left text-sm font-bold text-gray-700 border-r border-gray-200">
                                        Huyện/TP
                                    </th>
                                    <th
                                        class="px-4 py-4 text-left text-sm font-bold text-gray-700 border-r border-gray-200">
                                        Xã/Phường
                                    </th>
                                    <th
                                        class="px-4 py-4 text-left text-sm font-bold text-gray-700 border-r border-gray-200">
                                        Loại mộ
                                    </th>
                                    <th class="px-4 py-4 text-center text-sm font-bold text-gray-700">
                                        Thao tác
                                    </th>
                                </tr>
                            </thead>

                            <!-- Table Body -->
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($graves as $index => $grave)
                                    <tr
                                        class="hover:bg-gradient-to-r hover:from-blue-50/30 hover:to-green-50/30 transition-all duration-200 group">
                                        <!-- STT -->
                                        <td class="px-4 py-4 text-sm text-gray-600 border-r border-gray-100 font-medium">
                                            {{ $graves->firstItem() + $index }}
                                        </td>

                                        <!-- Họ tên liệt sĩ -->
                                        <td class="px-4 py-4 border-r border-gray-100">
                                            <div class="flex flex-col">
                                                <div class="font-semibold text-gray-900 text-sm mb-1">
                                                    {{ $grave->deceased_full_name ?: $grave->owner_name }}
                                                </div>
                                                @if ($grave->grave_number)
                                                    <div
                                                        class="text-xs text-blue-600 bg-blue-50 px-2 py-1 rounded-full inline-block w-fit">
                                                        {{ $grave->grave_number }}
                                                    </div>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Năm sinh -->
                                        <td class="px-4 py-4 text-sm text-gray-600 border-r border-gray-100">
                                            @if ($grave->deceased_birth_date)
                                                {{ $grave->deceased_birth_date->format('Y') }}
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>

                                        <!-- Năm hy sinh -->
                                        <td class="px-4 py-4 text-sm text-gray-600 border-r border-gray-100">
                                            @if ($grave->deceased_death_date)
                                                {{ $grave->deceased_death_date->format('Y') }}
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>

                                        <!-- Nghĩa trang -->
                                        <td class="px-4 py-4 text-sm text-gray-700 border-r border-gray-100">
                                            <div class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="h-4 w-4 text-green-600">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                                </svg>
                                                <span class="font-medium">{{ $grave->cemetery->name }}</span>
                                            </div>
                                        </td>

                                        <!-- Huyện/TP -->
                                        <td class="px-4 py-4 text-sm text-gray-600 border-r border-gray-100">
                                            {{ $grave->cemetery->district }}
                                        </td>

                                        <!-- Xã/Phường -->
                                        <td class="px-4 py-4 text-sm text-gray-600 border-r border-gray-100">
                                            {{ $grave->cemetery->commune }}
                                        </td>

                                        <!-- Loại mộ -->
                                        <td class="px-4 py-4 text-sm border-r border-gray-100">
                                            <div class="flex flex-col gap-1">
                                                <span
                                                    class="font-medium text-gray-700">{{ $grave->grave_type_label }}</span>
                                                <div class="flex items-center gap-2">
                                                    <div
                                                        class="w-2 h-2 rounded-full {{ $grave->status === 'đã_sử_dụng' ? 'bg-green-500' : 'bg-gray-400' }}">
                                                    </div>
                                                    <span class="text-xs text-gray-500">{{ $grave->status_label }}</span>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Thao tác -->
                                        <td class="px-4 py-4 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <!-- View Details Button -->
                                                <button onclick="openGraveModal({{ $grave->id }})"
                                                    class="inline-flex items-center gap-1 px-3 py-2 bg-gradient-to-r from-purple-500 to-red-500 hover:from-purple-600 hover:to-red-600 text-white text-xs font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 hover:scale-105">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        class="h-3 w-3">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                    </svg>
                                                    Xem
                                                </button>

                                                <!-- Map Location Button -->
                                                <button
                                                    class="inline-flex items-center gap-1 px-3 py-2 bg-gradient-to-r from-red-500 to-orange-500 hover:from-red-600 hover:to-orange-600 text-white text-xs font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 hover:scale-105">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        class="h-3 w-3">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                                    </svg>
                                                    Vị trí
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Cards -->
                    <div class="lg:hidden">
                        @foreach ($graves as $index => $grave)
                            <div
                                class="border-b border-gray-100 last:border-b-0 p-4 hover:bg-gradient-to-r hover:from-blue-50/30 hover:to-green-50/30 transition-all duration-200">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span
                                                class="text-sm font-bold text-blue-600">#{{ $graves->firstItem() + $index }}</span>
                                            @if ($grave->grave_number)
                                                <span class="text-xs text-blue-600 bg-blue-50 px-2 py-1 rounded-full">
                                                    {{ $grave->grave_number }}
                                                </span>
                                            @endif
                                        </div>
                                        <h3 class="font-bold text-gray-900 text-base mb-1">
                                            {{ $grave->deceased_full_name ?: $grave->owner_name }}
                                        </h3>
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="h-4 w-4 text-green-600">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                            </svg>
                                            <span class="font-medium">{{ $grave->cemetery->name }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-2 h-2 rounded-full {{ $grave->status === 'đã_sử_dụng' ? 'bg-green-500' : 'bg-gray-400' }}">
                                        </div>
                                        <span class="text-xs text-gray-500">{{ $grave->status_label }}</span>
                                    </div>
                                </div>

                                <!-- Mobile Info Grid -->
                                <div class="grid grid-cols-2 gap-3 text-sm mb-3">
                                    <div>
                                        <span class="text-gray-500">Năm sinh:</span>
                                        <div class="font-medium">
                                            @if ($grave->deceased_birth_date)
                                                {{ $grave->deceased_birth_date->format('Y') }}
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Năm hy sinh:</span>
                                        <div class="font-medium">
                                            @if ($grave->deceased_death_date)
                                                {{ $grave->deceased_death_date->format('Y') }}
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Huyện/TP:</span>
                                        <div class="font-medium">{{ $grave->cemetery->district }}</div>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Xã/Phường:</span>
                                        <div class="font-medium">{{ $grave->cemetery->commune }}</div>
                                    </div>
                                </div>

                                <!-- Mobile Actions -->
                                <div class="flex gap-2">
                                    <button onclick="openGraveModal({{ $grave->id }})"
                                        class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2 bg-gradient-to-r from-purple-500 to-red-500 hover:from-purple-600 hover:to-red-600 text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        Xem chi tiết
                                    </button>
                                    <button
                                        class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2 bg-gradient-to-r from-red-500 to-orange-500 hover:from-red-600 hover:to-orange-600 text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                        </svg>
                                        Vị trí
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Pagination -->
                <div class="flex justify-center">
                    {{ $graves->appends(request()->query())->links() }}
                </div>
            @else
                <div class="card bg-base-100 shadow-lg border border-base-300">
                    <div class="card-body text-center py-16">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="h-16 w-16 mx-auto text-base-content/30 mb-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        <h3 class="text-xl font-bold text-neutral mb-2">Không tìm thấy kết quả</h3>
                        <p class="text-base-content/60 mb-4">Vui lòng thử lại với thông tin khác hoặc mở rộng tiêu chí tìm
                            kiếm</p>
                        <a href="{{ route('search') }}" class="btn btn-ghost">Xóa bộ lọc</a>
                    </div>
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="card bg-base-100 shadow-lg border border-base-300">
                <div class="card-body text-center py-16">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-16 w-16 mx-auto text-primary/50 mb-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <h3 class="text-xl font-bold text-neutral mb-2">Bắt đầu tìm kiếm</h3>
                    <p class="text-base-content/60">Nhập thông tin vào form phía trên để tra cứu lăng mộ</p>
                </div>
            </div>
        @endif
    </div>

    <!-- Grave Detail Modal -->
    <div id="graveModal" class="fixed inset-0 bg-black/40 z-50 flex items-center justify-center p-4"
        style="display: none;" onclick="closeGraveModal()">
        <div class="relative max-w-4xl w-full max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
            <!-- Close Button -->
            <button onclick="closeGraveModal()"
                class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors z-10">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-10 h-10">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Modal Content -->
            <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6">
                    <h2 id="modalTitle" class="text-2xl font-bold">Tiểu Sử Liệt Sĩ</h2>
                </div>

                <!-- Modal Body -->
                <div class="p-6 space-y-6">
                    <!-- Loading State -->
                    <div id="modalLoading" class="text-center py-8">
                        <div class="loading loading-spinner loading-lg text-primary"></div>
                        <p class="mt-4 text-gray-600">Đang tải thông tin...</p>
                    </div>

                    <!-- Content will be populated by JavaScript -->
                    <div id="modalContent" style="display: none;">
                        <!-- Thông tin liệt sĩ -->
                        <div class="bg-blue-50 rounded-lg p-4 mb-6">
                            <h3 class="text-lg font-bold text-blue-800 mb-4">Thông tin liệt sĩ</h3>
                            <div class="flex gap-4">
                                <!-- Photo -->
                                <div id="deceasedPhoto" class="flex-shrink-0">
                                    <div class="w-24 h-32 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="h-8 w-8 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                    </div>
                                </div>

                                <!-- Info -->
                                <div class="flex-1 space-y-2">
                                    <div>
                                        <span class="text-sm text-gray-600">Liệt sĩ:</span>
                                        <p id="deceasedName" class="font-bold text-lg text-red-600"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-600">Năm sinh:</span>
                                        <p id="deceasedBirth" class="font-medium"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-600">Năm hy sinh:</span>
                                        <p id="deceasedDeath" class="font-medium"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-600">Quê quán:</span>
                                        <p id="deceasedHometown" class="font-medium"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-600">Nghĩa trang:</span>
                                        <p id="cemeteryName" class="font-medium"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-600">Vị trí:</span>
                                        <p id="graveLocation" class="font-medium"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ảnh chụp mộ liệt sĩ -->
                        <div class="bg-blue-50 rounded-lg p-4 mb-6">
                            <h3 class="text-lg font-bold text-blue-800 mb-4">Ảnh chụp mộ liệt sĩ</h3>
                            <div id="gravePhotos" class="flex gap-4 justify-center">
                                <!-- Photos will be populated by JavaScript -->
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3 justify-center">
                            <button onclick="closeGraveModal()"
                                class="px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                                Đóng
                            </button>
                            <a id="viewDetailsBtn" href="#"
                                class="px-6 py-3 bg-gradient-to-r from-purple-500 to-red-500 hover:from-purple-600 hover:to-red-600 text-white font-medium rounded-lg transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="h-5 w-5 inline mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    let currentGraveData = null;

    async function openGraveModal(graveId) {
        const modal = document.getElementById('graveModal');
        const loading = document.getElementById('modalLoading');
        const content = document.getElementById('modalContent');

        // Show modal and loading
        modal.style.display = 'flex';
        loading.style.display = 'block';
        content.style.display = 'none';
        document.body.style.overflow = 'hidden';

        try {
            // Fetch grave data
            const response = await fetch(`/api/graves/${graveId}`);
            const grave = await response.json();

            currentGraveData = grave;

            // Populate modal content
            populateModalContent(grave);

            // Hide loading, show content
            loading.style.display = 'none';
            content.style.display = 'block';

        } catch (error) {
            console.error('Error fetching grave data:', error);
            loading.innerHTML = `
                <div class="text-center py-8">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-16 w-16 mx-auto text-red-500 mb-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                    <h3 class="text-xl font-bold text-red-600 mb-2">Lỗi tải dữ liệu</h3>
                    <p class="text-gray-600">Không thể tải thông tin lăng mộ. Vui lòng thử lại.</p>
                </div>
            `;
        }
    }

    function populateModalContent(grave) {
        // Update title
        document.getElementById('modalTitle').textContent =
            `Tiểu Sử Liệt Sĩ - ${grave.deceased_full_name || grave.owner_name}`;

        // Update deceased info
        document.getElementById('deceasedName').textContent = grave.deceased_full_name || grave.owner_name;
        document.getElementById('deceasedBirth').textContent = grave.deceased_birth_date || '-';
        document.getElementById('deceasedDeath').textContent = grave.deceased_death_date || '-';
        document.getElementById('deceasedHometown').textContent = grave.cemetery.commune + ', ' + grave.cemetery
            .district;
        document.getElementById('cemeteryName').textContent = grave.cemetery.name;
        document.getElementById('graveLocation').textContent = grave.location_description || grave.grave_number || '-';

        // Update view details button URL
        document.getElementById('viewDetailsBtn').href = `/grave/${grave.id}`;

        // Update deceased photo
        const photoContainer = document.getElementById('deceasedPhoto');
        if (grave.deceased_photo) {
            photoContainer.innerHTML = `
                <img src="${grave.deceased_photo}" alt="${grave.deceased_full_name}"
                     class="w-24 h-32 object-cover rounded-lg cursor-pointer"
                     onclick="openImageModal('${grave.deceased_photo}')">
            `;
        }

        // Update grave photos
        const photosContainer = document.getElementById('gravePhotos');
        if (grave.grave_photos && grave.grave_photos.length > 0) {
            photosContainer.innerHTML = grave.grave_photos.map(photo => `
                <div class="relative group cursor-pointer" onclick="openImageModal('${photo}')">
                    <img src="${photo}" alt="Ảnh bia mộ"
                         class="w-32 h-40 object-cover rounded-lg shadow-md group-hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-all duration-300 rounded-lg flex items-center justify-center">
                        <div class="bg-white/20 backdrop-blur-sm rounded-full p-2 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </div>
                    </div>
                </div>
            `).join('');
        } else {
            photosContainer.innerHTML = `
                <div class="text-center text-gray-500 py-8">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-12 w-12 mx-auto mb-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                    <p>Chưa có hình ảnh</p>
                </div>
            `;
        }
    }

    function closeGraveModal() {
        document.getElementById('graveModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Image modal functions (reused from grave-detail.blade.php)
    let currentImageIndex = 0;
    let allImages = [];

    function openImageModal(imageUrl) {
        // Collect all images from current grave data
        allImages = [];

        if (currentGraveData) {
            if (currentGraveData.deceased_photo) {
                allImages.push({
                    url: currentGraveData.deceased_photo,
                    title: currentGraveData.deceased_full_name || 'Ảnh người đã khuất',
                    description: 'Ảnh người đã khuất'
                });
            }

            if (currentGraveData.grave_photos && currentGraveData.grave_photos.length > 0) {
                currentGraveData.grave_photos.forEach((photo, index) => {
                    allImages.push({
                        url: photo,
                        title: 'Hình ảnh bia mộ',
                        description: `Ảnh ${index + 1} trong ${currentGraveData.grave_photos.length} ảnh`
                    });
                });
            }
        }

        // Find the index of the clicked image
        currentImageIndex = allImages.findIndex(img => img.url === imageUrl);
        if (currentImageIndex === -1) {
            currentImageIndex = 0;
        }

        updateModalImage();
        updateThumbnails();
        updateNavigationButtons();

        document.getElementById('imageModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function updateModalImage() {
        const image = allImages[currentImageIndex];
        if (!image) return;

        const modalImage = document.getElementById('modalImage');
        const imageTitle = document.getElementById('imageTitle');
        const imageDescription = document.getElementById('imageDescription');

        if (modalImage) modalImage.src = image.url;
        if (imageTitle) imageTitle.textContent = image.title;
        if (imageDescription) imageDescription.textContent = image.description;
    }

    function updateThumbnails() {
        const container = document.getElementById('thumbnailContainer');
        container.innerHTML = '';

        allImages.forEach((image, index) => {
            const thumbnail = document.createElement('div');
            thumbnail.className = `w-16 h-16 rounded-lg overflow-hidden cursor-pointer border-2 transition-all ${
                index === currentImageIndex ? 'border-white' : 'border-transparent opacity-60'
            }`;
            thumbnail.onclick = () => {
                currentImageIndex = index;
                updateModalImage();
                updateThumbnails();
                updateNavigationButtons();
            };

            const img = document.createElement('img');
            img.src = image.url;
            img.alt = image.title;
            img.className = 'w-full h-full object-cover';

            thumbnail.appendChild(img);
            container.appendChild(thumbnail);
        });
    }

    function updateNavigationButtons() {
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        prevBtn.style.display = allImages.length > 1 ? 'block' : 'none';
        nextBtn.style.display = allImages.length > 1 ? 'block' : 'none';
    }

    function navigateImage(direction) {
        if (allImages.length <= 1) return;

        currentImageIndex += direction;

        if (currentImageIndex >= allImages.length) {
            currentImageIndex = 0;
        } else if (currentImageIndex < 0) {
            currentImageIndex = allImages.length - 1;
        }

        updateModalImage();
        updateThumbnails();
    }

    function closeImageModal() {
        document.getElementById('imageModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (document.getElementById('imageModal').style.display === 'none') return;

        switch (e.key) {
            case 'Escape':
                closeImageModal();
                break;
            case 'ArrowLeft':
                navigateImage(-1);
                break;
            case 'ArrowRight':
                navigateImage(1);
                break;
        }
    });
</script>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black/40 z-50 flex items-center justify-center p-4"
    style="display: none;" onclick="closeImageModal()">
    <div class="relative max-w-6xl w-full max-h-[90vh]">
        <!-- Close Button -->
        <button onclick="closeImageModal()"
            class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors z-10">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-10 h-10">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Navigation Arrows -->
        <button id="prevBtn" onclick="event.stopPropagation(); navigateImage(-1);"
            class="absolute left-4 top-1/2 -translate-y-1/2 text-white hover:text-gray-300 transition-colors z-10 bg-black/50 rounded-full p-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
        </button>

        <button id="nextBtn" onclick="event.stopPropagation(); navigateImage(1);"
            class="absolute right-4 top-1/2 -translate-y-1/2 text-white hover:text-gray-300 transition-colors z-10 bg-black/50 rounded-full p-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
        </button>

        <!-- Image Container -->
        <div class="relative bg-white rounded-xl overflow-hidden shadow-2xl" onclick="event.stopPropagation()">
            <img id="modalImage" src="" alt="Ảnh phóng to"
                class="w-full h-auto max-h-[80vh] object-contain" />

            <!-- Image Info -->
            <div id="imageInfo"
                class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-4 text-white">
                <p id="imageTitle" class="font-semibold text-lg"></p>
                <p id="imageDescription" class="text-sm opacity-90"></p>
            </div>
        </div>

        <!-- Thumbnail Navigation -->
        <div id="thumbnailContainer" class="flex gap-2 mt-4 justify-center overflow-x-auto max-w-full">
            <!-- Thumbnails will be populated by JavaScript -->
        </div>
    </div>
</div>
