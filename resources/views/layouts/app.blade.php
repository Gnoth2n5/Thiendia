<!DOCTYPE html>
<html lang="vi" data-theme="cemetery">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quản lý Nghĩa Địa')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>
<body class="bg-base-200 min-h-screen">
    <!-- Top Bar -->
    <div class="bg-neutral text-neutral-content py-2 border-b border-base-300">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center text-sm">
                <div class="flex items-center gap-4">
                    <span class="flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                        </svg>
                        Hotline: 1900-xxxx
                    </span>
                    <span class="flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        24/7 Hỗ trợ
                    </span>
                </div>
                <a href="{{ url('/admin') }}" class="hover:text-accent transition-colors">Đăng nhập quản trị</a>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="relative bg-white/95 backdrop-blur-xl shadow-lg border-b border-slate-200/60 sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-20">
                <!-- Logo Section -->
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" class="group flex items-center gap-4 hover:scale-105 transition-transform duration-300">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl blur opacity-0 group-hover:opacity-60 transition-opacity duration-300"></div>
                            <div class="relative p-3 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-8 w-8 text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                </svg>
                            </div>
                        </div>
                        <div class="hidden sm:block">
                            <div class="text-xl font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent group-hover:from-blue-600 group-hover:to-indigo-600 transition-all duration-300">
                                Hệ thống Quản lý
                            </div>
                            <div class="text-sm text-slate-500 group-hover:text-blue-500 transition-colors duration-300">
                                Nghĩa Địa & Lăng Mộ
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-1">
                    <a href="{{ route('home') }}" class="group relative px-6 py-3 rounded-xl font-semibold text-slate-700 hover:text-white transition-all duration-300 {{ request()->routeIs('home') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg' : 'hover:bg-gradient-to-r hover:from-blue-500 hover:to-indigo-500' }}">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            <span>Trang chủ</span>
                        </div>
                    </a>
                    
                    <a href="{{ route('search') }}" class="group relative px-6 py-3 rounded-xl font-semibold text-slate-700 hover:text-white transition-all duration-300 {{ request()->routeIs('search') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg' : 'hover:bg-gradient-to-r hover:from-blue-500 hover:to-indigo-500' }}">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                            <span>Tra cứu</span>
                        </div>
                    </a>
                    
                    <a href="#guide" class="group relative px-6 py-3 rounded-xl font-semibold text-slate-700 hover:text-white transition-all duration-300 hover:bg-gradient-to-r hover:from-blue-500 hover:to-indigo-500">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                            </svg>
                            <span>Hướng dẫn</span>
                        </div>
                    </a>
                    
                    <a href="#contact" class="group relative px-6 py-3 rounded-xl font-semibold text-slate-700 hover:text-white transition-all duration-300 hover:bg-gradient-to-r hover:from-blue-500 hover:to-indigo-500">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                            </svg>
                            <span>Liên hệ</span>
                        </div>
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="lg:hidden">
                    <button type="button" class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 transition-all duration-300" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Mở menu chính</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile menu -->
            <div class="mobile-menu hidden lg:hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1 bg-white/95 backdrop-blur-xl rounded-2xl shadow-xl border border-slate-200/60 mt-2">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-semibold text-slate-700 hover:text-white hover:bg-gradient-to-r hover:from-blue-500 hover:to-indigo-500 transition-all duration-300 {{ request()->routeIs('home') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        Trang chủ
                    </a>
                    
                    <a href="{{ route('search') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-semibold text-slate-700 hover:text-white hover:bg-gradient-to-r hover:from-blue-500 hover:to-indigo-500 transition-all duration-300 {{ request()->routeIs('search') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        Tra cứu
                    </a>
                    
                    <a href="#guide" class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-semibold text-slate-700 hover:text-white hover:bg-gradient-to-r hover:from-blue-500 hover:to-indigo-500 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                        </svg>
                        Hướng dẫn
                    </a>
                    
                    <a href="#contact" class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-semibold text-slate-700 hover:text-white hover:bg-gradient-to-r hover:from-blue-500 hover:to-indigo-500 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                        </svg>
                        Liên hệ
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="container mx-auto mt-4 px-4">
            <div class="alert alert-success shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container mx-auto mt-4 px-4">
            <div class="alert alert-error shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
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
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-7 w-7">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold">Hệ thống Quản lý Nghĩa Địa</h3>
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
                        <li><a href="{{ route('home') }}" class="hover:text-accent transition-colors">Trang chủ</a></li>
                        <li><a href="{{ route('search') }}" class="hover:text-accent transition-colors">Tra cứu</a></li>
                        <li><a href="#" class="hover:text-accent transition-colors">Hướng dẫn sử dụng</a></li>
                        <li><a href="#" class="hover:text-accent transition-colors">Câu hỏi thường gặp</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-bold mb-3">Liên hệ</h4>
                    <ul class="space-y-2 text-sm opacity-80">
                        <li class="flex items-start gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 shrink-0 mt-0.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                            <span>Địa chỉ của bạn ở đây</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                            </svg>
                            <span>1900-xxxx</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
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
                    <p>© {{ date('Y') }} Hệ thống Quản lý Nghĩa Địa. All rights reserved.</p>
                    <div class="flex gap-6">
                        <a href="#" class="hover:text-accent transition-colors">Chính sách bảo mật</a>
                        <a href="#" class="hover:text-accent transition-colors">Điều khoản sử dụng</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

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
                            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />';
                        } else {
                            // Show close icon
                            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />';
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
                            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />';
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
                            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />';
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>
