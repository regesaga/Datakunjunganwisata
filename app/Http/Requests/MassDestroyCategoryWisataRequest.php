<?php

namespace App\Http\Requests;

use App\Models\CategoryWisata;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCategoryWisataRequest extends FormRequest
{
    
    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:categorywisata,id',
        ];
    }
}
