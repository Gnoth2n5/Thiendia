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
        $occupiedGraves = Grave::where('status', 'đã_sử_dụng')->count();

        return view('home', compact('cemeteries', 'totalGraves', 'occupiedGraves'));
    }

    public function search(Request $request)
    {
        $query = Grave::with('cemetery');

        // Tìm kiếm theo số lăng mộ
        if ($request->filled('grave_number')) {
            $query->where('grave_number', 'like', '%' . $request->grave_number . '%');
        }

        // Tìm kiếm theo tên chủ lăng mộ
        if ($request->filled('owner_name')) {
            $query->where('owner_name', 'like', '%' . $request->owner_name . '%');
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
