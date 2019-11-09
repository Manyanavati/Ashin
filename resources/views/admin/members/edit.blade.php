@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.member.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.members.update", [$member->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('cruds.member.fields.name') }}*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($member) ? $member->name : '') }}" required>
                @if($errors->has('name'))
                    <p class="help-block">
                        {{ $errors->first('name') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.member.fields.name_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('phone_no') ? 'has-error' : '' }}">
                <label for="phone_no">{{ trans('cruds.member.fields.phone_no') }}*</label>
                <input type="text" id="phone_no" name="phone_no" class="form-control" value="{{ old('phone_no', isset($member) ? $member->phone_no : '') }}" required>
                @if($errors->has('phone_no'))
                    <p class="help-block">
                        {{ $errors->first('phone_no') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.member.fields.phone_no_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                <label for="address">{{ trans('cruds.member.fields.address') }}*</label>
                <input type="text" id="address" name="address" class="form-control" value="{{ old('address', isset($member) ? $member->address : '') }}" required>
                @if($errors->has('address'))
                    <p class="help-block">
                        {{ $errors->first('address') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.member.fields.address_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('member_start_date') ? 'has-error' : '' }}">
                <label for="member_start_date">{{ trans('cruds.member.fields.member_start_date') }}</label>
                <input type="text" id="member_start_date" name="member_start_date" class="form-control" value="{{ old('member_start_date', isset($member) ? $member->member_start_date : '') }}">
                @if($errors->has('member_start_date'))
                    <p class="help-block">
                        {{ $errors->first('member_start_date') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.member.fields.member_start_date_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('member_end_date') ? 'has-error' : '' }}">
                <label for="member_end_date">{{ trans('cruds.member.fields.member_end_date') }}</label>
                <input type="text" id="member_end_date" name="member_end_date" class="form-control" value="{{ old('member_end_date', isset($member) ? $member->member_end_date : '') }}">
                @if($errors->has('member_end_date'))
                    <p class="help-block">
                        {{ $errors->first('member_end_date') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.member.fields.member_end_date_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('member_type') ? 'has-error' : '' }}">
                <label for="member_type">{{ trans('cruds.member.fields.member_type') }}*</label>
                <input type="text" id="member_type" name="member_type" class="form-control" value="{{ old('member_type', isset($member) ? $member->member_type : '') }}" required>
                @if($errors->has('member_type'))
                    <p class="help-block">
                        {{ $errors->first('member_type') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.member.fields.member_type_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('member_image') ? 'has-error' : '' }}">
                <label for="member_image">{{ trans('cruds.member.fields.member_image') }}</label>
                <div class="needsclick dropzone" id="member_image-dropzone">

                </div>
                @if($errors->has('member_image'))
                    <p class="help-block">
                        {{ $errors->first('member_image') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.member.fields.member_image_helper') }}
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
    Dropzone.options.memberImageDropzone = {
    url: '{{ route('admin.members.storeMedia') }}',
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
      $('form').find('input[name="member_image"]').remove()
      $('form').append('<input type="hidden" name="member_image" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="member_image"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($member) && $member->member_image)
      var file = {!! json_encode($member->member_image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, '{{ $member->member_image->getUrl('thumb') }}')
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="member_image" value="' + file.file_name + '">')
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