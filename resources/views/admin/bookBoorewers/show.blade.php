@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.bookBoorewer.title') }}
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.bookBoorewer.fields.id') }}
                        </th>
                        <td>
                            {{ $bookBoorewer->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bookBoorewer.fields.issue') }}
                        </th>
                        <td>
                            {{ $bookBoorewer->issue }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bookBoorewer.fields.due_date') }}
                        </th>
                        <td>
                            {{ $bookBoorewer->due_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bookBoorewer.fields.return_date') }}
                        </th>
                        <td>
                            {{ $bookBoorewer->return_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bookBoorewer.fields.book_name') }}
                        </th>
                        <td>
                            {{ $bookBoorewer->book_name }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>


    </div>
</div>
@endsection