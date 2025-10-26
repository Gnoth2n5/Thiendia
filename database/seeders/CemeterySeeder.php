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
            [
                'name' => 'Nghĩa trang Phúc Lộc',
                'commune' => 'Phủ Lý',
                'address' => 'Xóm 5, Phường Phủ Lý, Thành phố Ninh Bình',
                'description' => 'Nghĩa trang công cộng lớn nhất thành phố Ninh Bình, được quản lý chuyên nghiệp với hệ thống hiện đại.',
            ],
            [
                'name' => 'Nghĩa trang An Bình',
                'commune' => 'Liêm Tuyền',
                'address' => 'Xóm 3, Phường Liêm Tuyền, Thành phố Ninh Bình',
                'description' => 'Nghĩa trang với không gian xanh, thân thiện môi trường.',
            ],
            [
                'name' => 'Nghĩa trang Hòa Bình',
                'commune' => 'Châu Sơn',
                'address' => 'Xóm 7, Phường Châu Sơn, Thành phố Ninh Bình',
                'description' => 'Nghĩa trang mới với thiết kế hiện đại, dịch vụ chăm sóc mộ phần chuyên nghiệp.',
            ],
            [
                'name' => 'Nghĩa trang Gia Viễn',
                'commune' => 'Gia Viễn',
                'address' => 'Xóm 2, Xã Gia Viễn, Huyện Gia Viễn',
                'description' => 'Nghĩa trang truyền thống với nhiều mộ phần có giá trị lịch sử.',
            ],
            [
                'name' => 'Nghĩa trang Đại Hoàng',
                'commune' => 'Đại Hoàng',
                'address' => 'Xóm 4, Xã Đại Hoàng, Huyện Gia Viễn',
                'description' => 'Nghĩa trang với không gian rộng rãi, phù hợp cho các gia đình lớn.',
            ],
            [
                'name' => 'Nghĩa trang Nho Quan',
                'commune' => 'Nho Quan',
                'address' => 'Xóm 1, Thị trấn Nho Quan, Huyện Nho Quan',
                'description' => 'Nghĩa trang trung tâm huyện với dịch vụ đầy đủ.',
            ],
            [
                'name' => 'Nghĩa trang Cúc Phương',
                'commune' => 'Cúc Phương',
                'address' => 'Xóm 3, Xã Cúc Phương, Huyện Nho Quan',
                'description' => 'Nghĩa trang gần rừng quốc gia Cúc Phương, không gian yên tĩnh.',
            ],
            [
                'name' => 'Nghĩa trang Hoa Lư',
                'commune' => 'Hoa Lư',
                'address' => 'Xóm 2, Xã Hoa Lư, Huyện Hoa Lư',
                'description' => 'Nghĩa trang gần cố đô Hoa Lư, có giá trị lịch sử và văn hóa.',
            ],
            [
                'name' => 'Nghĩa trang Trường Yên',
                'commune' => 'Trường Yên',
                'address' => 'Xóm 5, Xã Trường Yên, Huyện Hoa Lư',
                'description' => 'Nghĩa trang với kiến trúc truyền thống, phù hợp với cảnh quan cố đô.',
            ],
            [
                'name' => 'Nghĩa trang Yên Khánh',
                'commune' => 'Yên Khánh',
                'address' => 'Xóm 3, Thị trấn Yên Khánh, Huyện Yên Khánh',
                'description' => 'Nghĩa trang hiện đại với hệ thống quản lý tiên tiến.',
            ],
            [
                'name' => 'Nghĩa trang Khánh Nhạc',
                'commune' => 'Khánh Nhạc',
                'address' => 'Xóm 1, Xã Khánh Nhạc, Huyện Yên Khánh',
                'description' => 'Nghĩa trang với không gian xanh, thân thiện môi trường.',
            ],
            [
                'name' => 'Nghĩa trang Yên Mô',
                'commune' => 'Yên Mô',
                'address' => 'Xóm 4, Thị trấn Yên Mô, Huyện Yên Mô',
                'description' => 'Nghĩa trang trung tâm huyện với dịch vụ chăm sóc mộ phần chuyên nghiệp.',
            ],
            [
                'name' => 'Nghĩa trang Kim Sơn',
                'commune' => 'Kim Sơn',
                'address' => 'Xóm 2, Thị trấn Kim Sơn, Huyện Kim Sơn',
                'description' => 'Nghĩa trang ven biển với không gian thoáng đãng.',
            ],
            [
                'name' => 'Nghĩa trang Phát Diệm',
                'commune' => 'Phát Diệm',
                'address' => 'Xóm 6, Xã Phát Diệm, Huyện Kim Sơn',
                'description' => 'Nghĩa trang gần nhà thờ Phát Diệm, có giá trị tôn giáo và lịch sử.',
            ],
            [
                'name' => 'Nghĩa trang Tam Điệp',
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
