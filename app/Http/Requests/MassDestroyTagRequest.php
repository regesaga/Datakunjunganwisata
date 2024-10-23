<?php

namespace App\Http\Requests;

use App\Models\Tag;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyTagRequest extends FormRequest
{
    
    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:tag,id',
        ];
    }
}
