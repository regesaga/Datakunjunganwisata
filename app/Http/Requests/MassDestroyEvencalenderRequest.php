<?php

namespace App\Http\Requests;

use App\Models\Evencalender;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyEvencalenderRequest extends FormRequest
{
    
    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:event_calendar,id',
        ];
    }
}
