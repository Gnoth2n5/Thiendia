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
        $query = Grave::with('cemetery', 'plot');

        // Tìm kiếm theo tên liệt sĩ
        if ($request->filled('deceased_name')) {
            $query->where('deceased_full_name', 'like', '%' . $request->deceased_name . '%');
        }

        // Lọc theo năm sinh
        if ($request->filled('birth_year')) {
            $query->where(function ($q) use ($request) {
                $q->where('birth_year', $request->birth_year)
                    ->orWhereYear('deceased_birth_date', $request->birth_year);
            });
        }

        // Lọc theo năm hy sinh
        if ($request->filled('death_year')) {
            $query->whereYear('deceased_death_date', $request->death_year);
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

        // Lọc theo lô mộ
        if ($request->filled('plot_code')) {
            $query->whereHas('plot', function ($q) use ($request) {
                $q->where('plot_code', 'like', '%' . $request->plot_code . '%');
            });
        }

        $graves = $query->paginate(12);
        $cemeteries = Cemetery::all();

        return view('search', compact('graves', 'cemeteries'));
    }

    public function show($id)
    {
        $grave = Grave::with('cemetery', 'plot')->findOrFail($id);

        // Load plot grid data if grave has a plot
        $plotGrid = null;
        if ($grave->plot) {
            $cemetery = $grave->cemetery;
            $dimensions = $cemetery->getGridDimensions();

            $plots = \App\Models\CemeteryPlot::where('cemetery_id', $cemetery->id)
                ->with('grave:id,plot_id,deceased_full_name')
                ->orderBy('row')
                ->orderBy('column')
                ->get();

            // Build 2D array for easy rendering
            $plotGrid = [
                'rows' => $dimensions['rows'],
                'columns' => $dimensions['columns'],
                'plots' => $plots,
                'targetPlotId' => $grave->plot->id,
            ];
        }

        return view('grave-detail', compact('grave', 'plotGrid'));
    }

    /**
     * Display cemetery map with plot grid.
     */
    public function cemeteryMap($id)
    {
        $cemetery = Cemetery::findOrFail($id);

        // Load plot grid data
        $dimensions = $cemetery->getGridDimensions();

        $plots = \App\Models\CemeteryPlot::where('cemetery_id', $cemetery->id)
            ->with('grave:id,plot_id,deceased_full_name')
            ->orderBy('row')
            ->orderBy('column')
            ->get();

        $plotGrid = [
            'rows' => $dimensions['rows'],
            'columns' => $dimensions['columns'],
            'plots' => $plots,
        ];

        return view('cemetery-map', compact('cemetery', 'plotGrid'));
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

    public function contact()
    {
        return view('contact');
    }

    public function guide()
    {
        return view('guide');
    }

    public function privacyPolicy()
    {
        return view('privacy-policy');
    }

    public function termsOfService()
    {
        return view('terms-of-service');
    }
}
