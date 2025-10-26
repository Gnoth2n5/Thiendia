<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTributeRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   * Allow all users to submit tributes.
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
      'grave_id' => 'required|integer|exists:graves,id',
      'name' => 'nullable|string|max:255',
      'message' => 'nullable|string|max:500',
    ];
  }

  /**
   * Get custom error messages for validation rules.
   *
   * @return array<string, string>
   */
  public function messages(): array
  {
    return [
      'grave_id.required' => 'ID lăng mộ là bắt buộc.',
      'grave_id.integer' => 'ID lăng mộ phải là số nguyên.',
      'grave_id.exists' => 'Lăng mộ không tồn tại.',
      'name.string' => 'Tên phải là chuỗi ký tự.',
      'name.max' => 'Tên không được vượt quá 255 ký tự.',
      'message.string' => 'Lời tưởng niệm phải là chuỗi ký tự.',
      'message.max' => 'Lời tưởng niệm không được vượt quá 500 ký tự.',
    ];
  }

  /**
   * Prepare the data for validation.
   * Sanitize inputs to prevent XSS attacks.
   */
  protected function prepareForValidation(): void
  {
    $this->merge([
      'name' => $this->name ? strip_tags(trim($this->name)) : null,
      'message' => $this->message ? strip_tags(trim($this->message)) : null,
    ]);
  }
}
