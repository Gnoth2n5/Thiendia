<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API to get communes (wards) from vietnamlabs API for Ninh Bình province
Route::get('/communes', function (Request $request) {
    try {
        // Gọi API vietnamlabs để lấy danh sách xã/phường của tất cả các tỉnh
        $response = Http::get('https://vietnamlabs.com/api/vietnamprovince');

        if ($response->successful()) {
            $data = $response->json();

            // Tìm tỉnh Ninh Bình trong danh sách
            $ninhBinh = collect($data['data'] ?? [])->firstWhere('province', 'Ninh Bình');

            if ($ninhBinh && isset($ninhBinh['wards'])) {
                // Trích xuất tên xã/phường và sắp xếp theo alphabet
                $wards = collect($ninhBinh['wards'])
                    ->pluck('name')
                    ->sort()
                    ->values()
                    ->toArray();

                return response()->json([
                    'success' => true,
                    'data' => $wards,
                ]);
            }
        }

        // Nếu API lỗi, fallback về config cũ - lấy tất cả xã/phường
        $allCommunes = [];
        $locations = config('ninhbinh_locations');
        foreach ($locations as $communes) {
            $allCommunes = array_merge($allCommunes, $communes);
        }
        $allCommunes = array_unique($allCommunes);
        sort($allCommunes);

        return response()->json([
            'success' => true,
            'data' => $allCommunes,
        ]);
    } catch (\Exception $e) {
        // Nếu có lỗi, fallback về config cũ
        $allCommunes = [];
        $locations = config('ninhbinh_locations');
        foreach ($locations as $communes) {
            $allCommunes = array_merge($allCommunes, $communes);
        }
        $allCommunes = array_unique($allCommunes);
        sort($allCommunes);

        return response()->json([
            'success' => true,
            'data' => $allCommunes,
        ]);
    }
});
