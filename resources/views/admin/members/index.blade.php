@extends('layouts.admin')
@section('content')
@can('member_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.members.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.member.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.member.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Member">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.member.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.member.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.member.fields.phone_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.member.fields.address') }}
                        </th>
                        <th>
                            {{ trans('cruds.member.fields.member_start_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.member.fields.member_end_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.member.fields.member_type') }}
                        </th>
                        <th>
                            {{ trans('cruds.member.fields.member_image') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $key => $member)
                        <tr data-entry-id="{{ $member->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $member->id ?? '' }}
                            </td>
                            <td>
                                {{ $member->name ?? '' }}
                            </td>
                            <td>
                                {{ $member->phone_no ?? '' }}
                            </td>
                            <td>
                                {{ $member->address ?? '' }}
                            </td>
                            <td>
                                {{ $member->member_start_date ?? '' }}
                            </td>
                            <td>
                                {{ $member->member_end_date ?? '' }}
                            </td>
                            <td>
                                {{ $member->member_type ?? '' }}
                            </td>
                            <td>
                                @if($member->member_image)
                                    <a href="{{ $member->member_image->getUrl() }}" target="_blank">
                                        <img src="{{ $member->member_image->getUrl('thumb') }}" width="50px" height="50px">
                                    </a>
                                @endif
                            </td>
                            <td>
                                @can('member_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.members.show', $member->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('member_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.members.edit', $member->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('member_delete')
                                    <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('member_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.members.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-Member:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection