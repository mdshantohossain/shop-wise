<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SellerRegisterRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|min:8|max:16|confirmed',
            'password_confirmation' => 'required|min:8|max:16',

            // seller
            'store_name' => 'required',
            'seller_type' => 'required|in:individual,business',
            'store_phone' => 'required|unique:sellers,store_phone',
            'store_email' => 'required|email|unique:sellers,store_email',
            'description' => 'nullable|string',
            'city' => 'required',
            'state' => 'required',
            'address' => 'required',
        ];
    }
}
