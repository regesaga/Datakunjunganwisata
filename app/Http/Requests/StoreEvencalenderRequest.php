<?php

namespace App\Http\Requests;

use App\Models\Evencalender;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreEvencalenderRequest extends FormRequest
{


    public function rules()
    {
        return [
            'title'         => [
                'required',
            ],
           
        ];
    }
    
}
