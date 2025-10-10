<?php

namespace Database\Seeders;

use App\Models\Cemetery;
use Illuminate\Database\Seeder;

class CemeterySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cemeteries = [
            // Thành phố Ninh Bình
            [
                'name' => 'Nghĩa trang Phúc Lộc',
                'district' => 'Thành phố Ninh Bình',
                'commune' => 'Phủ Lý',
                'address' => 'Xóm 5, Phường Phủ Lý, Thành phố Ninh Bình',
                'description' => 'Nghĩa trang công cộng lớn nhất thành phố Ninh Bình, được quản lý chuyên nghiệp với hệ thống hiện đại.',
            ],
            [
                'name' => 'Nghĩa trang An Bình',
                'district' => 'Thành phố Ninh Bình',
                'commune' => 'Liêm Tuyền',
                'address' => 'Xóm 3, Phường Liêm Tuyền, Thành phố Ninh Bình',
                'description' => 'Nghĩa trang với không gian xanh, thân thiện môi trường.',
            ],
            [
                'name' => 'Nghĩa trang Hòa Bình',
                'district' => 'Thành phố Ninh Bình',
                'commune' => 'Châu Sơn',
                'address' => 'Xóm 7, Phường Châu Sơn, Thành phố Ninh Bình',
                'description' => 'Nghĩa trang mới với thiết kế hiện đại, dịch vụ chăm sóc mộ phần chuyên nghiệp.',
            ],

            // Huyện Gia Viễn
            [
                'name' => 'Nghĩa trang Gia Viễn',
                'district' => 'Gia Viễn',
                'commune' => 'Gia Viễn',
                'address' => 'Xóm 2, Xã Gia Viễn, Huyện Gia Viễn',
                'description' => 'Nghĩa trang truyền thống với nhiều mộ phần có giá trị lịch sử.',
            ],
            [
                'name' => 'Nghĩa trang Đại Hoàng',
                'district' => 'Gia Viễn',
                'commune' => 'Đại Hoàng',
                'address' => 'Xóm 4, Xã Đại Hoàng, Huyện Gia Viễn',
                'description' => 'Nghĩa trang với không gian rộng rãi, phù hợp cho các gia đình lớn.',
            ],

            // Huyện Nho Quan
            [
                'name' => 'Nghĩa trang Nho Quan',
                'district' => 'Nho Quan',
                'commune' => 'Nho Quan',
                'address' => 'Xóm 1, Thị trấn Nho Quan, Huyện Nho Quan',
                'description' => 'Nghĩa trang trung tâm huyện với dịch vụ đầy đủ.',
            ],
            [
                'name' => 'Nghĩa trang Cúc Phương',
                'district' => 'Nho Quan',
                'commune' => 'Cúc Phương',
                'address' => 'Xóm 3, Xã Cúc Phương, Huyện Nho Quan',
                'description' => 'Nghĩa trang gần rừng quốc gia Cúc Phương, không gian yên tĩnh.',
            ],

            // Huyện Hoa Lư
            [
                'name' => 'Nghĩa trang Hoa Lư',
                'district' => 'Hoa Lư',
                'commune' => 'Hoa Lư',
                'address' => 'Xóm 2, Xã Hoa Lư, Huyện Hoa Lư',
                'description' => 'Nghĩa trang gần cố đô Hoa Lư, có giá trị lịch sử và văn hóa.',
            ],
            [
                'name' => 'Nghĩa trang Trường Yên',
                'district' => 'Hoa Lư',
                'commune' => 'Trường Yên',
                'address' => 'Xóm 5, Xã Trường Yên, Huyện Hoa Lư',
                'description' => 'Nghĩa trang với kiến trúc truyền thống, phù hợp với cảnh quan cố đô.',
            ],

            // Huyện Yên Khánh
            [
                'name' => 'Nghĩa trang Yên Khánh',
                'district' => 'Yên Khánh',
                'commune' => 'Yên Khánh',
                'address' => 'Xóm 3, Thị trấn Yên Khánh, Huyện Yên Khánh',
                'description' => 'Nghĩa trang hiện đại với hệ thống quản lý tiên tiến.',
            ],
            [
                'name' => 'Nghĩa trang Khánh Nhạc',
                'district' => 'Yên Khánh',
                'commune' => 'Khánh Nhạc',
                'address' => 'Xóm 1, Xã Khánh Nhạc, Huyện Yên Khánh',
                'description' => 'Nghĩa trang với không gian xanh, thân thiện môi trường.',
            ],

            // Huyện Yên Mô
            [
                'name' => 'Nghĩa trang Yên Mô',
                'district' => 'Yên Mô',
                'commune' => 'Yên Mô',
                'address' => 'Xóm 4, Thị trấn Yên Mô, Huyện Yên Mô',
                'description' => 'Nghĩa trang trung tâm huyện với dịch vụ chăm sóc mộ phần chuyên nghiệp.',
            ],

            // Huyện Kim Sơn
            [
                'name' => 'Nghĩa trang Kim Sơn',
                'district' => 'Kim Sơn',
                'commune' => 'Kim Sơn',
                'address' => 'Xóm 2, Thị trấn Kim Sơn, Huyện Kim Sơn',
                'description' => 'Nghĩa trang ven biển với không gian thoáng đãng.',
            ],
            [
                'name' => 'Nghĩa trang Phát Diệm',
                'district' => 'Kim Sơn',
                'commune' => 'Phát Diệm',
                'address' => 'Xóm 6, Xã Phát Diệm, Huyện Kim Sơn',
                'description' => 'Nghĩa trang gần nhà thờ Phát Diệm, có giá trị tôn giáo và lịch sử.',
            ],

            // Thành phố Tam Điệp
            [
                'name' => 'Nghĩa trang Tam Điệp',
                'district' => 'Thành phố Tam Điệp',
                'commune' => 'Tam Điệp',
                'address' => 'Xóm 3, Phường Tam Điệp, Thành phố Tam Điệp',
                'description' => 'Nghĩa trang thành phố với hệ thống quản lý hiện đại.',
            ],
        ];

        foreach ($cemeteries as $cemetery) {
            Cemetery::create($cemetery);
        }
    }
}
