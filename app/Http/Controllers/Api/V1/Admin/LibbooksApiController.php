<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreLibbookRequest;
use App\Http\Requests\UpdateLibbookRequest;
use App\Http\Resources\Admin\LibbookResource;
use App\Libbook;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LibbooksApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('libbook_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LibbookResource(Libbook::all());
    }

    public function store(StoreLibbookRequest $request)
    {
        $libbook = Libbook::create($request->all());

        if ($request->input('book_cover', false)) {
            $libbook->addMedia(storage_path('tmp/uploads/' . $request->input('book_cover')))->toMediaCollection('book_cover');
        }

        return (new LibbookResource($libbook))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Libbook $libbook)
    {
        abort_if(Gate::denies('libbook_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LibbookResource($libbook);
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

        return (new LibbookResource($libbook))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Libbook $libbook)
    {
        abort_if(Gate::denies('libbook_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $libbook->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
