<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyMemberRequest;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Member;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MembersController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('member_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $members = Member::all();

        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        abort_if(Gate::denies('member_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.members.create');
    }

    public function store(StoreMemberRequest $request)
    {
        $member = Member::create($request->all());

        if ($request->input('member_image', false)) {
            $member->addMedia(storage_path('tmp/uploads/' . $request->input('member_image')))->toMediaCollection('member_image');
        }

        return redirect()->route('admin.members.index');
    }

    public function edit(Member $member)
    {
        abort_if(Gate::denies('member_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.members.edit', compact('member'));
    }

    public function update(UpdateMemberRequest $request, Member $member)
    {
        $member->update($request->all());

        if ($request->input('member_image', false)) {
            if (!$member->member_image || $request->input('member_image') !== $member->member_image->file_name) {
                $member->addMedia(storage_path('tmp/uploads/' . $request->input('member_image')))->toMediaCollection('member_image');
            }
        } elseif ($member->member_image) {
            $member->member_image->delete();
        }

        return redirect()->route('admin.members.index');
    }

    public function show(Member $member)
    {
        abort_if(Gate::denies('member_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.members.show', compact('member'));
    }

    public function destroy(Member $member)
    {
        abort_if(Gate::denies('member_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $member->delete();

        return back();
    }

    public function massDestroy(MassDestroyMemberRequest $request)
    {
        Member::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
