@extends('layouts.app')

@section('title', 'Liên hệ - Hệ thống Tra cứu liệt sĩ tỉnh Ninh Bình')
@section('description',
    'Liên hệ với chúng tôi để được hỗ trợ tra cứu thông tin liệt sĩ, quản lý lăng mộ và các dịch vụ
    khác. Hotline 24/7, email hỗ trợ nhanh chóng.')

@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Liên Hệ Với Chúng Tôi</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Chúng tôi luôn sẵn sàng hỗ trợ bạn trong việc tra cứu thông tin liệt sĩ, quản lý lăng mộ và các dịch vụ
                khác.
                Hãy liên hệ với chúng tôi qua các kênh dưới đây.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Contact Information -->
            <div class="lg:col-span-1 space-y-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Thông Tin Liên Hệ</h2>

                    <!-- Contact Cards -->
                    <div class="space-y-6">
                        @if ($contactSetting && $contactSetting->phone)
                            <!-- Phone -->
                            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-600">
                                <div class="flex items-start gap-4">
                                    <div class="bg-blue-100 p-3 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="h-6 w-6 text-blue-600">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Hotline 24/7</h3>
                                        <p class="text-gray-600 mb-1">{{ $contactSetting->phone }}</p>
                                        <p class="text-sm text-gray-500">{{ $contactSetting->phone_description }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($contactSetting && $contactSetting->email)
                            <!-- Email -->
                            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-600">
                                <div class="flex items-start gap-4">
                                    <div class="bg-blue-100 p-3 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="h-6 w-6 text-blue-600">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Email Hỗ Trợ</h3>
                                        <p class="text-gray-600 mb-1">{{ $contactSetting->email }}</p>
                                        <p class="text-sm text-gray-500">{{ $contactSetting->email_description }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Address -->
                        @if ($contactSetting && $contactSetting->address_line1)
                            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-600">
                                <div class="flex items-start gap-4">
                                    <div class="bg-green-100 p-3 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="h-6 w-6 text-green-600">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Địa Chỉ Văn Phòng</h3>
                                        <p class="text-gray-600 mb-1">{{ $contactSetting->address_line1 }}</p>
                                        @if ($contactSetting->address_line2)
                                            <p class="text-gray-600 mb-1">{{ $contactSetting->address_line2 }}</p>
                                        @endif
                                        @if ($contactSetting->address_description)
                                            <p class="text-sm text-gray-500">{{ $contactSetting->address_description }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Working Hours -->
                @if ($contactSetting && $contactSetting->working_hours)
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Giờ Làm Việc</h3>
                        <div class="space-y-2 text-gray-600">
                            @foreach ($contactSetting->working_hours as $schedule)
                                <div class="flex justify-between">
                                    <span>{{ $schedule['day'] ?? '' }}:</span>
                                    <span
                                        class="font-medium {{ !empty($schedule['is_closed']) && $schedule['is_closed'] ? 'text-red-600' : '' }}">
                                        {{ $schedule['hours'] ?? '' }}
                                    </span>
                                </div>
                            @endforeach
                            @if ($contactSetting->note)
                                <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                                    <p class="text-sm text-blue-800">
                                        <strong>Lưu ý:</strong> {{ $contactSetting->note }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Leaflet Map -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow-lg overflow-hidden">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 p-8 pb-0">Vị Trí</h2>
                <div class="p-8 pt-4">
                    <div id="contactMapWrapper">
                        <div id="contactMapContainer"
                            style="height: 500px; width: 100%; border: 1px solid #d1d5db; border-radius: 0.5rem;"></div>
                        <div class="mt-4 space-y-2">
                            <p class="text-sm font-semibold text-gray-700">Các xã trong hệ thống:</p>
                            <div class="flex flex-wrap gap-3 text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 rounded-full bg-blue-600"></div>
                                    <span class="text-gray-600">Chính Lý</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 rounded-full bg-green-600"></div>
                                    <span class="text-gray-600">Hợp Lý</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 rounded-full bg-red-600"></div>
                                    <span class="text-gray-600">Văn Lý</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function initContactMap() {
                // Wait for Leaflet to be available
                if (typeof L === 'undefined') {
                    setTimeout(initContactMap, 100);
                    return;
                }

                const mapContainer = document.getElementById('contactMapContainer');
                if (!mapContainer) {
                    setTimeout(initContactMap, 100);
                    return;
                }

                try {
                    // Add markers for 3 communes
                    const communes = [{
                            name: 'Chính Lý',
                            lat: 20.6003355,
                            lng: 105.9976607,
                            color: '#2563eb'
                        },
                        {
                            name: 'Hợp Lý',
                            lat: 20.6102271,
                            lng: 105.9815351,
                            color: '#16a34a'
                        },
                        {
                            name: 'Văn Lý',
                            lat: 20.585758,
                            lng: 105.9737588,
                            color: '#dc2626'
                        }
                    ];

                    // Calculate center point (average of all locations)
                    const centerLat = communes.reduce((sum, c) => sum + c.lat, 0) / communes.length;
                    const centerLng = communes.reduce((sum, c) => sum + c.lng, 0) / communes.length;

                    // Initialize map
                    const map = L.map(mapContainer, {
                        zoomControl: true
                    }).setView([centerLat, centerLng], 12);

                    // Add OpenStreetMap tiles
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                        maxZoom: 19
                    }).addTo(map);

                    const markers = [];

                    communes.forEach(commune => {
                        const marker = L.marker([commune.lat, commune.lng], {
                                icon: L.divIcon({
                                    className: 'custom-marker',
                                    html: `<div style="background-color: ${commune.color}; width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>`,
                                    iconSize: [20, 20],
                                    iconAnchor: [10, 10]
                                })
                            })
                            .addTo(map)
                            .bindPopup(
                                `<strong>${commune.name}</strong><br>Tọa độ: ${commune.lat.toFixed(4)}°N, ${commune.lng.toFixed(4)}°E`
                                );

                        markers.push(marker);
                    });

                    // Fit map to show all markers
                    if (markers.length > 0) {
                        const group = new L.featureGroup(markers);
                        map.fitBounds(group.getBounds().pad(0.1));
                    }

                    // Invalidate size after a short delay to ensure proper rendering
                    setTimeout(() => {
                        map.invalidateSize();
                    }, 300);

                    console.log('Contact map initialized successfully');

                } catch (error) {
                    console.error('Error initializing contact map:', error);
                }
            }

            // Initialize map
            initContactMap();
        });
    </script>
@endsection
