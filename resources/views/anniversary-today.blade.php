@extends('layouts.app')

@section('title', 'Ngày giỗ hôm nay - Tra cứu liệt sĩ tỉnh Ninh Bình')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body.anniversary-page {
            font-family: 'Merriweather', serif;
            background-color: #f5f3e7;
        }

        .anniversary-header {
            background: linear-gradient(135deg, #8b0000 0%, #a52a2a 100%);
            color: #f5f3e7;
            padding: 3rem 0;
            margin-bottom: 2rem;
        }

        .anniversary-header h1 {
            color: #f5f3e7;
            font-weight: 700;
        }

        .date-display {
            background-color: rgba(245, 243, 231, 0.1);
            padding: 1rem;
            border-radius: 0.5rem;
            margin-top: 1rem;
        }

        .martyr-card {
            background-color: #fafaf8;
            border: 1px solid #d4d0c8;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .martyr-card:hover {
            box-shadow: 0 4px 6px rgba(139, 0, 0, 0.1);
        }

        .tribute-btn {
            background-color: #8b0000;
            color: #f5f3e7;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 0.25rem;
            font-family: 'Merriweather', serif;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .tribute-btn:hover:not(:disabled) {
            background-color: #6b0000;
        }

        .tribute-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .tribute-count {
            color: #8b0000;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .search-box {
            background-color: #fff;
            border: 2px solid #d4d0c8;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 2rem;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d4d0c8;
            border-radius: 0.25rem;
            font-family: 'Merriweather', serif;
        }

        table {
            background-color: #fff;
            border-radius: 0.5rem;
            overflow: hidden;
        }

        thead {
            background-color: #8b0000;
            color: #f5f3e7;
        }

        th {
            padding: 1rem;
            text-align: left;
            font-weight: 700;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid #e8e5e0;
            color: #2b2b2b;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background-color: #fff;
            border-radius: 0.5rem;
            color: #8b0000;
        }
    </style>
@endpush

@section('content')
    <div class="anniversary-page">
        <!-- Header -->
        <div class="anniversary-header">
            <div class="text-center">
                <h1 class="text-4xl mb-4">🕯️ Ngày giỗ hôm nay</h1>
                <div class="date-display">
                    <p class="text-lg font-semibold mb-2">
                        Ngày {{ now()->format('d') }} tháng {{ now()->format('m') }} năm {{ now()->format('Y') }}
                        @if ($todayLunar)
                            (Âm lịch: {{ $todayLunar['day'] }}/{{ $todayLunar['month'] }}/{{ $todayLunar['year'] }})
                        @endif
                    </p>
                    <p class="text-sm opacity-90">
                        Tìm thấy <strong>{{ $graves->total() }}</strong> liệt sĩ có ngày giỗ hôm nay
                    </p>
                </div>
            </div>
        </div>

        <!-- Search Box -->
        <div class="search-box">
            <input type="text" id="searchInput" class="search-input"
                placeholder="Tìm kiếm theo tên, quê quán, nghĩa trang...">
        </div>

        <!-- Results -->
        @if ($graves->count() > 0)
            <!-- Desktop Table -->
            <div class="hidden lg:block overflow-x-auto mb-8">
                <table class="w-full">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Họ tên liệt sĩ</th>
                            <th>Quê quán</th>
                            <th>Nghĩa trang</th>
                            <th>Ngày hy sinh</th>
                            <th>Ngày giỗ (âm lịch)</th>
                            <th>Lượt thắp hương hôm nay</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="graveTableBody">
                        @foreach ($graves as $index => $grave)
                            <tr class="martyr-row" data-grave-id="{{ $grave->id }}"
                                data-name="{{ strtolower($grave->deceased_full_name ?? '') }}"
                                data-hometown="{{ strtolower($grave->cemetery->commune . ', ' . $grave->cemetery->district ?? '') }}"
                                data-cemetery="{{ strtolower($grave->cemetery->name ?? '') }}">
                                <td>{{ $graves->firstItem() + $index }}</td>
                                <td class="font-semibold">{{ $grave->deceased_full_name ?? '-' }}</td>
                                <td>{{ $grave->cemetery ? $grave->cemetery->commune . ', ' . $grave->cemetery->district : '-' }}
                                </td>
                                <td>{{ $grave->cemetery->name ?? '-' }}</td>
                                <td>{{ $grave->deceased_death_date ? $grave->deceased_death_date->format('d/m/Y') : '-' }}
                                </td>
                                @php
                                    $lunarDate = $grave->getLunarDate();
                                @endphp
                                <td>{{ $lunarDate ? sprintf('%02d/%02d', $lunarDate['month'], $lunarDate['day']) : '-' }}
                                </td>
                                <td>
                                    <span class="tribute-count" id="tribute-count-{{ $grave->id }}">
                                        {{ $grave->tribute_count_today }}
                                    </span>
                                </td>
                                <td>
                                    <button class="tribute-btn"
                                        onclick="openTributeModal({{ $grave->id }}, '{{ $grave->deceased_full_name ?? 'Liệt sĩ' }}')"
                                        id="tribute-btn-{{ $grave->id }}">
                                        🕯️ Thắp hương
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="lg:hidden space-y-4">
                @foreach ($graves as $index => $grave)
                    <div class="martyr-card martyr-row" data-grave-id="{{ $grave->id }}"
                        data-name="{{ strtolower($grave->deceased_full_name ?? '') }}"
                        data-hometown="{{ strtolower($grave->cemetery->commune . ', ' . $grave->cemetery->district ?? '') }}"
                        data-cemetery="{{ strtolower($grave->cemetery->name ?? '') }}">
                        <div class="mb-3">
                            <span class="text-sm text-gray-600">#{{ $graves->firstItem() + $index }}</span>
                            <h3 class="font-bold text-lg mb-2">{{ $grave->deceased_full_name ?? '-' }}</h3>
                            <p class="text-sm"><strong>Quê quán:</strong>
                                {{ $grave->cemetery ? $grave->cemetery->commune . ', ' . $grave->cemetery->district : '-' }}
                            </p>
                            <p class="text-sm"><strong>Nghĩa trang:</strong> {{ $grave->cemetery->name ?? '-' }}</p>
                            <p class="text-sm"><strong>Ngày hy sinh:</strong>
                                {{ $grave->deceased_death_date ? $grave->deceased_death_date->format('d/m/Y') : '-' }}</p>
                            @php
                                $lunarDate = $grave->getLunarDate();
                            @endphp
                            <p class="text-sm"><strong>Ngày giỗ (âm lịch):</strong>
                                {{ $lunarDate ? sprintf('%02d/%02d', $lunarDate['month'], $lunarDate['day']) : '-' }}</p>
                            <p class="tribute-count mt-2">
                                Đã có <span
                                    id="tribute-count-{{ $grave->id }}">{{ $grave->tribute_count_today }}</span> người
                                thắp hương hôm nay
                            </p>
                        </div>
                        <button class="tribute-btn w-full"
                            onclick="openTributeModal({{ $grave->id }}, '{{ $grave->deceased_full_name ?? 'Liệt sĩ' }}')"
                            id="tribute-btn-{{ $grave->id }}">
                            🕯️ Thắp hương
                        </button>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center mt-8">
                {{ $graves->appends(request()->query())->links() }}
            </div>
        @else
            <div class="empty-state">
                <h2 class="text-2xl mb-4">Không có liệt sĩ nào có ngày giỗ hôm nay</h2>
                <p class="text-gray-600">Vui lòng quay lại vào ngày khác</p>
            </div>
        @endif

        <!-- Tribute Modal (Reused from existing tribute feature) -->
        <div id="tributeModal" style="display: none;"
            class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6" onclick="event.stopPropagation()">
                <h2 id="tributeModalTitle" class="text-2xl font-bold mb-4 text-8b0000"></h2>

                <form id="tributeForm" onsubmit="submitTribute(event)">
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Tên người thắp hương (tùy chọn)</label>
                        <input type="text" name="name" class="w-full px-3 py-2 border rounded"
                            placeholder="Để trống để ẩn danh">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Lời tưởng niệm (tối đa 500 ký tự)</label>
                        <textarea name="message" rows="4" class="w-full px-3 py-2 border rounded" maxlength="500" id="tributeMessage"></textarea>
                        <p class="text-sm text-gray-600">Số ký tự: <span id="charCount">0</span>/500</p>
                    </div>

                    <div id="tributeError" class="mb-4 text-red-600 hidden"></div>

                    <div class="flex gap-3">
                        <button type="button" onclick="closeTributeModal()"
                            class="flex-1 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                            Hủy
                        </button>
                        <button type="submit" id="submitTributeBtn" class="flex-1 px-4 py-2 text-white rounded"
                            style="background-color: #8b0000;" onmouseover="this.style.backgroundColor='#6b0000'"
                            onmouseout="this.style.backgroundColor='#8b0000'">
                            Thắp hương
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/anniversary.js') }}"></script>
@endpush
