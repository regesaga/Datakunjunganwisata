<?php

namespace App\Http\Requests;

use App\Models\BanerPromo;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyBanerPromoRequest extends FormRequest
{
    
    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:banerpromo,id',
        ];
    }
}
