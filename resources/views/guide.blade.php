@extends('layouts.app')

@section('title', 'Hướng dẫn sử dụng - Hệ thống Tra cứu liệt sĩ tỉnh Ninh Bình')
@section('description', 'Hướng dẫn chi tiết cách sử dụng hệ thống tra cứu liệt sĩ tỉnh Ninh Bình. Tìm hiểu cách tìm
    kiếm, tra cứu thông tin lăng mộ và các tính năng khác.')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Hướng Dẫn Sử Dụng</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Hướng dẫn chi tiết cách sử dụng hệ thống tra cứu liệt sĩ tỉnh Ninh Bình một cách hiệu quả và dễ dàng.
            </p>
        </div>

        <!-- Table of Contents -->
        <div class="bg-blue-50 rounded-lg p-6 mb-12">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Mục Lục</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="font-semibold text-gray-800 mb-2">Cơ bản</h3>
                    <ul class="space-y-1 text-sm text-gray-600">
                        <li><a href="#getting-started" class="hover:text-blue-600">Bắt đầu sử dụng</a></li>
                        <li><a href="#search-basics" class="hover:text-blue-600">Tìm kiếm cơ bản</a></li>
                        <li><a href="#viewing-results" class="hover:text-blue-600">Xem kết quả</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 mb-2">Nâng cao</h3>
                    <ul class="space-y-1 text-sm text-gray-600">
                        <li><a href="#advanced-search" class="hover:text-blue-600">Tìm kiếm nâng cao</a></li>
                        <li><a href="#filters" class="hover:text-blue-600">Bộ lọc</a></li>
                        <li><a href="#modification-request" class="hover:text-blue-600">Yêu cầu sửa đổi</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Getting Started -->
        <section id="getting-started" class="mb-12">
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">1. Bắt Đầu Sử Dụng</h2>

                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Truy cập hệ thống</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <ol class="list-decimal list-inside space-y-2 text-gray-700">
                                <li>Mở trình duyệt web và truy cập địa chỉ website</li>
                                <li>Trên trang chủ, bạn sẽ thấy form tìm kiếm chính</li>
                                <li>Click vào menu "Danh Sách Liệt Sĩ" để truy cập trang tìm kiếm chi tiết</li>
                            </ol>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Giao diện chính</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-red-50 rounded-lg p-4 text-center">
                                <div class="text-2xl mb-2">🏠</div>
                                <h4 class="font-semibold text-gray-800">Trang Chủ</h4>
                                <p class="text-sm text-gray-600">Tổng quan và tìm kiếm nhanh</p>
                            </div>
                            <div class="bg-blue-50 rounded-lg p-4 text-center">
                                <div class="text-2xl mb-2">🔍</div>
                                <h4 class="font-semibold text-gray-800">Tìm Kiếm</h4>
                                <p class="text-sm text-gray-600">Tra cứu chi tiết</p>
                            </div>
                            <div class="bg-green-50 rounded-lg p-4 text-center">
                                <div class="text-2xl mb-2">📞</div>
                                <h4 class="font-semibold text-gray-800">Liên Hệ</h4>
                                <p class="text-sm text-gray-600">Hỗ trợ và tư vấn</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Search Basics -->
        <section id="search-basics" class="mb-12">
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">2. Tìm Kiếm Cơ Bản</h2>

                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Các cách tìm kiếm</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-800 mb-2">🔢 Theo số lăng mộ</h4>
                                <p class="text-sm text-gray-600 mb-2">Nhập số lăng mộ chính xác hoặc một phần</p>
                                <div class="bg-gray-100 rounded p-2 text-sm font-mono">Ví dụ: A001, B123, C456</div>
                            </div>
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-800 mb-2">👤 Theo tên chủ lăng mộ</h4>
                                <p class="text-sm text-gray-600 mb-2">Nhập họ tên người sở hữu lăng mộ</p>
                                <div class="bg-gray-100 rounded p-2 text-sm font-mono">Ví dụ: Nguyễn Văn A</div>
                            </div>
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-800 mb-2">🕊️ Theo tên người đã khuất</h4>
                                <p class="text-sm text-gray-600 mb-2">Nhập họ tên người đã khuất</p>
                                <div class="bg-gray-100 rounded p-2 text-sm font-mono">Ví dụ: Trần Thị B</div>
                            </div>
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-800 mb-2">📍 Theo địa điểm</h4>
                                <p class="text-sm text-gray-600 mb-2">Chọn huyện, xã hoặc nghĩa trang</p>
                                <div class="bg-gray-100 rounded p-2 text-sm font-mono">Ví dụ: Huyện A, Xã B</div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Mẹo tìm kiếm hiệu quả</h3>
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <ul class="text-sm text-yellow-800 space-y-1">
                                        <li>• Sử dụng từ khóa ngắn gọn, chính xác</li>
                                        <li>• Thử tìm kiếm với họ hoặc tên riêng</li>
                                        <li>• Kiểm tra chính tả nếu không tìm thấy kết quả</li>
                                        <li>• Kết hợp nhiều tiêu chí để thu hẹp kết quả</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Viewing Results -->
        <section id="viewing-results" class="mb-12">
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">3. Xem Kết Quả Tìm Kiếm</h2>

                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Thông tin hiển thị</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="flex items-start gap-3">
                                    <div class="bg-blue-100 p-2 rounded-full">
                                        <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Thông tin lăng mộ</h4>
                                        <p class="text-sm text-gray-600">Số lăng mộ, vị trí, trạng thái</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="bg-green-100 p-2 rounded-full">
                                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Thông tin chủ lăng mộ</h4>
                                        <p class="text-sm text-gray-600">Họ tên, địa chỉ, liên hệ</p>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-start gap-3">
                                    <div class="bg-purple-100 p-2 rounded-full">
                                        <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Thông tin người đã khuất</h4>
                                        <p class="text-sm text-gray-600">Họ tên, ngày sinh, ngày mất</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="bg-orange-100 p-2 rounded-full">
                                        <svg class="h-5 w-5 text-orange-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Vị trí nghĩa trang</h4>
                                        <p class="text-sm text-gray-600">Tên nghĩa trang, địa chỉ</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Các thao tác với kết quả</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="text-center">
                                    <div
                                        class="bg-blue-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-2">
                                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-800">Xem chi tiết</h4>
                                    <p class="text-sm text-gray-600">Click để xem thông tin đầy đủ</p>
                                </div>
                                <div class="text-center">
                                    <div
                                        class="bg-green-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-2">
                                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-800">Chia sẻ</h4>
                                    <p class="text-sm text-gray-600">Chia sẻ thông tin với người khác</p>
                                </div>
                                <div class="text-center">
                                    <div
                                        class="bg-orange-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-2">
                                        <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-800">Yêu cầu sửa đổi</h4>
                                    <p class="text-sm text-gray-600">Gửi yêu cầu cập nhật thông tin</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Advanced Search -->
        <section id="advanced-search" class="mb-12">
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">4. Tìm Kiếm Nâng Cao</h2>

                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Bộ lọc nâng cao</h3>
                        <div class="bg-blue-50 rounded-lg p-4">
                            <p class="text-sm text-blue-800 mb-3">Sử dụng nhiều tiêu chí cùng lúc để tìm kiếm chính xác
                                hơn:</p>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li>• Kết hợp tên + địa điểm</li>
                                <li>• Lọc theo nghĩa trang cụ thể</li>
                                <li>• Tìm kiếm theo khoảng thời gian</li>
                                <li>• Sắp xếp kết quả theo tiêu chí</li>
                            </ul>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Các trường hợp sử dụng</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-800 mb-2">🔍 Tìm kiếm theo gia đình</h4>
                                <p class="text-sm text-gray-600">Tìm tất cả lăng mộ của một gia đình trong cùng nghĩa trang
                                </p>
                            </div>
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-800 mb-2">📍 Tìm kiếm theo khu vực</h4>
                                <p class="text-sm text-gray-600">Xem tất cả lăng mộ trong một khu vực cụ thể</p>
                            </div>
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-800 mb-2">📅 Tìm kiếm theo thời gian</h4>
                                <p class="text-sm text-gray-600">Tìm lăng mộ được tạo trong khoảng thời gian nhất định</p>
                            </div>
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-800 mb-2">🏷️ Tìm kiếm theo trạng thái</h4>
                                <p class="text-sm text-gray-600">Lọc theo trạng thái sử dụng của lăng mộ</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modification Request -->
        <section id="modification-request" class="mb-12">
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">5. Yêu Cầu Sửa Đổi Thông Tin</h2>

                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Khi nào cần yêu cầu sửa đổi?</h3>
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                            <ul class="text-sm text-yellow-800 space-y-1">
                                <li>• Thông tin cá nhân thay đổi (địa chỉ, số điện thoại)</li>
                                <li>• Phát hiện thông tin không chính xác</li>
                                <li>• Cần cập nhật thông tin người đã khuất</li>
                                <li>• Thay đổi quyền sở hữu lăng mộ</li>
                            </ul>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Quy trình yêu cầu sửa đổi</h3>
                        <div class="space-y-4">
                            <div class="flex items-start gap-4">
                                <div
                                    class="bg-red-100 rounded-full w-8 h-8 flex items-center justify-center flex-shrink-0">
                                    <span class="text-red-600 font-bold">1</span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Tìm lăng mộ cần sửa đổi</h4>
                                    <p class="text-sm text-gray-600">Sử dụng chức năng tìm kiếm để định vị lăng mộ</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div
                                    class="bg-red-100 rounded-full w-8 h-8 flex items-center justify-center flex-shrink-0">
                                    <span class="text-red-600 font-bold">2</span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Click "Yêu cầu sửa đổi"</h4>
                                    <p class="text-sm text-gray-600">Tại trang chi tiết lăng mộ, click nút yêu cầu sửa đổi
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div
                                    class="bg-red-100 rounded-full w-8 h-8 flex items-center justify-center flex-shrink-0">
                                    <span class="text-red-600 font-bold">3</span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Điền thông tin yêu cầu</h4>
                                    <p class="text-sm text-gray-600">Điền đầy đủ thông tin và lý do yêu cầu sửa đổi</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div
                                    class="bg-red-100 rounded-full w-8 h-8 flex items-center justify-center flex-shrink-0">
                                    <span class="text-red-600 font-bold">4</span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Gửi yêu cầu</h4>
                                    <p class="text-sm text-gray-600">Hệ thống sẽ xử lý và phản hồi trong thời gian sớm nhất
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="mb-12">
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Câu Hỏi Thường Gặp</h2>

                <div class="space-y-6">
                    <div class="border-b border-gray-200 pb-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Tôi không tìm thấy lăng mộ của gia đình?</h3>
                        <p class="text-gray-600">Hãy thử các cách sau: kiểm tra chính tả, thử tìm kiếm với họ hoặc tên
                            riêng, liên hệ trực tiếp với chúng tôi để được hỗ trợ.</p>
                    </div>

                    <div class="border-b border-gray-200 pb-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Thông tin hiển thị có chính xác không?</h3>
                        <p class="text-gray-600">Chúng tôi cập nhật thông tin thường xuyên. Nếu phát hiện thông tin không
                            chính xác, vui lòng gửi yêu cầu sửa đổi.</p>
                    </div>

                    <div class="border-b border-gray-200 pb-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Tôi có thể in thông tin lăng mộ không?</h3>
                        <p class="text-gray-600">Có, bạn có thể sử dụng chức năng in của trình duyệt để in thông tin chi
                            tiết lăng mộ.</p>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Làm sao để liên hệ hỗ trợ?</h3>
                        <p class="text-gray-600">Bạn có thể liên hệ qua hotline 24/7, email hoặc đến trực tiếp văn phòng
                            trong giờ làm việc.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Support -->
        <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-lg p-8 text-white text-center">
            <h2 class="text-2xl font-bold mb-4">Cần Hỗ Trợ Thêm?</h2>
            <p class="text-lg mb-6">Nếu bạn cần hỗ trợ thêm hoặc có câu hỏi khác, đừng ngần ngại liên hệ với chúng tôi.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact') }}"
                    class="bg-white text-red-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    Liên Hệ Hỗ Trợ
                </a>
                <a href="{{ route('home') }}"
                    class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-red-600 transition-colors">
                    Về Trang Chủ
                </a>
            </div>
        </div>
    </div>
@endsection
