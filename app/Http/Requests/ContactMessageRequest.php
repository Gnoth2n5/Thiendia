<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactMessageRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'name' => ['required', 'string', 'max:255'],
      'phone' => ['required', 'string', 'max:20'],
      'email' => ['nullable', 'email', 'max:255'],
      'subject' => ['required', 'string', 'max:255'],
      'message' => ['required', 'string', 'max:2000'],
      'privacy' => ['required', 'accepted'],
    ];
  }

  /**
   * Get custom messages for validator errors.
   */
  public function messages(): array
  {
    return [
      'name.required' => 'Vui lòng nhập họ và tên.',
      'name.max' => 'Họ và tên không được vượt quá 255 ký tự.',
      'phone.required' => 'Vui lòng nhập số điện thoại.',
      'phone.max' => 'Số điện thoại không được vượt quá 20 ký tự.',
      'email.email' => 'Email không đúng định dạng.',
      'email.max' => 'Email không được vượt quá 255 ký tự.',
      'subject.required' => 'Vui lòng chọn chủ đề.',
      'subject.max' => 'Chủ đề không được vượt quá 255 ký tự.',
      'message.required' => 'Vui lòng nhập nội dung tin nhắn.',
      'message.max' => 'Nội dung tin nhắn không được vượt quá 2000 ký tự.',
      'privacy.required' => 'Vui lòng đồng ý với chính sách bảo mật.',
      'privacy.accepted' => 'Vui lòng đồng ý với chính sách bảo mật.',
    ];
  }
}
