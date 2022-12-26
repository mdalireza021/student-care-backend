<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NoticeBoard;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NoticeBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $notices = NoticeBoard::all();
        return response()->json(['status' => true, 'data' => $notices]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $inputs = $request->all();

            $inputs['available_from'] = Carbon::parse($inputs['available_from'])->format('Y-m-d');
            $inputs['available_to'] = Carbon::parse($inputs['available_to'])->format('Y-m-d');
            NoticeBoard::create($inputs);
            return response()->json(['status' => true, 'message' => 'Notice been added.']);
        } catch (\Exception $exception) {
            return response()->json(['status' => true, 'message' => 'Something went wrong, please try again later.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NoticeBoard  $noticeBoard
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(NoticeBoard $noticeBoard)
    {
        return response()->json(['status' => true, 'data' => $noticeBoard]);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(NoticeBoard $noticeBoard)
    {
        $noticeBoard->delete();
        return response()->json(['status' => true, 'message' => 'Notice has been deleted.']);
    }
}
