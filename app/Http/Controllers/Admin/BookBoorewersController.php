<?php

namespace App\Http\Controllers\Admin;

use App\BookBoorewer;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBookBoorewerRequest;
use App\Http\Requests\StoreBookBoorewerRequest;
use App\Http\Requests\UpdateBookBoorewerRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BookBoorewersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('book_boorewer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bookBoorewers = BookBoorewer::all();

        return view('admin.bookBoorewers.index', compact('bookBoorewers'));
    }

    public function create()
    {
        abort_if(Gate::denies('book_boorewer_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.bookBoorewers.create');
    }

    public function store(StoreBookBoorewerRequest $request)
    {
        $bookBoorewer = BookBoorewer::create($request->all());

        return redirect()->route('admin.book-boorewers.index');
    }

    public function edit(BookBoorewer $bookBoorewer)
    {
        abort_if(Gate::denies('book_boorewer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.bookBoorewers.edit', compact('bookBoorewer'));
    }

    public function update(UpdateBookBoorewerRequest $request, BookBoorewer $bookBoorewer)
    {
        $bookBoorewer->update($request->all());

        return redirect()->route('admin.book-boorewers.index');
    }

    public function show(BookBoorewer $bookBoorewer)
    {
        abort_if(Gate::denies('book_boorewer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.bookBoorewers.show', compact('bookBoorewer'));
    }

    public function destroy(BookBoorewer $bookBoorewer)
    {
        abort_if(Gate::denies('book_boorewer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bookBoorewer->delete();

        return back();
    }

    public function massDestroy(MassDestroyBookBoorewerRequest $request)
    {
        BookBoorewer::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
