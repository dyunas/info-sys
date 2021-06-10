<?php

namespace App\Http\Controllers\API\Curriculums;

use App\Http\Controllers\Controller;
use App\Services\CurriculumTableApiService;
use Illuminate\Http\Request;

class CurriculumsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(CurriculumTableApiService $curriculumService, Request $request)
	{
		return $curriculumService->curriculumDataTable($request);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(CurriculumTableApiService $curriculumService, Request $request)
	{
		return $curriculumService->addNewCurriculum($request);
	}

	public function addSubjects(CurriculumTableApiService $curriculumService, Request $request)
	{
		return $curriculumService->addSubjects($request);
	}

	public function getCurriculumsByCourse(CurriculumTableApiService $curriculumService, Request $request)
	{
		return $curriculumService->getCurriculumsByCourse($request);
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