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
