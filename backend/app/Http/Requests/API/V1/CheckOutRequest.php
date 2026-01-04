<?php

namespace App\Http\Requests\API\V1;


class CheckOutRequest extends ApiFormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'district' => 'nullable|string|max:100',
            'upazila' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ];
    }
}
