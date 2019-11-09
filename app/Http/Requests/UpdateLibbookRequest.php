<?php

namespace App\Http\Requests;

use App\Libbook;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateLibbookRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('libbook_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'add_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
