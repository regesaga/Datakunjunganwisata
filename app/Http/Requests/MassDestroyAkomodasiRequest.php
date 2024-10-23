<?php

namespace App\Http\Requests;

use App\Models\Akomodasi;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAkomodasiRequest extends FormRequest
{
    
    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:akomodasi,id',
        ];
    }
}
