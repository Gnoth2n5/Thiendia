@extends('layouts.app')

@section('title', 'Giới thiệu - Hệ thống Tra cứu Thông tin Liệt sĩ Tỉnh Ninh Bình')

@section('description', 'Giới thiệu về hệ thống tra cứu thông tin liệt sĩ tỉnh Ninh Bình trực tuyến. Tìm hiểu về tính
    năng, lợi ích và tầm nhìn của hệ thống.')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="text-sm breadcrumbs mb-6">
            <ul class="flex items-center space-x-2 text-base-content/60">
                <li><a href="{{ route('home') }}" class="hover:text-primary">Trang chủ</a></li>
                <li>/</li>
                <li class="text-base-content/60">Giới thiệu</li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="max-w-6xl mx-auto">
            <div class="rounded-xl border p-8 md:p-12" style="background-color: #fafaf8; border-color: #d4d0c8;">
                <h1 class="text-2xl md:text-4xl font-bold mb-6 text-center xl:mx-28" style="color: #2b2b2b;">
                    HỆ THỐNG TRA CỨU THÔNG TIN LIỆT SĨ XÃ LÝ NHÂN TRỰC TUYẾN
                </h1>
                <p class="text-xl text-gray-600 text-center mb-8">
                    Tra cứu thông tin liệt sĩ nhanh chóng, chính xác và tiện lợi
                </p>

                <div class="prose prose-lg max-w-none">
                    <p class="text-lg leading-relaxed mb-6" style="color: #2b2b2b;">
                        Hệ thống Tra cứu thông tin liệt sĩ tỉnh Ninh Bình là nền tảng trực tuyến giúp người dân dễ dàng tra
                        cứu thông tin liệt sĩ, xác định vị trí an táng và quản lý dữ liệu nghĩa trang một cách
                        khoa học, minh bạch và hiện đại. Với công nghệ bản đồ số tiên tiến, người dùng có thể tìm kiếm thông
                        tin chính xác chỉ bằng vài thao tác đơn giản.
                    </p>

                    <h2 class="text-3xl font-bold mb-6" style="color: #3b82f6;">Giới thiệu hệ thống</h2>
                    <p class="text-lg leading-relaxed mb-6" style="color: #2b2b2b;">
                        Hệ thống được xây dựng nhằm số hóa dữ liệu nghĩa địa, phục vụ công tác quản lý, tra cứu và bảo tồn
                        thông tin người đã khuất. Đây là giải pháp tối ưu cho các địa phương, ban quản lý nghĩa trang, cũng
                        như thân nhân có nhu cầu tìm kiếm và cập nhật thông tin mộ phần.
                    </p>

                    <h2 class="text-3xl font-bold mb-6" style="color: #3b82f6;">Tính năng nổi bật</h2>
                    <ul class="list-disc list-inside text-lg leading-relaxed mb-6 space-y-2" style="color: #2b2b2b;">
                        <li>Tra cứu thông tin người đã khuất: Nhập tên, năm sinh, năm mất hoặc khu vực chôn cất để tìm kiếm
                            dễ dàng.</li>
                        <li>Xác định vị trí mộ liệt sĩ trên bản đồ số: Hỗ trợ định vị nhanh chóng, chính xác.</li>
                        <li>Quản lý dữ liệu nghĩa trang: Cập nhật, chỉnh sửa thông tin mộ phần, phân khu, hàng, lô dễ dàng.
                        </li>
                        <li>Tích hợp hình ảnh và hồ sơ điện tử: Giúp lưu trữ và bảo tồn thông tin lâu dài.</li>
                        <li>Báo cáo thống kê thông minh: Hỗ trợ cơ quan quản lý tổng hợp số liệu và lập kế hoạch hiệu quả.
                        </li>
                    </ul>

                    <h2 class="text-3xl font-bold mb-6" style="color: #3b82f6;">Lợi ích mang lại</h2>
                    <ul class="list-disc list-inside text-lg leading-relaxed mb-6 space-y-2" style="color: #2b2b2b;">
                        <li>Đối với người dân: Dễ dàng tìm kiếm thông tin người thân mà không cần đến trực tiếp nghĩa trang.
                        </li>
                        <li>Đối với ban quản lý nghĩa trang: Tiết kiệm thời gian, giảm sai sót và quản lý tập trung, chuyên
                            nghiệp.</li>
                        <li>Đối với chính quyền địa phương: Góp phần vào công cuộc chuyển đổi số, nâng cao hiệu quả quản lý
                            dân cư và di sản văn hóa tâm linh.</li>
                    </ul>

                    <h2 class="text-3xl font-bold mb-6" style="color: #3b82f6;">Tầm nhìn và sứ mệnh</h2>
                    <p class="text-lg leading-relaxed mb-6" style="color: #2b2b2b;">
                        Chúng tôi hướng tới mục tiêu xây dựng hệ thống tra cứu và quản lý nghĩa địa toàn diện, góp phần gìn
                        giữ giá trị văn hóa truyền thống và tạo thuận tiện cho người dân trong hành trình tưởng nhớ tổ tiên.
                    </p>

                    <h2 class="text-3xl font-bold mb-6" style="color: #3b82f6;">Liên hệ</h2>
                    <p class="text-lg leading-relaxed mb-6" style="color: #2b2b2b;">
                        Mọi thắc mắc về hệ thống, vui lòng liên hệ với chúng tôi qua thông tin dưới đây:
                    </p>
                    <ul class="list-disc list-inside text-lg leading-relaxed" style="color: #2b2b2b;">
                        <li>📍 Địa chỉ: xã Lý Nhân, Ninh Bình, Việt Nam</li>
                        <li>📞 Hotline: 0123 456 789</li>
                        <li>🌐 Website: <a class="btn btn-link" href="http://tracuuthongtinlietsy.poly-hna.com">Tra cứu thông tin liệt sỹ</a>
                        </li>
                        <li>✉️ Email: tracuuthongtinlietsy@poly-hna.com</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" class="btn btn-outline">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Quay lại trang chủ
            </a>
        </div>
    </div>
@endsection
