<!DOCTYPE html>
<html lang="vi" data-theme="cemetery">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quản lý Nghĩa Địa')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-base-200 min-h-screen">
    <!-- Navigation -->
    <div class="navbar bg-primary text-primary-content shadow-lg">
        <div class="container mx-auto">
            <div class="flex-1">
                <a href="{{ route('home') }}" class="btn btn-ghost text-xl">
                    🏛️ Quản lý Nghĩa Địa
                </a>
            </div>
            <div class="flex-none gap-2">
                <a href="{{ route('home') }}" class="btn btn-ghost">Trang chủ</a>
                <a href="{{ route('search') }}" class="btn btn-ghost">Tìm kiếm</a>
                <a href="{{ url('/admin') }}" class="btn btn-secondary btn-sm">Quản trị</a>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="container mx-auto mt-4">
            <div class="alert alert-success shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container mx-auto mt-4">
            <div class="alert alert-error shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="container mx-auto py-8 px-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer footer-center p-10 bg-primary text-primary-content mt-12">
        <aside>
            <p class="font-bold text-lg">
                Hệ thống Quản lý Nghĩa Địa
            </p>
            <p>Copyright © {{ date('Y') }} - All rights reserved</p>
        </aside>
    </footer>
</body>
</html>

