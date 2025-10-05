<?php

namespace App\Http\Controllers;

use App\Models\Grave;
use App\Models\ModificationRequest;
use Illuminate\Http\Request;

class ModificationRequestController extends Controller
{
    public function create($graveId)
    {
        $grave = Grave::with('cemetery')->findOrFail($graveId);

        return view('modification-request', compact('grave'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'grave_id' => 'required|exists:graves,id',
            'requester_name' => 'required|string|max:255',
            'requester_phone' => 'required|string|max:20',
            'requester_email' => 'nullable|email|max:255',
            'requester_relationship' => 'nullable|string|max:255',
            'request_type' => 'required|in:sửa_thông_tin,thêm_người,xóa_người,sửa_vị_trí,khác',
            'reason' => 'required|string',
            'requested_data' => 'required|array',
        ]);

        $grave = Grave::findOrFail($validated['grave_id']);

        // Lưu dữ liệu hiện tại
        $validated['current_data'] = [
            'owner_name' => $grave->owner_name,
            'deceased_full_name' => $grave->deceased_full_name,
            'burial_date' => $grave->burial_date?->format('Y-m-d'),
            'location_description' => $grave->location_description,
        ];

        ModificationRequest::create($validated);

        return redirect()->route('home')->with('success', 'Đơn yêu cầu của bạn đã được gửi thành công. Chúng tôi sẽ xem xét và phản hồi trong thời gian sớm nhất.');
    }
}
