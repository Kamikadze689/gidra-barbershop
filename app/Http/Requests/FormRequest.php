<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMasterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'experience' => 'required',
            'specialization' => 'required',
        ];
    }
}
