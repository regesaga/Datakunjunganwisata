<?php

namespace App\Http\Requests;


use App\Models\Wisata;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateWisataRequest extends FormRequest
{
    public function rules()
    {
        return [
            'namawisata'         => [
                'required',
            ]           
        ];
    }
   
}
