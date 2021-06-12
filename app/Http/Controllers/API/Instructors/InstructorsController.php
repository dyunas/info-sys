<?php

namespace App\Http\Controllers\API\Instructors;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use App\Services\InstructorTableApiService;
use Illuminate\Http\Request;

class InstructorsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(InstructorTableApiService $instructorService, Request $request)
	{
		return $instructorService->instructorDataTable($request);
	}

	public function count(InstructorTableApiService $instructorService)
	{
		return $instructorService->count();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(InstructorTableApiService $instructorService, Request $request)
	{
		return $instructorService->addNewInstructor($request);
	}

	public function tagSubjects(InstructorTableApiService $instructorService, $id, Request $request)
	{
		return $instructorService->tagSubjects($id, $request);
	}

	public function getListOfInstructorsBy(InstructorTableApiService $instructorService, Request $request)
	{
		return $instructorService->getListOfInstructorsBy($request);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
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