<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing admin users
        $admins = User::whereIn('role', ['admin', 'super_admin'])->get();

        if ($admins->isEmpty()) {
            // Create a default admin if none exists
            $admin = User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'role' => 'super_admin',
            ]);
            $admins = collect([$admin]);
        }

        // Create articles with specific content for cemetery management system
        $articles = [
            // Tin tức
            [
                'title' => 'Hướng dẫn đăng ký mộ phần tại nghĩa trang Ninh Bình',
                'slug' => 'huong-dan-dang-ky-mo-phan-tai-nghia-trang-ninh-binh',
                'content' => '<h2>Quy trình đăng ký mộ phần</h2><p>Để đăng ký mộ phần tại các nghĩa trang trong tỉnh Ninh Bình, quý khách cần thực hiện các bước sau:</p><ol><li>Chuẩn bị giấy tờ tùy thân</li><li>Đến trực tiếp nghĩa trang hoặc liên hệ qua hotline</li><li>Điền đơn đăng ký</li><li>Thanh toán phí dịch vụ</li></ol><p>Thời gian xử lý: 3-5 ngày làm việc.</p>',
                'featured_image' => 'https://picsum.photos/800/600?random=1',
                'status' => 'published',
                'category' => 'tin_tuc',
            ],
            [
                'title' => 'Thông báo về việc nâng cấp hệ thống quản lý nghĩa trang',
                'slug' => 'thong-bao-nang-cap-he-thong-quan-ly-nghia-trang',
                'content' => '<h2>Nâng cấp hệ thống</h2><p>Hệ thống quản lý nghĩa trang đã được nâng cấp với nhiều tính năng mới:</p><ul><li>Tra cứu thông tin mộ phần online</li><li>Đăng ký dịch vụ chăm sóc mộ</li><li>Thanh toán trực tuyến</li><li>Thông báo nhắc nhở</li></ul><p>Hệ thống sẽ hoạt động 24/7 để phục vụ người dân.</p>',
                'featured_image' => 'https://picsum.photos/800/600?random=2',
                'status' => 'published',
                'category' => 'thong_bao',
            ],
            [
                'title' => 'Hướng dẫn chăm sóc mộ phần đúng cách',
                'slug' => 'huong-dan-cham-soc-mo-phan-dung-cach',
                'content' => '<h2>Cách chăm sóc mộ phần</h2><p>Việc chăm sóc mộ phần cần được thực hiện đúng cách để đảm bảo vệ sinh và tôn trọng:</p><h3>Những việc nên làm:</h3><ul><li>Dọn dẹp rác thải xung quanh</li><li>Thay hoa tươi thường xuyên</li><li>Kiểm tra tình trạng mộ</li><li>Đốt hương đúng nơi quy định</li></ul><h3>Những việc không nên làm:</h3><ul><li>Vứt rác bừa bãi</li><li>Đốt vàng mã không đúng nơi</li><li>Làm ồn ào</li><li>Xâm phạm mộ khác</li></ul>',
                'featured_image' => 'https://picsum.photos/800/600?random=3',
                'status' => 'published',
                'category' => 'huong_dan',
            ],
            [
                'title' => 'Danh sách nghĩa trang trong tỉnh Ninh Bình',
                'slug' => 'danh-sach-nghia-trang-trong-tinh-ninh-binh',
                'content' => '<h2>Các nghĩa trang trong tỉnh</h2><p>Tỉnh Ninh Bình có nhiều nghĩa trang được quản lý chuyên nghiệp:</p><h3>Thành phố Ninh Bình:</h3><ul><li>Nghĩa trang Phúc Lộc</li><li>Nghĩa trang An Bình</li><li>Nghĩa trang Hòa Bình</li></ul><h3>Huyện Gia Viễn:</h3><ul><li>Nghĩa trang Gia Viễn</li><li>Nghĩa trang Đại Hoàng</li></ul><h3>Huyện Nho Quan:</h3><ul><li>Nghĩa trang Nho Quan</li><li>Nghĩa trang Cúc Phương</li></ul><p>Mỗi nghĩa trang đều có dịch vụ chăm sóc mộ phần chuyên nghiệp.</p>',
                'featured_image' => 'https://picsum.photos/800/600?random=4',
                'status' => 'published',
                'category' => 'tin_tuc',
            ],
            [
                'title' => 'Quy định về việc an táng tại nghĩa trang',
                'slug' => 'quy-dinh-ve-viec-an-tang-tai-nghia-trang',
                'content' => '<h2>Quy định an táng</h2><p>Để đảm bảo trật tự và vệ sinh môi trường, nghĩa trang có các quy định sau:</p><h3>Thời gian an táng:</h3><ul><li>Thứ 2 - Thứ 6: 7:00 - 17:00</li><li>Thứ 7: 7:00 - 12:00</li><li>Chủ nhật: Không tổ chức an táng</li></ul><h3>Quy định về xe cộ:</h3><ul><li>Xe tang chỉ được vào trong giờ quy định</li><li>Không được đậu xe lâu tại nghĩa trang</li><li>Tuân thủ hướng dẫn của bảo vệ</li></ul><h3>Quy định về vệ sinh:</h3><ul><li>Không vứt rác bừa bãi</li><li>Đốt vàng mã đúng nơi quy định</li><li>Giữ gìn vệ sinh chung</li></ul>',
                'featured_image' => 'https://picsum.photos/800/600?random=5',
                'status' => 'published',
                'category' => 'huong_dan',
            ],
            [
                'title' => 'Thông báo nghỉ lễ Tết Nguyên Đán 2025',
                'slug' => 'thong-bao-nghi-le-tet-nguyen-dan-2025',
                'content' => '<h2>Lịch nghỉ lễ Tết</h2><p>Nghĩa trang sẽ nghỉ lễ Tết Nguyên Đán từ ngày 28/12/2024 đến hết ngày 05/01/2025 (âm lịch).</p><h3>Lịch hoạt động:</h3><ul><li>28/12 - 05/01: Nghỉ lễ hoàn toàn</li><li>06/01: Hoạt động bình thường</li></ul><h3>Dịch vụ khẩn cấp:</h3><p>Trong thời gian nghỉ lễ, vẫn có dịch vụ khẩn cấp 24/7. Liên hệ hotline: 1900-xxxx để được hỗ trợ.</p><p>Chúc quý khách một năm mới an lành và hạnh phúc!</p>',
                'featured_image' => 'https://picsum.photos/800/600?random=6',
                'status' => 'published',
                'category' => 'thong_bao',
            ],
        ];

        foreach ($articles as $articleData) {
            Article::create($articleData);
        }

        // Create additional random articles
        Article::factory()
            ->count(10)
            ->published()
            ->create();

        // Create some draft articles
        Article::factory()
            ->count(3)
            ->create([
                'status' => 'draft',
            ]);
    }
}
