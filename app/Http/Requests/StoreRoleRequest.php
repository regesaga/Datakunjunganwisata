<?php

namespace App\Http\Requests;

use App\Models\Role;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreRoleRequest extends FormRequest
{
    

    public function rules()
    {
        return [
            'name'         => [
                'required',
            ],
            
            'permissions'   => [
                'required',
            ],
        ];
    }
}
