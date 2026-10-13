<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShelfRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'location_code' => 'required|string|max:255|unique:shelves,location_code',
            'capacity' => 'required|integer|min:0',
        ];
    }
}
