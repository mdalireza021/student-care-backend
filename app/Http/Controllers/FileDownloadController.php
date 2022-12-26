<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileDownloadController extends Controller
{
    public function get(Request $request)
    {
        /*$fileurl = '';

        if (\Storage::exists($request->fileurl)) {
            $content = \Storage::get($request->fileurl);
            $fileurl = \Storage::disk('public')->put($request->fileurl, $content);
        }

        return response()->json(\Storage::url($request->fileurl));*/
        // $fileContent = Storage::download($request->get('fileurl'));
        // return Storage::response($request->get('fileurl'));

        return response()->download(Storage::disk('public')->url($request->get('fileurl')));

        // return Storage::response($request->get('fileurl'));
    }

    public function destroy($id, Request $request)
    {
        if (\Storage::disk('public')->exists($request->fileurl)) {
            \Storage::disk('public')->delete($request->fileurl);
        }

        return response()->json($id);
    }
}
