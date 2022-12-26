<?php

namespace App\Http\Controllers;

use App\Models\NoticeBoard;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NoticeBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $notices = NoticeBoard::all();

        if (request()->ajax()) {
            return response()->json($notices);
        } else {
            return view('notice.index', compact('notices'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('notice.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $inputs = $request->all();

            $inputs['available_from'] = Carbon::parse($inputs['available_from'])->format('Y-m-d');
            $inputs['available_to'] = Carbon::parse($inputs['available_to'])->format('Y-m-d');
            NoticeBoard::create($inputs);
            flash()->success('Notice been added.');

            return redirect()->route('notice.index');
        } catch (\Exception $exception) {
            flash()->error('Something went wrong, please try again later.');
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NoticeBoard  $noticeBoard
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(NoticeBoard $noticeBoard)
    {
        return response()->json($noticeBoard->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NoticeBoard  $noticeBoard
     * @return \Illuminate\Http\Response
     */
    public function edit(NoticeBoard $noticeBoard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NoticeBoard  $noticeBoard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NoticeBoard $noticeBoard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NoticeBoard  $noticeBoard
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $noticeBoard = NoticeBoard::find($id);
        $noticeBoard->delete();
        flash()->success('Notice has been deleted');
        return back();
    }
}
