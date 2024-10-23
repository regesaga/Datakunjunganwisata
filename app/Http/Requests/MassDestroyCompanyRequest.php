<?php

namespace App\Http\Requests;

use App\Models\Company;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCompanyRequest extends FormRequest
{
  

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:companies,id',
        ];
    }
}
