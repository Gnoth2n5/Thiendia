<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactMessageRequest;
use App\Models\ContactMessage;
use App\Models\ContactSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        $contactSetting = ContactSetting::getActive();

        // Use placeholder data if no contact setting exists
        if (!$contactSetting) {
            $contactSetting = new \stdClass;
            $contactSetting->phone = '0212.123.456';
            $contactSetting->phone_description = 'Hotline hỗ trợ 24/7';
            $contactSetting->email = 'lienhe@tracuulietsi.tunna.id.vn';
            $contactSetting->email_description = 'Email hỗ trợ nhanh chóng';
            $contactSetting->address_line1 = 'Số 1, Đường Lê Đại Hành';
            $contactSetting->address_line2 = 'Phường Đông Thành, Thành phố Ninh Bình';
            $contactSetting->address_description = 'Văn phòng tiếp nhận hồ sơ';
            $contactSetting->working_hours = [
                ['day' => 'Thứ 2 - Thứ 6', 'hours' => '07:30 - 17:00', 'is_closed' => false],
                ['day' => 'Thứ 7', 'hours' => '07:30 - 12:00', 'is_closed' => false],
                ['day' => 'Chủ nhật', 'hours' => 'Nghỉ', 'is_closed' => true],
            ];
            $contactSetting->note = 'Ngoài giờ làm việc, vui lòng liên hệ qua hotline hoặc email.';
        }

        return view('contact', compact('contactSetting'));
    }

    public function store(ContactMessageRequest $request): RedirectResponse
    {
        ContactMessage::create($request->validated());

        return redirect()
            ->route('contact')
            ->with('success', 'Tin nhắn của bạn đã được gửi thành công! Chúng tôi sẽ phản hồi trong thời gian sớm nhất.');
    }
}
