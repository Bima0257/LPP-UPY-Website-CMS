<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Services\MemberService;
use Illuminate\Support\Facades\Cache;

class MemberController extends Controller
{

    protected MemberService $memberService;

    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view(
            'admin.member.index',
            [
                'title' => 'Member',
                'members' => Member::all()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMemberRequest $request)
    {
        $this->memberService->store($request->validated());

        Cache::forget('members');

        return redirect()->route('members.index')
            ->with('success', 'Data member berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        return response()->json($member);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberRequest $request, Member $member)
    {

        $this->memberService->update($member, $request->validated());

        Cache::forget('members');

        return redirect()->route('members.index')
            ->with('success', 'Data member berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $this->memberService->delete($member);

        return redirect('/members')->with('success', 'Member Telah Di hapus!');
    }

    public function updateOrder(Request $request)
    {
        foreach ($request->order as $index => $id) {
            Member::where('id', $id)->update(['sort_order' => $index + 1]);
        }

        Cache::forget('members');
        
        return response()->json(['success' => true]);
    }
}
