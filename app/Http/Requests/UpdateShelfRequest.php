<?php

namespace App\Http\Requests;

use App\Models\Shelf;
use Illuminate\Foundation\Http\FormRequest;

class UpdateShelfRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $shelf = $this->route('shelf');
        $id = ($shelf instanceof Shelf) ? $shelf->id : $shelf;

        return [
            'location_code' => 'sometimes|string|max:255|unique:shelves,location_code,' . $id,
            'capacity' => 'sometimes|integer|min:0',
        ];
    }
}
