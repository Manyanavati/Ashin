@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.libbook.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.libbooks.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('lib_no') ? 'has-error' : '' }}">
                <label for="lib_no">{{ trans('cruds.libbook.fields.lib_no') }}</label>
                <input type="text" id="lib_no" name="lib_no" class="form-control" value="{{ old('lib_no', isset($libbook) ? $libbook->lib_no : '') }}">
                @if($errors->has('lib_no'))
                    <p class="help-block">
                        {{ $errors->first('lib_no') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.libbook.fields.lib_no_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('book_name') ? 'has-error' : '' }}">
                <label for="book_name">{{ trans('cruds.libbook.fields.book_name') }}</label>
                <input type="text" id="book_name" name="book_name" class="form-control" value="{{ old('book_name', isset($libbook) ? $libbook->book_name : '') }}">
                @if($errors->has('book_name'))
                    <p class="help-block">
                        {{ $errors->first('book_name') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.libbook.fields.book_name_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('author_name') ? 'has-error' : '' }}">
                <label for="author_name">{{ trans('cruds.libbook.fields.author_name') }}</label>
                <input type="text" id="author_name" name="author_name" class="form-control" value="{{ old('author_name', isset($libbook) ? $libbook->author_name : '') }}">
                @if($errors->has('author_name'))
                    <p class="help-block">
                        {{ $errors->first('author_name') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.libbook.fields.author_name_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('book_cover') ? 'has-error' : '' }}">
                <label for="book_cover">{{ trans('cruds.libbook.fields.book_cover') }}</label>
                <div class="needsclick dropzone" id="book_cover-dropzone">

                </div>
                @if($errors->has('book_cover'))
                    <p class="help-block">
                        {{ $errors->first('book_cover') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.libbook.fields.book_cover_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('add_date') ? 'has-error' : '' }}">
                <label for="add_date">{{ trans('cruds.libbook.fields.add_date') }}</label>
                <input type="text" id="add_date" name="add_date" class="form-control date" value="{{ old('add_date', isset($libbook) ? $libbook->add_date : '') }}">
                @if($errors->has('add_date'))
                    <p class="help-block">
                        {{ $errors->first('add_date') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.libbook.fields.add_date_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('book_detail') ? 'has-error' : '' }}">
                <label for="book_detail">{{ trans('cruds.libbook.fields.book_detail') }}</label>
                <textarea id="book_detail" name="book_detail" class="form-control ">{{ old('book_detail', isset($libbook) ? $libbook->book_detail : '') }}</textarea>
                @if($errors->has('book_detail'))
                    <p class="help-block">
                        {{ $errors->first('book_detail') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.libbook.fields.book_detail_helper') }}
                </p>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    Dropzone.options.bookCoverDropzone = {
    url: '{{ route('admin.libbooks.storeMedia') }}',
    maxFilesize: 8, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 8,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="book_cover"]').remove()
      $('form').append('<input type="hidden" name="book_cover" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="book_cover"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($libbook) && $libbook->book_cover)
      var file = {!! json_encode($libbook->book_cover) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, '{{ $libbook->book_cover->getUrl('thumb') }}')
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="book_cover" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}
</script>
@stop