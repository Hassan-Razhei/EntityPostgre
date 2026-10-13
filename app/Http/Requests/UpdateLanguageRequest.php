<?php

namespace App\Http\Requests;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLanguageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $language = $this->route('language');
        $id = ($language instanceof Language) ? $language->id : $language;

        return [
            'name' => 'required|string|max:255|unique:languages,name,' . $id,
            'code' => 'required|string|max:10|unique:languages,code,' . $id,
        ];
    }
}
