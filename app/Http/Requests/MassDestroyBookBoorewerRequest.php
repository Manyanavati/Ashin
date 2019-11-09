<?php

namespace App\Http\Requests;

use App\BookBoorewer;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyBookBoorewerRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('book_boorewer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:book_boorewers,id',
        ];
    }
}
