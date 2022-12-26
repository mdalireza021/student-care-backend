<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Syllabus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SyllabusController extends Controller
{
    public function index()
    {
        $syllabus = Syllabus::with(['attachment'])->first();

        if ($syllabus->attachment) {
            if (Storage::disk('public')->exists(optional($syllabus->attachment)->path)) {
                return response()->json(url('storage/'.$syllabus->attachment->path));
            }
        }
    }
}
