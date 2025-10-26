<!DOCTYPE html>
<html lang="vi" data-theme="cemetery">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tra cứu liệt sĩ tỉnh Ninh Bình')</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('description', 'Hệ thống tra cứu thông tin liệt sĩ tỉnh Ninh Bình trực tuyến. Tìm kiếm lăng mộ nhanh chóng, chính xác và tiện lợi. Quản lý dữ liệu nghĩa trang khoa học, minh bạch và hiện đại.')">
    <meta name="keywords"
        content="tra cứu liệt sĩ, nghĩa trang Ninh Bình, tìm kiếm lăng mộ, quản lý nghĩa địa, hệ thống tra cứu trực tuyến, bản đồ số nghĩa trang">
    <meta name="author" content="Hệ thống Tra cứu Liệt sĩ Ninh Bình">
    <meta name="robots" content="index, follow">
    <meta name="language" content="vi">
    <meta name="geo.region" content="VN-18">
    <meta name="geo.placename" content="Ninh Bình, Việt Nam">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('title', 'Tra cứu liệt sĩ tỉnh Ninh Bình')">
    <meta property="og:description" content="@yield('description', 'Hệ thống tra cứu thông tin liệt sĩ tỉnh Ninh Bình trực tuyến. Tìm kiếm lăng mộ nhanh chóng, chính xác và tiện lợi.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Hệ thống Tra cứu Liệt sĩ Ninh Bình">
    <meta property="og:locale" content="vi_VN">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Tra cứu liệt sĩ tỉnh Ninh Bình')">
    <meta name="twitter:description" content="@yield('description', 'Hệ thống tra cứu thông tin liệt sĩ tỉnh Ninh Bình trực tuyến. Tìm kiếm lăng mộ nhanh chóng, chính xác và tiện lợi.')">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <style>
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>

    @stack('styles')
    @stack('structured-data')
</head>

<body class="bg-base-200 min-h-screen">
    <!-- Top Bar -->
    <div class="bg-neutral text-neutral-content py-2 border-b border-base-300">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center text-sm">
                <div class="flex items-center gap-4">
                    <span class="flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                        </svg>
                        Hotline: 1900-xxxx
                    </span>
                    <span class="flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        24/7 Hỗ trợ
                    </span>
                </div>
                <a href="{{ url('/admin') }}" class="hover:text-accent transition-colors">Đăng nhập quản trị</a>
            </div>
        </div>
    </div>

    <!-- Navigation Bar -->
    <nav class="bg-red-600 shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <!-- Logo Section -->
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}"
                        class="group flex items-center gap-3 hover:scale-105 transition-transform duration-300">
                        <div class="relative">
                            <div class="relative p-2 bg-white/20 rounded-lg">
                                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10">
                            </div>
                        </div>
                        <div class="hidden sm:block text-white">
                            <div class="text-lg font-bold">Hệ thống Tra cứu liệt sĩ</div>
                            <div class="text-sm opacity-90">Tỉnh Ninh Bình</div>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-1">
                    <a href="{{ route('home') }}"
                        class="px-4 py-2 text-white font-semibold hover:bg-red-700 transition-colors duration-300 rounded {{ request()->routeIs('home') ? 'bg-red-700' : '' }}">
                        Trang Chủ
                    </a>

                    {{-- <div class="relative group">
                        <a href="#"
                            class="px-4 py-2 text-white font-semibold hover:bg-red-700 transition-colors duration-300 rounded flex items-center gap-1">
                            Giới Thiệu
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </a>

                    </div> --}}

                    <div class="relative group">
                        <a href="{{ route('articles.index') }}"
                            class="px-4 py-2 text-white font-semibold hover:bg-red-700 transition-colors duration-300 rounded flex items-center gap-1 {{ request()->routeIs('articles.*') ? 'bg-red-700' : '' }}">
                            Tin Tức – Sự Kiện
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </a>
                        <!-- Dropdown menu -->
                        <div
                            class="absolute top-full left-0 bg-white shadow-xl rounded-lg py-2 min-w-48 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                            <a href="{{ route('articles.index') }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Tất cả tin tức</a>
                            <a href="{{ route('articles.category', 'tin_tuc') }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Tin tức</a>
                            <a href="{{ route('articles.category', 'su_kien') }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Sự kiện</a>
                            <a href="{{ route('articles.category', 'thong_bao') }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Thông báo</a>
                        </div>
                    </div>

                    {{-- <a href="#" class="px-4 py-2 text-white font-semibold hover:bg-red-700 transition-colors duration-300 rounded">
                            Hình Ảnh Hoạt Động
                        </a> --}}

                    <a href="{{ route('search') }}"
                        class="px-4 py-2 text-white font-semibold hover:bg-red-700 transition-colors duration-300 rounded {{ request()->routeIs('search') ? 'bg-red-700' : '' }}">
                        Danh Sách Liệt Sĩ
                    </a>

                    <a href="{{ route('contact') }}"
                        class="px-4 py-2 text-white font-semibold hover:bg-red-700 transition-colors duration-300 rounded {{ request()->routeIs('contact') ? 'bg-red-700' : '' }}">
                        Liên Hệ
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="lg:hidden">
                    <button type="button"
                        class="mobile-menu-button inline-flex items-center justify-center p-2 rounded text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white transition-all duration-300"
                        aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Mở menu chính</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile menu -->
            <div class="mobile-menu hidden lg:hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1 bg-red-700 rounded-lg mt-2">
                    <a href="{{ route('home') }}"
                        class="flex items-center gap-3 px-4 py-3 text-white font-semibold hover:bg-red-800 transition-colors duration-300 {{ request()->routeIs('home') ? 'bg-red-800' : '' }}">
                        Trang Chủ
                    </a>

                    <a href="{{ route('articles.index') }}"
                        class="flex items-center gap-3 px-4 py-3 text-white font-semibold hover:bg-red-800 transition-colors duration-300 {{ request()->routeIs('articles.*') ? 'bg-red-800' : '' }}">
                        Tin Tức – Sự Kiện
                    </a>

                    <a href="#"
                        class="flex items-center gap-3 px-4 py-3 text-white font-semibold hover:bg-red-800 transition-colors duration-300">
                        Hình Ảnh Hoạt Động
                    </a>

                    <a href="{{ route('search') }}"
                        class="flex items-center gap-3 px-4 py-3 text-white font-semibold hover:bg-red-800 transition-colors duration-300 {{ request()->routeIs('search') ? 'bg-red-800' : '' }}">
                        Danh Sách Liệt Sĩ
                    </a>

                    <a href="#"
                        class="flex items-center gap-3 px-4 py-3 text-white font-semibold hover:bg-red-800 transition-colors duration-300">
                        Video clip
                    </a>

                    <a href="{{ route('contact') }}"
                        class="flex items-center gap-3 px-4 py-3 text-white font-semibold hover:bg-red-800 transition-colors duration-300 {{ request()->routeIs('contact') ? 'bg-red-800' : '' }}">
                        Liên Hệ
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="container mx-auto mt-4 px-4">
            <div class="alert alert-success shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="h-6 w-6 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="container mx-auto mt-4 px-4">
            <div class="alert alert-error shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="h-6 w-6 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="container mx-auto py-8 px-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-neutral text-neutral-content mt-16">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="avatar placeholder">
                            <div class="bg-accent text-accent-content rounded-lg w-12">
                                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10">
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold">Hệ thống Tra cứu liệt sĩ tỉnh Ninh Bình</h3>
                            <p class="text-sm opacity-80">Tra cứu thông tin trực tuyến</p>
                        </div>
                    </div>
                    <p class="text-sm opacity-80 max-w-md">
                        Hệ thống cung cấp dịch vụ tra cứu thông tin lăng mộ, quản lý nghĩa địa hiện đại,
                        giúp người dân dễ dàng tìm kiếm và quản lý thông tin người thân.
                    </p>
                </div>

                <div>
                    <h4 class="font-bold mb-3">Liên kết nhanh</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-accent transition-colors">Trang chủ</a>
                        </li>
                        <li><a href="{{ route('search') }}" class="hover:text-accent transition-colors">Tra cứu</a>
                        </li>
                        <li><a href="{{ route('guide') }}" class="hover:text-accent transition-colors">Hướng dẫn sử
                                dụng</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-accent transition-colors">Câu hỏi
                                thường gặp</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold mb-3">Liên hệ</h4>
                    <ul class="space-y-2 text-sm opacity-80">
                        <li class="flex items-start gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" class="h-5 w-5 shrink-0 mt-0.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                            <span>Địa chỉ của bạn ở đây</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                            </svg>
                            <span>1900-xxxx</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                            <span>contact@example.com</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="border-t border-base-300/20">
            <div class="container mx-auto px-4 py-6">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm opacity-80">
                    <p>© {{ date('Y') }} Hệ thống Tra cứu liệt sĩ tỉnh Ninh Bình. All rights reserved.</p>
                    <div class="flex gap-6">
                        <a href="{{ route('privacy-policy') }}" class="hover:text-accent transition-colors">Chính
                            sách bảo mật</a>
                        <a href="{{ route('terms-of-service') }}" class="hover:text-accent transition-colors">Điều
                            khoản sử dụng</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    @stack('scripts')

    <!-- Navigation JavaScript -->
    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('.mobile-menu-button');
            const mobileMenu = document.querySelector('.mobile-menu');

            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';

                    // Toggle menu visibility
                    mobileMenu.classList.toggle('hidden');

                    // Update aria-expanded
                    mobileMenuButton.setAttribute('aria-expanded', !isExpanded);

                    // Update button icon
                    const icon = mobileMenuButton.querySelector('svg');
                    if (icon) {
                        if (isExpanded) {
                            // Show hamburger icon
                            icon.innerHTML =
                                '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />';
                        } else {
                            // Show close icon
                            icon.innerHTML =
                                '<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />';
                        }
                    }
                });

                // Close mobile menu when clicking outside
                document.addEventListener('click', function(event) {
                    if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                        mobileMenu.classList.add('hidden');
                        mobileMenuButton.setAttribute('aria-expanded', 'false');

                        // Reset icon to hamburger
                        const icon = mobileMenuButton.querySelector('svg');
                        if (icon) {
                            icon.innerHTML =
                                '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />';
                        }
                    }
                });

                // Close mobile menu when window is resized to desktop
                window.addEventListener('resize', function() {
                    if (window.innerWidth >= 1024) { // lg breakpoint
                        mobileMenu.classList.add('hidden');
                        mobileMenuButton.setAttribute('aria-expanded', 'false');

                        // Reset icon to hamburger
                        const icon = mobileMenuButton.querySelector('svg');
                        if (icon) {
                            icon.innerHTML =
                                '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />';
                        }
                    }
                });
            }
        });
    </script>
</body>

</html>
