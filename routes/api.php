<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers\Api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers\Api',
], function ($router) {
    Route::apiResource('notice', 'NoticeBoardController');
    Route::apiResource('teacher', 'TeacherController');
    Route::get('syllabus', 'SyllabusController@index');
    Route::post('home-task', 'HomeTaskController@store');
    Route::get('attendance/{student_id}', 'AttendanceController@show');
});
