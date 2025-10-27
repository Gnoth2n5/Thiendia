@extends('layouts.app')

@section('title', 'Chính sách bảo mật - Hệ thống Tra cứu liệt sĩ tỉnh Ninh Bình')
@section('description', 'Chính sách bảo mật thông tin của hệ thống tra cứu liệt sĩ tỉnh Ninh Bình. Cam kết bảo vệ thông tin cá nhân và dữ liệu người dùng.')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Section -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Chính Sách Bảo Mật</h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Chúng tôi cam kết bảo vệ thông tin cá nhân và dữ liệu của bạn khi sử dụng hệ thống tra cứu liệt sĩ tỉnh Ninh Bình.
        </p>
        <p class="text-sm text-gray-500 mt-4">Cập nhật lần cuối: {{ date('d/m/Y') }}</p>
    </div>

    <!-- Table of Contents -->
    <div class="bg-blue-50 rounded-lg p-6 mb-12">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Mục Lục</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <ul class="space-y-2 text-sm text-gray-600">
                <li><a href="#information-collection" class="hover:text-blue-600">1. Thu thập thông tin</a></li>
                <li><a href="#information-use" class="hover:text-blue-600">2. Sử dụng thông tin</a></li>
                <li><a href="#information-protection" class="hover:text-blue-600">3. Bảo vệ thông tin</a></li>
                <li><a href="#information-sharing" class="hover:text-blue-600">4. Chia sẻ thông tin</a></li>
            </ul>
            <ul class="space-y-2 text-sm text-gray-600">
                <li><a href="#user-rights" class="hover:text-blue-600">5. Quyền của người dùng</a></li>
                <li><a href="#cookies" class="hover:text-blue-600">6. Cookies</a></li>
                <li><a href="#policy-changes" class="hover:text-blue-600">7. Thay đổi chính sách</a></li>
                <li><a href="#contact" class="hover:text-blue-600">8. Liên hệ</a></li>
            </ul>
        </div>
    </div>

    <!-- Information Collection -->
    <section id="information-collection" class="mb-12">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">1. Thu Thập Thông Tin</h2>
            
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Thông tin chúng tôi thu thập</h3>
                    <div class="space-y-4">
                        <div class="border-l-4 border-blue-500 pl-4">
                            <h4 class="font-semibold text-gray-800">Thông tin công khai</h4>
                            <p class="text-gray-600 text-sm">Thông tin về lăng mộ, người đã khuất và chủ lăng mộ được hiển thị công khai để phục vụ mục đích tra cứu.</p>
                        </div>
                        <div class="border-l-4 border-green-500 pl-4">
                            <h4 class="font-semibold text-gray-800">Thông tin liên hệ</h4>
                            <p class="text-gray-600 text-sm">Khi bạn gửi yêu cầu sửa đổi hoặc liên hệ hỗ trợ, chúng tôi có thể thu thập tên, email, số điện thoại.</p>
                        </div>
                        <div class="border-l-4 border-orange-500 pl-4">
                            <h4 class="font-semibold text-gray-800">Thông tin kỹ thuật</h4>
                            <p class="text-gray-600 text-sm">Địa chỉ IP, loại trình duyệt, thời gian truy cập để cải thiện dịch vụ và bảo mật hệ thống.</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Mục đích thu thập</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <ul class="text-sm text-gray-700 space-y-2">
                            <li>• Cung cấp dịch vụ tra cứu thông tin lăng mộ</li>
                            <li>• Xử lý yêu cầu sửa đổi thông tin</li>
                            <li>• Cải thiện chất lượng dịch vụ</li>
                            <li>• Đảm bảo an ninh và bảo mật hệ thống</li>
                            <li>• Tuân thủ các quy định pháp luật</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Information Use -->
    <section id="information-use" class="mb-12">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">2. Sử Dụng Thông Tin</h2>
            
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Cách chúng tôi sử dụng thông tin</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-blue-50 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">🔍 Dịch vụ tra cứu</h4>
                            <p class="text-sm text-gray-600">Hiển thị thông tin lăng mộ để người dùng có thể tra cứu và tìm kiếm.</p>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">📝 Xử lý yêu cầu</h4>
                            <p class="text-sm text-gray-600">Xử lý các yêu cầu sửa đổi thông tin từ người dùng.</p>
                        </div>
                        <div class="bg-orange-50 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">📞 Hỗ trợ khách hàng</h4>
                            <p class="text-sm text-gray-600">Liên hệ và hỗ trợ người dùng khi cần thiết.</p>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">🛡️ Bảo mật hệ thống</h4>
                            <p class="text-sm text-gray-600">Giám sát và bảo vệ hệ thống khỏi các mối đe dọa.</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Nguyên tắc sử dụng</h3>
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                        <ul class="text-sm text-yellow-800 space-y-1">
                            <li>• Chỉ sử dụng thông tin cho mục đích đã được thông báo</li>
                            <li>• Không sử dụng thông tin cho mục đích thương mại</li>
                            <li>• Tuân thủ các quy định pháp luật về bảo vệ dữ liệu cá nhân</li>
                            <li>• Đảm bảo tính chính xác và cập nhật của thông tin</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Information Protection -->
    <section id="information-protection" class="mb-12">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">3. Bảo Vệ Thông Tin</h2>
            
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Biện pháp bảo mật</h3>
                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <div class="bg-green-100 rounded-full w-8 h-8 flex items-center justify-center flex-shrink-0">
                                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Mã hóa dữ liệu</h4>
                                <p class="text-sm text-gray-600">Tất cả dữ liệu được mã hóa khi truyền tải và lưu trữ</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="bg-blue-100 rounded-full w-8 h-8 flex items-center justify-center flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Kiểm soát truy cập</h4>
                                <p class="text-sm text-gray-600">Chỉ nhân viên được ủy quyền mới có thể truy cập dữ liệu nhạy cảm</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="bg-orange-100 rounded-full w-8 h-8 flex items-center justify-center flex-shrink-0">
                                <svg class="h-5 w-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Giám sát hệ thống</h4>
                                <p class="text-sm text-gray-600">Liên tục giám sát và phát hiện các hoạt động bất thường</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Cam kết bảo mật</h3>
                    <div class="bg-red-50 border-l-4 border-red-400 p-4">
                        <ul class="text-sm text-red-800 space-y-1">
                            <li>• Không bao giờ bán hoặc cho thuê thông tin cá nhân</li>
                            <li>• Không chia sẻ thông tin với bên thứ ba không được ủy quyền</li>
                            <li>• Thường xuyên cập nhật và cải thiện các biện pháp bảo mật</li>
                            <li>• Tuân thủ nghiêm ngặt các quy định pháp luật về bảo vệ dữ liệu</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Information Sharing -->
    <section id="information-sharing" class="mb-12">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">4. Chia Sẻ Thông Tin</h2>
            
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Khi nào chúng tôi chia sẻ thông tin</h3>
                    <div class="space-y-4">
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">✅ Với cơ quan nhà nước</h4>
                            <p class="text-sm text-gray-600">Khi có yêu cầu chính thức từ cơ quan có thẩm quyền theo quy định pháp luật.</p>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">✅ Với người thân</h4>
                            <p class="text-sm text-gray-600">Khi có yêu cầu hợp pháp từ người thân của người đã khuất.</p>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">✅ Với đối tác tin cậy</h4>
                            <p class="text-sm text-gray-600">Chỉ với các đối tác được ủy quyền và có cam kết bảo mật tương đương.</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Nguyên tắc chia sẻ</h3>
                    <div class="bg-blue-50 rounded-lg p-4">
                        <ul class="text-sm text-blue-800 space-y-1">
                            <li>• Chỉ chia sẻ khi có yêu cầu chính thức và hợp pháp</li>
                            <li>• Đảm bảo bên nhận có cam kết bảo mật tương đương</li>
                            <li>• Ghi nhận và lưu trữ tất cả các hoạt động chia sẻ thông tin</li>
                            <li>• Thông báo cho người dùng khi có thể</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- User Rights -->
    <section id="user-rights" class="mb-12">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">5. Quyền Của Người Dùng</h2>
            
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Quyền của bạn</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-green-50 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">👁️ Quyền truy cập</h4>
                            <p class="text-sm text-gray-600">Xem thông tin cá nhân của bạn được lưu trữ trong hệ thống</p>
                        </div>
                        <div class="bg-blue-50 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">✏️ Quyền sửa đổi</h4>
                            <p class="text-sm text-gray-600">Yêu cầu sửa đổi thông tin không chính xác</p>
                        </div>
                        <div class="bg-orange-50 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">🗑️ Quyền xóa</h4>
                            <p class="text-sm text-gray-600">Yêu cầu xóa thông tin cá nhân trong một số trường hợp</p>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">📋 Quyền khiếu nại</h4>
                            <p class="text-sm text-gray-600">Khiếu nại về việc xử lý thông tin cá nhân</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Cách thực hiện quyền</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <ol class="text-sm text-gray-700 space-y-2">
                            <li><strong>Liên hệ trực tiếp:</strong> Gọi hotline hoặc email để yêu cầu</li>
                            <li><strong>Gửi yêu cầu chính thức:</strong> Điền form yêu cầu với thông tin đầy đủ</li>
                            <li><strong>Xác minh danh tính:</strong> Cung cấp giấy tờ tùy thân để xác minh</li>
                            <li><strong>Thời gian xử lý:</strong> Chúng tôi sẽ phản hồi trong vòng 7-15 ngày làm việc</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Cookies -->
    <section id="cookies" class="mb-12">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">6. Cookies</h2>
            
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Chúng tôi sử dụng cookies để</h3>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="bg-blue-100 rounded-full w-6 h-6 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="text-blue-600 text-xs">1</span>
                            </div>
                            <p class="text-sm text-gray-600">Cải thiện trải nghiệm người dùng và ghi nhớ các tùy chọn</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="bg-blue-100 rounded-full w-6 h-6 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="text-blue-600 text-xs">2</span>
                            </div>
                            <p class="text-sm text-gray-600">Phân tích cách sử dụng website để cải thiện dịch vụ</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="bg-blue-100 rounded-full w-6 h-6 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="text-blue-600 text-xs">3</span>
                            </div>
                            <p class="text-sm text-gray-600">Đảm bảo bảo mật và ngăn chặn các hoạt động bất thường</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Quản lý cookies</h3>
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                        <p class="text-sm text-yellow-800">
                            Bạn có thể tắt cookies trong cài đặt trình duyệt, tuy nhiên điều này có thể ảnh hưởng đến một số chức năng của website.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Policy Changes -->
    <section id="policy-changes" class="mb-12">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">7. Thay Đổi Chính Sách</h2>
            
            <div class="space-y-4">
                <p class="text-gray-600">
                    Chúng tôi có thể cập nhật chính sách bảo mật này theo thời gian để phản ánh các thay đổi trong cách chúng tôi xử lý thông tin hoặc các yêu cầu pháp lý mới.
                </p>
                
                <div class="bg-blue-50 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-800 mb-2">Thông báo thay đổi</h4>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Thông báo trên website ít nhất 30 ngày trước khi có hiệu lực</li>
                        <li>• Gửi email thông báo cho người dùng đã đăng ký</li>
                        <li>• Cập nhật ngày "Cập nhật lần cuối" ở đầu trang</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact -->
    <section id="contact" class="mb-12">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">8. Liên Hệ</h2>
            
            <div class="space-y-6">
                <p class="text-gray-600">
                    Nếu bạn có câu hỏi về chính sách bảo mật này hoặc muốn thực hiện các quyền của mình, vui lòng liên hệ với chúng tôi:
                </p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-800 mb-2">📞 Hotline</h4>
                        <p class="text-gray-600">1900-xxxx (24/7)</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-800 mb-2">📧 Email</h4>
                        <p class="text-gray-600">privacy@ninhbinh-cemetery.gov.vn</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-800 mb-2">📍 Địa chỉ</h4>
                        <p class="text-gray-600">Số 123, Đường ABC, Phường XYZ<br>Thành phố Ninh Bình, Tỉnh Ninh Bình</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-800 mb-2">🕒 Giờ làm việc</h4>
                        <p class="text-gray-600">Thứ 2 - Thứ 6: 8:00 - 17:00<br>Thứ 7: 8:00 - 12:00</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Actions -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg p-8 text-white text-center">
        <h2 class="text-2xl font-bold mb-4">Có Câu Hỏi Khác?</h2>
        <p class="text-lg mb-6">Nếu bạn cần hỗ trợ thêm về chính sách bảo mật, đừng ngần ngại liên hệ với chúng tôi.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('contact') }}" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                Liên Hệ Hỗ Trợ
            </a>
            <a href="{{ route('terms-of-service') }}" class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                Điều Khoản Sử Dụng
            </a>
        </div>
    </div>
</div>
@endsection
