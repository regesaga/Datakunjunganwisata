<?php

namespace App\Http\Requests;

use App\Models\Fasilitas;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyFasilitasRequest extends FormRequest
{
    
    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:fasilitas,id',
        ];
    }
}
