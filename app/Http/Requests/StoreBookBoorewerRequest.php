<?php

namespace App\Http\Requests;

use App\BookBoorewer;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreBookBoorewerRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('book_boorewer_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
        ];
    }
}
