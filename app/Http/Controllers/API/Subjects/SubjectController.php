<?php

namespace App\Http\Controllers\API\Subjects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SubjectTableApiService;

class SubjectController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(SubjectTableApiService $subjectService, Request $request)
	{
		if (count($request->all()) > 0) {
			return $subjectService->subjectsDataTable($request);
		}

		return $subjectService->getListOfSubjects();
	}

	public function getAvailableSubjectsBy(SubjectTableApiService $subjectService, Request $request)
	{
		return $subjectService->getAvailableSubjectsBy($request);
	}

	public function getListOfSubjectsBy(SubjectTableApiService $subjectService, Request $request)
	{
		return $subjectService->getListOfSubjectsBy($request);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(SubjectTableApiService $subjectService, Request $request)
	{
		return $subjectService->addNewSubject($request);
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