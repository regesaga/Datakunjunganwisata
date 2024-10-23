<?php

namespace App\Http\Requests;

use App\Models\Wisata;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreWisataRequest extends FormRequest
{

    public function authorize()
    {
        abort_if(Gate::denies('wisata_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }
    

    public function rules()
    {
        return [
            'namawisata'         => [
                'required',
            ],
           
        ];
    }
    
}
