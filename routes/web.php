<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->to('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('role', \App\Http\Controllers\RoleController::class);
    Route::resource('role.permission', \App\Http\Controllers\PermissionController::class, ['only' => ['create','store','destroy']]);
    Route::resource('student', \App\Http\Controllers\StudentController::class);
    Route::resource('student-progress', \App\Http\Controllers\StudentProgressController::class);
    Route::resource('home-task', \App\Http\Controllers\HomeTaskController::class);
    Route::resource('teacher', \App\Http\Controllers\TeacherController::class);
    Route::resource('attendance', \App\Http\Controllers\AttendanceController::class);
    Route::resource('profile', \App\Http\Controllers\ProfileController::class);

    Route::resource('notice', \App\Http\Controllers\NoticeBoardController::class);
    Route::resource('library', \App\Http\Controllers\LibraryController::class);
    Route::resource('subject', \App\Http\Controllers\SubjectController::class);
    Route::resource('syllabus', \App\Http\Controllers\SyllabusController::class);
    Route::resource('shift', \App\Http\Controllers\ShiftController::class);
    Route::resource('section', \App\Http\Controllers\SectionController::class);
    Route::resource('school', \App\Http\Controllers\SchoolController::class);
    Route::resource('designation', \App\Http\Controllers\DesignationController::class);
    Route::resource('routine', \App\Http\Controllers\ClassRoutineController::class);
    Route::resource('student-class', \App\Http\Controllers\StudentClassController::class);
    Route::resource('academic-result', \App\Http\Controllers\AcademicResultController::class);

    Route::post('get-student-attendance', [\App\Http\Controllers\StudentClassController::class, 'getStudentAttendance']);
    Route::post('get-storage-file', [\App\Http\Controllers\FileDownloadController::class, 'get']);

    Route::get('get-subjects', [\App\Http\Controllers\SubjectController::class, 'getSubjectByClassId']);
});
