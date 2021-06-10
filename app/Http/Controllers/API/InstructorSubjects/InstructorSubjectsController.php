<?php

namespace App\Http\Controllers\API\InstructorSubjects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\InstructorSubjectTableApiService;

class InstructorSubjectsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(InstructorSubjectTableApiService $instructorSubject, $id, Request $request)
	{
		return $instructorSubject->subjectsDataTable($id, $request);
	}

	public function get_student_list(InstructorSubjectTableApiService $instructorSubject, Request $request)
	{
		return $instructorSubject->getStudentList($request);
	}

	public function update_grades(InstructorSubjectTableApiService $instructorSubject, Request $request)
	{
		return $instructorSubject->updateGrades($request);
	}
}