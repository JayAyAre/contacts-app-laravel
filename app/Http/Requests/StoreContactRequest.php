<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
  //php artisan make:request StoreContactRequest
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
        "name" => ["required", "string"],
        "phone_number" => ["required", "digits:9"],
        "email" => ["required", "email", "unique:contacts,email"],
        "age" => ["required", "min:18", "numeric", "max:255"],
    ];
  }
}
