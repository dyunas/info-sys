<?php

namespace App\Http\Controllers\API\Course;

use App\Http\Controllers\Controller;
use App\Services\CourseTableApiService;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(CourseTableApiService $courseService, Request $request)
	{
		if (count($request->all()) > 0) {
			return $courseService->courseDataTable($request);
		}

		return $courseService->getListOfCourses();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(CourseTableApiService $courseService, Request $request)
	{
		return $courseService->addNewCourse($request);
	}

	public function getYearLevels(CourseTableApiService $courseService, Request $request)
	{
		return $courseService->getYearLevelsOfCourse($request);
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