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
            'reason' => 'required|string',
            'new_owner_name' => 'nullable|string|max:255',
            'new_deceased_full_name' => 'nullable|string|max:255',
            'new_deceased_birth_date' => 'nullable|date',
            'new_deceased_death_date' => 'nullable|date',
            'new_deceased_gender' => 'nullable|in:nam,nữ',
            'new_deceased_relationship' => 'nullable|string|max:255',
            'new_location_description' => 'nullable|string',
            'new_notes' => 'nullable|string',
            'new_deceased_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $grave = Grave::findOrFail($validated['grave_id']);

        // Tạo array dữ liệu hiện tại
        $currentData = [
            'owner_name' => $grave->owner_name,
            'deceased_full_name' => $grave->deceased_full_name,
            'deceased_birth_date' => $grave->deceased_birth_date?->format('Y-m-d'),
            'deceased_death_date' => $grave->deceased_death_date?->format('Y-m-d'),
            'deceased_gender' => $grave->deceased_gender,
            'deceased_relationship' => $grave->deceased_relationship,
            'deceased_photo' => $grave->deceased_photo,
            'location_description' => $grave->location_description,
            'notes' => $grave->notes,
        ];

        // Xử lý upload ảnh
        $photoPath = null;
        if ($request->hasFile('new_deceased_photo')) {
            $photoPath = $request->file('new_deceased_photo')->store('deceased_photos', 'public');
        }

        // Tạo array dữ liệu mới (chỉ những trường đã điền)
        $requestedData = [];
        if (! empty($validated['new_owner_name'])) {
            $requestedData['owner_name'] = $validated['new_owner_name'];
        }
        if (! empty($validated['new_deceased_full_name'])) {
            $requestedData['deceased_full_name'] = $validated['new_deceased_full_name'];
        }
        if (! empty($validated['new_deceased_birth_date'])) {
            $requestedData['deceased_birth_date'] = $validated['new_deceased_birth_date'];
        }
        if (! empty($validated['new_deceased_death_date'])) {
            $requestedData['deceased_death_date'] = $validated['new_deceased_death_date'];
        }
        if (! empty($validated['new_deceased_gender'])) {
            $requestedData['deceased_gender'] = $validated['new_deceased_gender'];
        }
        if (! empty($validated['new_deceased_relationship'])) {
            $requestedData['deceased_relationship'] = $validated['new_deceased_relationship'];
        }
        if (! empty($validated['new_location_description'])) {
            $requestedData['location_description'] = $validated['new_location_description'];
        }
        if (! empty($validated['new_notes'])) {
            $requestedData['notes'] = $validated['new_notes'];
        }
        if ($photoPath) {
            $requestedData['deceased_photo'] = $photoPath;
        }

        // Xác định request_type dựa trên dữ liệu thay đổi
        $requestType = 'sửa_thông_tin';
        if (isset($requestedData['owner_name']) || isset($requestedData['deceased_full_name'])) {
            $requestType = 'sửa_thông_tin';
        }

        ModificationRequest::create([
            'grave_id' => $validated['grave_id'],
            'requester_name' => $validated['requester_name'],
            'requester_phone' => $validated['requester_phone'],
            'requester_email' => $validated['requester_email'],
            'requester_relationship' => $validated['requester_relationship'],
            'request_type' => $requestType,
            'current_data' => $currentData,
            'requested_data' => $requestedData,
            'reason' => $validated['reason'],
            'status' => 'pending',
        ]);

        return redirect()->route('home')->with('success', 'Đơn yêu cầu của bạn đã được gửi thành công. Chúng tôi sẽ xem xét và phản hồi trong thời gian sớm nhất.');
    }

    public function approve($id)
    {
        $modRequest = ModificationRequest::with('grave')->findOrFail($id);

        if ($modRequest->status !== 'pending') {
            return back()->with('error', 'Yêu cầu này đã được xử lý trước đó.');
        }

        $grave = $modRequest->grave;
        $requestedData = $modRequest->requested_data;

        // Cập nhật dữ liệu vào grave
        $updateData = [];

        foreach ($requestedData as $key => $value) {
            if (! empty($value)) {
                $updateData[$key] = $value;
            }
        }

        // Cập nhật grave
        if (! empty($updateData)) {
            $grave->update($updateData);
        }

        // Cập nhật trạng thái yêu cầu
        $modRequest->update([
            'status' => 'approved',
            'processed_at' => now(),
        ]);

        return back()->with('success', 'Đã chấp nhận và cập nhật thông tin lăng mộ thành công!');
    }

    public function reject($id, Request $request)
    {
        $modRequest = ModificationRequest::findOrFail($id);

        if ($modRequest->status !== 'pending') {
            return back()->with('error', 'Yêu cầu này đã được xử lý trước đó.');
        }

        $modRequest->update([
            'status' => 'rejected',
            'processed_at' => now(),
            'admin_note' => $request->input('admin_note'),
        ]);

        return back()->with('success', 'Đã từ chối yêu cầu.');
    }
}
