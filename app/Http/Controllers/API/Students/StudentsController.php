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

	public function count(StudentsTableApiService $studentService)
	{
		return $studentService->count();
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

	public function addSubjects($id, StudentsTableApiService $studentService, Request $request)
	{
		return $studentService->addSubjects($id, $request);
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
	public function update($id, Request $request, StudentsTableApiService $studentService)
	{
		return $studentService->update($id, $request);
	}

	public function updateAcademics($id, StudentsTableApiService $studentService, Request $request)
	{
		return $studentService->updateAcademics($id, $request);
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