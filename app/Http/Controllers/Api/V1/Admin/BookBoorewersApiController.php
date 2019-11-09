<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\BookBoorewer;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookBoorewerRequest;
use App\Http\Requests\UpdateBookBoorewerRequest;
use App\Http\Resources\Admin\BookBoorewerResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BookBoorewersApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('book_boorewer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BookBoorewerResource(BookBoorewer::all());
    }

    public function store(StoreBookBoorewerRequest $request)
    {
        $bookBoorewer = BookBoorewer::create($request->all());

        return (new BookBoorewerResource($bookBoorewer))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(BookBoorewer $bookBoorewer)
    {
        abort_if(Gate::denies('book_boorewer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BookBoorewerResource($bookBoorewer);
    }

    public function update(UpdateBookBoorewerRequest $request, BookBoorewer $bookBoorewer)
    {
        $bookBoorewer->update($request->all());

        return (new BookBoorewerResource($bookBoorewer))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(BookBoorewer $bookBoorewer)
    {
        abort_if(Gate::denies('book_boorewer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bookBoorewer->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
