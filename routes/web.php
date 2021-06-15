<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\Dashboard\DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Route group only accessible by admins
Route::group(['prefix' => 'users', 'middleware' => ['role:Registrar']], function () {
	Route::get('/instructors/{instructor}/tag_subjects', [App\Http\Controllers\Instructors\InstructorsController::class, 'tagSubject'])->name('instructor.tagSubject')->middleware('auth');
	Route::resource('/instructors', App\Http\Controllers\Instructors\InstructorsController::class)->names('instructor')->middleware('auth');
	Route::resource('/registrars', App\Http\Controllers\Registrars\RegistrarsController::class)->names('registrar')->middleware('auth');

	Route::get('/students/{student}/edit_academics', [App\Http\Controllers\Students\StudentsController::class, 'edit_academic'])->name('students.edit_academics')->middleware('auth');
	Route::get('/students/{student}/add_subjects', [App\Http\Controllers\Students\StudentsController::class, 'add_subjects'])->name('students.add_subjects')->middleware('auth');
	Route::get('/students/{student}/edit', [App\Http\Controllers\Students\StudentsController::class, 'edit'])->name('students.edit')->middleware('auth');
	Route::resource('/students', App\Http\Controllers\Students\StudentsController::class)->names('students')->middleware('auth');
});

Route::group(['prefix' => 'settings', 'middleware' => ['role:Registrar']], function () {
	Route::resource('/academic-year', App\Http\Controllers\AcademicYear\AcademicYearController::class)->names('academic')->middleware('auth');

	Route::resource('/courses', App\Http\Controllers\Courses\CoursesController::class)->names('courses')->middleware('auth');

	Route::resource('/subjects', App\Http\Controllers\Subjects\SubjectsController::class)->names('subjects')->middleware('auth');

	Route::get('/curriculums/{curriculum}/add-subjects', [App\Http\Controllers\Curriculum\CurriculumController::class, 'addSubjects'])->name('curriculum.add-subjects')->middleware('auth');
	Route::resource('/curriculums', App\Http\Controllers\Curriculum\CurriculumController::class)->names('curriculums')->middleware('auth');
});

Route::group(['prefix' => 'logs', 'as' => 'logs.', 'middleware' => ['role:Registrar']], function () {
	Route::resource('/system-logs', App\Http\Controllers\Logs\SystemLogsController::class)->names('system')->middleware('auth');
});

// Route group only accessible by instructors
Route::group(['prefix' => 'instructor', 'as' => 'instructor.', 'middleware' => ['role:Instructor']], function () {
	Route::resource('/subjects', App\Http\Controllers\InstructorSubjects\InstructorSubjectsController::class)->names('subjects')->middleware('auth');
});

Route::get('test', function () {
	$user =  \App\Models\User::find(1);
	$user->assignRole(1);
});