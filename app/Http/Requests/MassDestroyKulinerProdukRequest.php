<?php

namespace App\Http\Requests;

use App\Models\KulinerProduk;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyKulinerProdukRequest extends FormRequest
{
    
    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:kulinerproduk,id',
        ];
    }
}
