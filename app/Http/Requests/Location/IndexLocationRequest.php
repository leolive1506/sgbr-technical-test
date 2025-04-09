<?php

namespace App\Http\Requests\Location;

use Illuminate\Foundation\Http\FormRequest;

class IndexLocationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'min:3', 'max:150']
        ];
    }
}
