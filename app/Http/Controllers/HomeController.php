<?php

namespace App\Http\Controllers;

use App\Models\Cemetery;
use App\Models\Grave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        $cemeteries = Cemetery::withCount('graves')->get();
        $totalGraves = Grave::count();

        return view('home', compact('cemeteries', 'totalGraves'));
    }

    public function search(Request $request)
    {
        $query = Grave::with('cemetery');

        // Tìm kiếm theo tên người quản lý mộ
        if ($request->filled('caretaker_name')) {
            $query->where('caretaker_name', 'like', '%' . $request->caretaker_name . '%');
        }

        // Tìm kiếm theo tên người đã khuất
        if ($request->filled('deceased_name')) {
            $query->where('deceased_full_name', 'like', '%' . $request->deceased_name . '%');
        }

        // Lọc theo xã (từ cemetery)
        if ($request->filled('commune')) {
            $query->whereHas('cemetery', function ($q) use ($request) {
                $q->where('commune', $request->commune);
            });
        }

        // Lọc theo nghĩa trang
        if ($request->filled('cemetery_id')) {
            $query->where('cemetery_id', $request->cemetery_id);
        }

        $graves = $query->paginate(12);
        $cemeteries = Cemetery::all();

        return view('search', compact('graves', 'cemeteries'));
    }

    public function show($id)
    {
        $grave = Grave::with('cemetery')->findOrFail($id);

        return view('grave-detail', compact('grave'));
    }

    /**
     * Fetch và cache danh sách xã/phường từ API Ninh Bình
     */
    public function fetchAndCacheWards(): array
    {
        return Cache::remember('ninhbinh_wards', now()->addDays(7), function () {
            try {
                $apiUrl = config('app.ninhbinh_api_url');
                $apiKey = config('app.ninhbinh_api_key');

                // Gọi API với SSL verification disabled (chỉ cho development)
                // API không cần api_key trong query, chỉ cần URL với limit
                $response = Http::withoutVerifying()->get($apiUrl);

                if ($response->successful()) {
                    $result = $response->json();

                    if (isset($result['success']) && $result['success'] && isset($result['data'])) {
                        return $result['data'];
                    }
                }

                return [];
            } catch (\Exception $e) {
                Log::error('Lỗi khi fetch wards từ API Ninh Bình: ' . $e->getMessage());

                return [];
            }
        });
    }

    /**
     * API endpoint để trả về danh sách xã/phường cho JavaScript
     */
    public function getWards(): \Illuminate\Http\JsonResponse
    {
        $wards = $this->fetchAndCacheWards();

        return response()->json([
            'success' => true,
            'data' => $wards,
        ]);
    }
}
