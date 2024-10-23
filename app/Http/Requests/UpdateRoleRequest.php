<?php

namespace App\Http\Requests;

use App\Role;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateRoleRequest extends FormRequest
{
    

    public function rules()
    {
        return [
            'name'         => [
                'required',
            ],
            
           
        ];
    }
}
