@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.libbook.title') }}
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.libbook.fields.id') }}
                        </th>
                        <td>
                            {{ $libbook->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.libbook.fields.lib_no') }}
                        </th>
                        <td>
                            {{ $libbook->lib_no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.libbook.fields.book_name') }}
                        </th>
                        <td>
                            {{ $libbook->book_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.libbook.fields.author_name') }}
                        </th>
                        <td>
                            {{ $libbook->author_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.libbook.fields.book_cover') }}
                        </th>
                        <td>
                            @if($libbook->book_cover)
                                <a href="{{ $libbook->book_cover->getUrl() }}" target="_blank">
                                    <img src="{{ $libbook->book_cover->getUrl('thumb') }}" width="50px" height="50px">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.libbook.fields.add_date') }}
                        </th>
                        <td>
                            {{ $libbook->add_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.libbook.fields.book_detail') }}
                        </th>
                        <td>
                            {!! $libbook->book_detail !!}
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