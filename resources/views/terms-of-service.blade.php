@extends('layouts.app')

@section('title', 'Điều khoản sử dụng - Hệ thống Tra cứu liệt sĩ tỉnh Ninh Bình')
@section('description', 'Điều khoản sử dụng dịch vụ hệ thống tra cứu liệt sĩ tỉnh Ninh Bình. Quy định về quyền và nghĩa vụ của người dùng khi sử dụng dịch vụ.')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Section -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Điều Khoản Sử Dụng</h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Quy định về quyền và nghĩa vụ khi sử dụng hệ thống tra cứu liệt sĩ tỉnh Ninh Bình.
        </p>
        <p class="text-sm text-gray-500 mt-4">Cập nhật lần cuối: {{ date('d/m/Y') }}</p>
    </div>

    <!-- Table of Contents -->
    <div class="bg-blue-50 rounded-lg p-6 mb-12">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Mục Lục</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <ul class="space-y-2 text-sm text-gray-600">
                <li><a href="#acceptance" class="hover:text-blue-600">1. Chấp nhận điều khoản</a></li>
                <li><a href="#service-description" class="hover:text-blue-600">2. Mô tả dịch vụ</a></li>
                <li><a href="#user-responsibilities" class="hover:text-blue-600">3. Trách nhiệm người dùng</a></li>
                <li><a href="#prohibited-uses" class="hover:text-blue-600">4. Sử dụng bị cấm</a></li>
            </ul>
            <ul class="space-y-2 text-sm text-gray-600">
                <li><a href="#intellectual-property" class="hover:text-blue-600">5. Sở hữu trí tuệ</a></li>
                <li><a href="#limitations" class="hover:text-blue-600">6. Giới hạn trách nhiệm</a></li>
                <li><a href="#termination" class="hover:text-blue-600">7. Chấm dứt dịch vụ</a></li>
                <li><a href="#governing-law" class="hover:text-blue-600">8. Luật áp dụng</a></li>
            </ul>
        </div>
    </div>

    <!-- Acceptance -->
    <section id="acceptance" class="mb-12">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">1. Chấp Nhận Điều Khoản</h2>
            
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Bằng việc sử dụng dịch vụ, bạn đồng ý:</h3>
                    <div class="bg-green-50 border-l-4 border-green-400 p-4">
                        <ul class="text-sm text-green-800 space-y-1">
                            <li>• Tuân thủ tất cả các điều khoản và điều kiện được nêu trong tài liệu này</li>
                            <li>• Chấp nhận các quy định về bảo mật thông tin</li>
                            <li>• Đồng ý với việc thu thập và sử dụng thông tin theo chính sách bảo mật</li>
                            <li>• Chịu trách nhiệm về các hành vi của mình khi sử dụng dịch vụ</li>
                        </ul>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Nếu bạn không đồng ý</h3>
                    <div class="bg-red-50 border-l-4 border-red-400 p-4">
                        <p class="text-sm text-red-800">
                            Nếu bạn không đồng ý với bất kỳ điều khoản nào, vui lòng không sử dụng dịch vụ của chúng tôi. 
                            Việc tiếp tục sử dụng được coi là bạn đã chấp nhận toàn bộ các điều khoản.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Description -->
    <section id="service-description" class="mb-12">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">2. Mô Tả Dịch Vụ</h2>
            
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Dịch vụ chúng tôi cung cấp</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-blue-50 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">🔍 Tra cứu thông tin</h4>
                            <p class="text-sm text-gray-600">Tìm kiếm và xem thông tin về lăng mộ, người đã khuất</p>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">📝 Yêu cầu sửa đổi</h4>
                            <p class="text-sm text-gray-600">Gửi yêu cầu cập nhật thông tin không chính xác</p>
                        </div>
                        <div class="bg-orange-50 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">📞 Hỗ trợ khách hàng</h4>
                            <p class="text-sm text-gray-600">Tư vấn và hỗ trợ sử dụng dịch vụ</p>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">📰 Tin tức</h4>
                            <p class="text-sm text-gray-600">Cập nhật thông tin và tin tức liên quan</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Phạm vi dịch vụ</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <ul class="text-sm text-gray-700 space-y-1">
                            <li>• Dịch vụ chỉ dành cho mục đích tra cứu thông tin công khai</li>
                            <li>• Không cung cấp dịch vụ thương mại hoặc lợi nhuận</li>
                            <li>• Thông tin được cung cấp dựa trên dữ liệu có sẵn</li>
                            <li>• Chúng tôi không đảm bảo tính chính xác 100% của tất cả thông tin</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- User Responsibilities -->
    <section id="user-responsibilities" class="mb-12">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">3. Trách Nhiệm Người Dùng</h2>
            
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Bạn có trách nhiệm</h3>
                    <div class="space-y-4">
                        <div class="border-l-4 border-blue-500 pl-4">
                            <h4 class="font-semibold text-gray-800">Sử dụng hợp pháp</h4>
                            <p class="text-gray-600 text-sm">Chỉ sử dụng dịch vụ cho mục đích hợp pháp và không vi phạm pháp luật</p>
                        </div>
                        <div class="border-l-4 border-green-500 pl-4">
                            <h4 class="font-semibold text-gray-800">Bảo vệ thông tin</h4>
                            <p class="text-gray-600 text-sm">Không chia sẻ thông tin cá nhân của người khác mà không được phép</p>
                        </div>
                        <div class="border-l-4 border-orange-500 pl-4">
                            <h4 class="font-semibold text-gray-800">Báo cáo sai phạm</h4>
                            <p class="text-gray-600 text-sm">Thông báo ngay khi phát hiện thông tin không chính xác hoặc vi phạm</p>
                        </div>
                        <div class="border-l-4 border-purple-500 pl-4">
                            <h4 class="font-semibold text-gray-800">Tuân thủ quy định</h4>
                            <p class="text-gray-600 text-sm">Chấp hành tất cả các quy định và hướng dẫn sử dụng</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Cam kết của bạn</h3>
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                        <ul class="text-sm text-yellow-800 space-y-1">
                            <li>• Sử dụng thông tin một cách có trách nhiệm và tôn trọng</li>
                            <li>• Không sử dụng thông tin để làm tổn hại đến người khác</li>
                            <li>• Bảo vệ quyền riêng tư của người đã khuất và gia đình họ</li>
                            <li>• Thông báo ngay khi phát hiện lỗi hoặc vấn đề kỹ thuật</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Prohibited Uses -->
    <section id="prohibited-uses" class="mb-12">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">4. Sử Dụng Bị Cấm</h2>
            
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Các hành vi bị nghiêm cấm</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <h4 class="font-semibold text-red-800 mb-2">🚫 Sử dụng thương mại</h4>
                            <p class="text-sm text-red-700">Không được sử dụng thông tin cho mục đích thương mại</p>
                        </div>
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <h4 class="font-semibold text-red-800 mb-2">🚫 Lạm dụng hệ thống</h4>
                            <p class="text-sm text-red-700">Không được tấn công hoặc làm gián đoạn hệ thống</p>
                        </div>
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <h4 class="font-semibold text-red-800 mb-2">🚫 Vi phạm bản quyền</h4>
                            <p class="text-sm text-red-700">Không được sao chép hoặc phân phối trái phép</p>
                        </div>
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <h4 class="font-semibold text-red-800 mb-2">🚫 Xâm phạm quyền riêng tư</h4>
                            <p class="text-sm text-red-700">Không được sử dụng thông tin để làm tổn hại người khác</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Hậu quả vi phạm</h3>
                    <div class="bg-red-50 border-l-4 border-red-400 p-4">
                        <ul class="text-sm text-red-800 space-y-1">
                            <li>• Có thể bị chặn truy cập tạm thời hoặc vĩnh viễn</li>
                            <li>• Chịu trách nhiệm pháp lý theo quy định của pháp luật</li>
                            <li>• Bồi thường thiệt hại nếu gây ra tổn thất cho người khác</li>
                            <li>• Có thể bị truy cứu trách nhiệm hình sự trong trường hợp nghiêm trọng</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Intellectual Property -->
    <section id="intellectual-property" class="mb-12">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">5. Sở Hữu Trí Tuệ</h2>
            
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Quyền sở hữu</h3>
                    <div class="space-y-4">
                        <div class="bg-blue-50 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">🏛️ Thuộc về nhà nước</h4>
                            <p class="text-sm text-gray-600">Hệ thống và dữ liệu thuộc sở hữu của Ủy ban nhân dân tỉnh Ninh Bình</p>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">📋 Sử dụng có giới hạn</h4>
                            <p class="text-sm text-gray-600">Bạn được phép sử dụng thông tin cho mục đích cá nhân, phi thương mại</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Giới hạn sử dụng</h3>
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                        <ul class="text-sm text-yellow-800 space-y-1">
                            <li>• Không được sao chép, phân phối hoặc tạo ra các sản phẩm phái sinh</li>
                            <li>• Không được sử dụng cho mục đích thương mại mà không có sự đồng ý</li>
                            <li>• Phải ghi rõ nguồn gốc khi trích dẫn thông tin</li>
                            <li>• Tuân thủ các quy định về bản quyền và sở hữu trí tuệ</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Limitations -->
    <section id="limitations" class="mb-12">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">6. Giới Hạn Trách Nhiệm</h2>
            
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Chúng tôi không chịu trách nhiệm về</h3>
                    <div class="space-y-4">
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">⚠️ Tính chính xác của thông tin</h4>
                            <p class="text-sm text-gray-600">Mặc dù chúng tôi cố gắng đảm bảo tính chính xác, không thể đảm bảo 100% thông tin luôn đúng</p>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">⚠️ Gián đoạn dịch vụ</h4>
                            <p class="text-sm text-gray-600">Có thể xảy ra gián đoạn do bảo trì, cập nhật hoặc sự cố kỹ thuật</p>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">⚠️ Thiệt hại gián tiếp</h4>
                            <p class="text-sm text-gray-600">Không chịu trách nhiệm về các thiệt hại gián tiếp phát sinh từ việc sử dụng dịch vụ</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Cam kết của chúng tôi</h3>
                    <div class="bg-green-50 border-l-4 border-green-400 p-4">
                        <ul class="text-sm text-green-800 space-y-1">
                            <li>• Cố gắng duy trì dịch vụ ổn định và liên tục</li>
                            <li>• Cập nhật thông tin thường xuyên khi có thể</li>
                            <li>• Xử lý các yêu cầu sửa đổi trong thời gian hợp lý</li>
                            <li>• Bảo vệ thông tin cá nhân theo quy định pháp luật</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Termination -->
    <section id="termination" class="mb-12">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">7. Chấm Dứt Dịch Vụ</h2>
            
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Chúng tôi có quyền chấm dứt dịch vụ khi</h3>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="bg-red-100 rounded-full w-6 h-6 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="text-red-600 text-xs">1</span>
                            </div>
                            <p class="text-sm text-gray-600">Người dùng vi phạm các điều khoản sử dụng</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="bg-red-100 rounded-full w-6 h-6 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="text-red-600 text-xs">2</span>
                            </div>
                            <p class="text-sm text-gray-600">Có yêu cầu từ cơ quan có thẩm quyền</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="bg-red-100 rounded-full w-6 h-6 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="text-red-600 text-xs">3</span>
                            </div>
                            <p class="text-sm text-gray-600">Bảo trì hệ thống hoặc cập nhật dịch vụ</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="bg-red-100 rounded-full w-6 h-6 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="text-red-600 text-xs">4</span>
                            </div>
                            <p class="text-sm text-gray-600">Các trường hợp bất khả kháng</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Thông báo chấm dứt</h3>
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                        <p class="text-sm text-blue-800">
                            Chúng tôi sẽ thông báo trước ít nhất 30 ngày khi có kế hoạch chấm dứt dịch vụ, 
                            trừ các trường hợp khẩn cấp hoặc bất khả kháng.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Governing Law -->
    <section id="governing-law" class="mb-12">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">8. Luật Áp Dụng</h2>
            
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Pháp luật điều chỉnh</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <ul class="text-sm text-gray-700 space-y-1">
                            <li>• Luật An toàn thông tin mạng</li>
                            <li>• Luật Bảo vệ dữ liệu cá nhân</li>
                            <li>• Các quy định của Chính phủ về dịch vụ công trực tuyến</li>
                            <li>• Quy định của Ủy ban nhân dân tỉnh Ninh Bình</li>
                        </ul>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Giải quyết tranh chấp</h3>
                    <div class="space-y-4">
                        <div class="border-l-4 border-green-500 pl-4">
                            <h4 class="font-semibold text-gray-800">Thương lượng</h4>
                            <p class="text-gray-600 text-sm">Ưu tiên giải quyết thông qua thương lượng và hòa giải</p>
                        </div>
                        <div class="border-l-4 border-blue-500 pl-4">
                            <h4 class="font-semibold text-gray-800">Tòa án</h4>
                            <p class="text-gray-600 text-sm">Tranh chấp sẽ được giải quyết tại Tòa án có thẩm quyền tại Ninh Bình</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Information -->
    <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-lg p-8 text-white text-center">
        <h2 class="text-2xl font-bold mb-4">Có Câu Hỏi Về Điều Khoản?</h2>
        <p class="text-lg mb-6">Nếu bạn cần làm rõ bất kỳ điều khoản nào, vui lòng liên hệ với chúng tôi.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('contact') }}" class="bg-white text-red-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                Liên Hệ Hỗ Trợ
            </a>
            <a href="{{ route('privacy-policy') }}" class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-red-600 transition-colors">
                Chính Sách Bảo Mật
            </a>
        </div>
    </div>
</div>
@endsection
