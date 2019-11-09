@extends('layouts.admin')
@section('content')
@can('book_boorewer_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.book-boorewers.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.bookBoorewer.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.bookBoorewer.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-BookBoorewer">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.bookBoorewer.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.bookBoorewer.fields.issue') }}
                        </th>
                        <th>
                            {{ trans('cruds.bookBoorewer.fields.due_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.bookBoorewer.fields.return_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.bookBoorewer.fields.book_name') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookBoorewers as $key => $bookBoorewer)
                        <tr data-entry-id="{{ $bookBoorewer->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $bookBoorewer->id ?? '' }}
                            </td>
                            <td>
                                {{ $bookBoorewer->issue ?? '' }}
                            </td>
                            <td>
                                {{ $bookBoorewer->due_date ?? '' }}
                            </td>
                            <td>
                                {{ $bookBoorewer->return_date ?? '' }}
                            </td>
                            <td>
                                {{ $bookBoorewer->book_name ?? '' }}
                            </td>
                            <td>
                                @can('book_boorewer_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.book-boorewers.show', $bookBoorewer->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('book_boorewer_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.book-boorewers.edit', $bookBoorewer->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('book_boorewer_delete')
                                    <form action="{{ route('admin.book-boorewers.destroy', $bookBoorewer->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('book_boorewer_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.book-boorewers.massDestroy') }}",
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
  $('.datatable-BookBoorewer:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection