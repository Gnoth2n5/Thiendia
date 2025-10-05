<?php

namespace App\Http\Controllers;

use App\Models\Cemetery;
use App\Models\Grave;
use Illuminate\Http\Request;

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
}
