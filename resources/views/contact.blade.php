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

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Information -->
            <div class="space-y-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Thông Tin Liên Hệ</h2>

                    <!-- Contact Cards -->
                    <div class="space-y-6">
                        <!-- Phone -->
                        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-600">
                            <div class="flex items-start gap-4">
                                <div class="bg-red-100 p-3 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="h-6 w-6 text-red-600">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Hotline 24/7</h3>
                                    <p class="text-gray-600 mb-1">1900-xxxx</p>
                                    <p class="text-sm text-gray-500">Hỗ trợ tra cứu và tư vấn 24/7</p>
                                </div>
                            </div>
                        </div>

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
                                    <p class="text-gray-600 mb-1">contact@example.com</p>
                                    <p class="text-sm text-gray-500">Phản hồi trong vòng 24 giờ</p>
                                </div>
                            </div>
                        </div>

                        <!-- Address -->
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
                                    <p class="text-gray-600 mb-1">Số 123, Đường ABC, Phường XYZ</p>
                                    <p class="text-gray-600 mb-1">Thành phố Ninh Bình, Tỉnh Ninh Bình</p>
                                    <p class="text-sm text-gray-500">Giờ làm việc: 8:00 - 17:00 (T2-T6)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Working Hours -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Giờ Làm Việc</h3>
                    <div class="space-y-2 text-gray-600">
                        <div class="flex justify-between">
                            <span>Thứ 2 - Thứ 6:</span>
                            <span class="font-medium">8:00 - 17:00</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Thứ 7:</span>
                            <span class="font-medium">8:00 - 12:00</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Chủ nhật:</span>
                            <span class="font-medium text-red-600">Nghỉ</span>
                        </div>
                        <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                            <p class="text-sm text-blue-800">
                                <strong>Lưu ý:</strong> Hotline hỗ trợ 24/7 cho các trường hợp khẩn cấp và tra cứu thông
                                tin.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Gửi Tin Nhắn</h2>
                <form class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Họ và tên *</label>
                            <input type="text" id="name" name="name" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                                placeholder="Nhập họ và tên của bạn">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại
                                *</label>
                            <input type="tel" id="phone" name="phone" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                                placeholder="Nhập số điện thoại">
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="email" name="email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                            placeholder="Nhập địa chỉ email">
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Chủ đề *</label>
                        <select id="subject" name="subject" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                            <option value="">Chọn chủ đề</option>
                            <option value="tra_cuu">Tra cứu thông tin liệt sĩ</option>
                            <option value="sua_doi">Yêu cầu sửa đổi thông tin</option>
                            <option value="ho_tro">Hỗ trợ kỹ thuật</option>
                            <option value="khac">Khác</option>
                        </select>
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Nội dung tin nhắn
                            *</label>
                        <textarea id="message" name="message" rows="5" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors resize-none"
                            placeholder="Nhập nội dung tin nhắn của bạn..."></textarea>
                    </div>

                    <div class="flex items-start gap-3">
                        <input type="checkbox" id="privacy" name="privacy" required
                            class="mt-1 h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                        <label for="privacy" class="text-sm text-gray-600">
                            Tôi đồng ý với <a href="#" class="text-red-600 hover:underline">chính sách bảo mật</a>
                            và
                            <a href="#" class="text-red-600 hover:underline">điều khoản sử dụng</a> của hệ thống.
                        </label>
                    </div>

                    <button type="submit"
                        class="w-full bg-red-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-red-700 focus:ring-4 focus:ring-red-200 transition-all duration-200">
                        Gửi Tin Nhắn
                    </button>
                </form>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="mt-16">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Câu Hỏi Thường Gặp</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Làm thế nào để tra cứu thông tin liệt sĩ?</h3>
                    <p class="text-gray-600">
                        Bạn có thể sử dụng chức năng tìm kiếm trên trang chủ, nhập tên, số lăng mộ hoặc các thông tin khác
                        để tra cứu.
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Tôi có thể yêu cầu sửa đổi thông tin không?</h3>
                    <p class="text-gray-600">
                        Có, bạn có thể gửi yêu cầu sửa đổi thông tin thông qua form liên hệ hoặc trực tiếp tại văn phòng.
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Thông tin có được bảo mật không?</h3>
                    <p class="text-gray-600">
                        Tất cả thông tin được bảo mật theo quy định của pháp luật và chỉ được sử dụng cho mục đích tra cứu
                        chính đáng.
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Tôi có thể liên hệ ngoài giờ làm việc không?</h3>
                    <p class="text-gray-600">
                        Hotline 24/7 luôn sẵn sàng hỗ trợ bạn. Email sẽ được phản hồi trong vòng 24 giờ.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
