@extends('layouts.admin')
@section('content')
@can('libbook_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.libbooks.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.libbook.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.libbook.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Libbook">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.libbook.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.libbook.fields.lib_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.libbook.fields.book_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.libbook.fields.author_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.libbook.fields.book_cover') }}
                        </th>
                        <th>
                            {{ trans('cruds.libbook.fields.add_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.libbook.fields.book_detail') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($libbooks as $key => $libbook)
                        <tr data-entry-id="{{ $libbook->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $libbook->id ?? '' }}
                            </td>
                            <td>
                                {{ $libbook->lib_no ?? '' }}
                            </td>
                            <td>
                                {{ $libbook->book_name ?? '' }}
                            </td>
                            <td>
                                {{ $libbook->author_name ?? '' }}
                            </td>
                            <td>
                                @if($libbook->book_cover)
                                    <a href="{{ $libbook->book_cover->getUrl() }}" target="_blank">
                                        <img src="{{ $libbook->book_cover->getUrl('thumb') }}" width="50px" height="50px">
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $libbook->add_date ?? '' }}
                            </td>
                            <td>
                                {{ $libbook->book_detail ?? '' }}
                            </td>
                            <td>
                                @can('libbook_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.libbooks.show', $libbook->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('libbook_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.libbooks.edit', $libbook->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('libbook_delete')
                                    <form action="{{ route('admin.libbooks.destroy', $libbook->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('libbook_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.libbooks.massDestroy') }}",
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
  $('.datatable-Libbook:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection