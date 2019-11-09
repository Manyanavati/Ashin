<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyLibbookRequest;
use App\Http\Requests\StoreLibbookRequest;
use App\Http\Requests\UpdateLibbookRequest;
use App\Libbook;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LibbooksController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('libbook_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $libbooks = Libbook::all();

        return view('admin.libbooks.index', compact('libbooks'));
    }

    public function create()
    {
        abort_if(Gate::denies('libbook_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.libbooks.create');
    }

    public function store(StoreLibbookRequest $request)
    {
        $libbook = Libbook::create($request->all());

        if ($request->input('book_cover', false)) {
            $libbook->addMedia(storage_path('tmp/uploads/' . $request->input('book_cover')))->toMediaCollection('book_cover');
        }

        return redirect()->route('admin.libbooks.index');
    }

    public function edit(Libbook $libbook)
    {
        abort_if(Gate::denies('libbook_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.libbooks.edit', compact('libbook'));
    }

    public function update(UpdateLibbookRequest $request, Libbook $libbook)
    {
        $libbook->update($request->all());

        if ($request->input('book_cover', false)) {
            if (!$libbook->book_cover || $request->input('book_cover') !== $libbook->book_cover->file_name) {
                $libbook->addMedia(storage_path('tmp/uploads/' . $request->input('book_cover')))->toMediaCollection('book_cover');
            }
        } elseif ($libbook->book_cover) {
            $libbook->book_cover->delete();
        }

        return redirect()->route('admin.libbooks.index');
    }

    public function show(Libbook $libbook)
    {
        abort_if(Gate::denies('libbook_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.libbooks.show', compact('libbook'));
    }

    public function destroy(Libbook $libbook)
    {
        abort_if(Gate::denies('libbook_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $libbook->delete();

        return back();
    }

    public function massDestroy(MassDestroyLibbookRequest $request)
    {
        Libbook::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
