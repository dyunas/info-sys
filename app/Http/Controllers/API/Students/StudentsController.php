<?php

namespace App\Http\Controllers\API\Students;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\StudentsTableApiService;

class StudentsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(StudentsTableApiService $studentService, Request $request)
	{
		return $studentService->studentsDataTable($request);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StudentsTableApiService $studentService, Request $request)
	{
		return $studentService->store($request);
	}

	public function addSubjects(Student $student, StudentsTableApiService $studentService, Request $request)
	{
		return $studentService->addSubjects($student, $request);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(StudentsTableApiService $studentService, $id)
	{
		return $studentService->show($id);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	public function updateAcademics(Student $student, StudentsTableApiService $studentService, Request $request)
	{
		return $studentService->updateAcademics($student, $request);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
}