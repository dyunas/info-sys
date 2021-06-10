<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});

// users
Route::prefix('users')->group(function () {
	Route::post('/instructors/{instructor}/tag_subjects', [App\Http\Controllers\API\Instructors\InstructorsController::class, 'tagSubjects']);
	Route::get('/instructors/get_list_of_instructors_by', [App\Http\Controllers\API\Instructors\InstructorsController::class, 'getListOfInstructorsBy']);
	Route::apiResource('/instructors', App\Http\Controllers\API\Instructors\InstructorsController::class);
	Route::apiResource('/registrars', App\Http\Controllers\API\Registrars\RegistrarsController::class);
});

// instructor-subjects
Route::prefix('instructor')->group(function () {
	Route::patch('/subjects/update_grades', [App\Http\Controllers\API\InstructorSubjects\InstructorSubjectsController::class, 'update_grades']);
	Route::get('/subjects/get_student_list', [App\Http\Controllers\API\InstructorSubjects\InstructorSubjectsController::class, 'get_student_list']);
	Route::get('/subjects/{id}', [App\Http\Controllers\API\InstructorSubjects\InstructorSubjectsController::class, 'index']);
});

// courses
Route::get('/courses/get_year_levels', [App\Http\Controllers\API\Course\CoursesController::class, 'getYearLevels']);
Route::apiResource('/courses', App\Http\Controllers\API\Course\CoursesController::class);

// subjects
Route::get('/subjects/get_list_of_subjects_by', [App\Http\Controllers\API\Subjects\SubjectController::class, 'getListOfSubjectsBy']);
Route::get('/subjects/get_available_subjects_by', [App\Http\Controllers\API\Subjects\SubjectController::class, 'getAvailableSubjectsBy']);
Route::apiResource('/subjects', App\Http\Controllers\API\Subjects\SubjectController::class);

// curriculums
Route::get('/curriculums/get_curriculums_by_course', [App\Http\Controllers\API\Curriculums\CurriculumsController::class, 'getCurriculumsByCourse']);
Route::post('/curriculums/{curriculum}/add_subjects', [App\Http\Controllers\API\Curriculums\CurriculumsController::class, 'addSubjects']);
Route::apiResource('/curriculums', App\Http\Controllers\API\Curriculums\CurriculumsController::class);

// academic_year
Route::apiResource('/academic-year', \App\Http\Controllers\API\AcademicYear\AcademicYearController::class);

// students
Route::post('/students/{student}/add_subjects', [App\Http\Controllers\API\Students\StudentsController::class, 'addSubjects']);
Route::patch('/students/{student}/update_academics', [App\Http\Controllers\API\Students\StudentsController::class, 'updateAcademics']);
Route::apiResource('/students', \App\Http\Controllers\API\Students\StudentsController::class);