@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.bookBoorewer.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.book-boorewers.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('issue') ? 'has-error' : '' }}">
                <label for="issue">{{ trans('cruds.bookBoorewer.fields.issue') }}</label>
                <input type="text" id="issue" name="issue" class="form-control" value="{{ old('issue', isset($bookBoorewer) ? $bookBoorewer->issue : '') }}">
                @if($errors->has('issue'))
                    <p class="help-block">
                        {{ $errors->first('issue') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.bookBoorewer.fields.issue_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('due_date') ? 'has-error' : '' }}">
                <label for="due_date">{{ trans('cruds.bookBoorewer.fields.due_date') }}</label>
                <input type="text" id="due_date" name="due_date" class="form-control" value="{{ old('due_date', isset($bookBoorewer) ? $bookBoorewer->due_date : '') }}">
                @if($errors->has('due_date'))
                    <p class="help-block">
                        {{ $errors->first('due_date') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.bookBoorewer.fields.due_date_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('return_date') ? 'has-error' : '' }}">
                <label for="return_date">{{ trans('cruds.bookBoorewer.fields.return_date') }}</label>
                <input type="text" id="return_date" name="return_date" class="form-control" value="{{ old('return_date', isset($bookBoorewer) ? $bookBoorewer->return_date : '') }}">
                @if($errors->has('return_date'))
                    <p class="help-block">
                        {{ $errors->first('return_date') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.bookBoorewer.fields.return_date_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('book_name') ? 'has-error' : '' }}">
                <label for="book_name">{{ trans('cruds.bookBoorewer.fields.book_name') }}</label>
                <input type="text" id="book_name" name="book_name" class="form-control" value="{{ old('book_name', isset($bookBoorewer) ? $bookBoorewer->book_name : '') }}">
                @if($errors->has('book_name'))
                    <p class="help-block">
                        {{ $errors->first('book_name') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.bookBoorewer.fields.book_name_helper') }}
                </p>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>
@endsection