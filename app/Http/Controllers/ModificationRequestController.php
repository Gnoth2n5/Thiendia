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
            'requested_data_text' => 'required|string',
        ]);

        $grave = Grave::findOrFail($validated['grave_id']);

        // Parse requested_data_text thành array
        $requestedDataLines = explode("\n", $validated['requested_data_text']);
        $requestedData = [];
        foreach ($requestedDataLines as $line) {
            $line = trim($line);
            if (empty($line)) {
                continue;
            }

            $parts = explode(':', $line, 2);
            if (count($parts) === 2) {
                $key = trim($parts[0]);
                $value = trim($parts[1]);
                if (! empty($key) && ! empty($value)) {
                    $requestedData[$key] = $value;
                }
            }
        }

        // Lưu dữ liệu hiện tại
        $currentData = [
            'owner_name' => $grave->owner_name,
            'deceased_full_name' => $grave->deceased_full_name,
            'burial_date' => $grave->burial_date?->format('d/m/Y'),
            'location_description' => $grave->location_description,
        ];

        ModificationRequest::create([
            'grave_id' => $validated['grave_id'],
            'requester_name' => $validated['requester_name'],
            'requester_phone' => $validated['requester_phone'],
            'requester_email' => $validated['requester_email'],
            'requester_relationship' => $validated['requester_relationship'],
            'request_type' => $validated['request_type'],
            'current_data' => $currentData,
            'requested_data' => $requestedData,
            'reason' => $validated['reason'],
            'status' => 'pending',
        ]);

        return redirect()->route('home')->with('success', 'Đơn yêu cầu của bạn đã được gửi thành công. Chúng tôi sẽ xem xét và phản hồi trong thời gian sớm nhất.');
    }
}
