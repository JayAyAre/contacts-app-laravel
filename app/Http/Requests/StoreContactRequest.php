<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        "email" => ["required",
            "email",
            Rule::unique("contacts", "email")
                ->where('user_id', auth()->id())
                ->ignore($this->contact)],
        "age" => ["required", "min:18", "numeric", "max:255"],
        "profile_picture" => ["image", "nullable"],
    ];
  }

  public function messages(): array
  {
    return [
        "name.required" => "Name is required",
        "phone_number.required" => "Phone number is required",
        "email.required" => "Email is required",
        "email.unique" => "This email already exists on one of our contacts",
        "age.required" => "Age is required",
        "profile_picture.image" => "Profile picture must be an image",
    ];
  }
}
