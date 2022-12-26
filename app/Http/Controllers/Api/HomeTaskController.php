<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeTaskController extends Controller
{
    public function store(Request $request)
    {
        Log::info('task', $request->all());
    }
}
