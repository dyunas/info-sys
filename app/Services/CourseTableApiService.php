<?php

namespace App\Services;

use App\Models\Course;
use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class CourseTableApiService
{
	public function courseDataTable(Request $request)
	{
		$length = $request->input('length');
		$sortBy = $request->input('column');
		$orderBy = $request->input('dir');
		$searchValue = $request->input('search');

		$query = Course::eloquentQuery($sortBy, $orderBy, $searchValue);

		$data = $query->paginate($length);

		return new DataTableCollectionResource($data);
	}

	public function getListOfCourses()
	{
		return response()->json(Course::select('id', 'course_name', 'code')->get(), 200);
	}

	public function getYearLevelsOfCourse($request)
	{
		$levels = Course::where('id', $request->id)->select('year_levels')->get();

		return response()->json($levels, 200);
	}

	public function addNewCourse(Request $request)
	{
		$validator = Validator::make(
			$request->only(
				'courseName',
				'courseCode',
				'yearLevels',
			),
			[
				'courseName' => 'required',
				'courseCode' => 'required',
				'yearLevels' => 'required|integer',
			]
		);

		if ($validator->fails()) {
			return response()->json([
				'title' => 'Error',
				'message' => 'An error occured while adding new course. Please try again later.',
				'error' => $validator->errors(),
			], 422);
		}

		DB::beginTransaction();

		try {
			$course = Course::create([
				'course_name' => $request->courseName,
				'code'				=> $request->courseCode,
				'year_levels' => $request->yearLevels
			]);

			SystemLog::create([
				'user_id' => auth()->user()->id,
				'log'			=> auth()->user()->registrar->first_name . ' ' . auth()->user()->registrar->last_name . ' created course ' . $course->code . ' - ' . $course->course_name,
			]);

			DB::commit();

			return response()->json([
				'title' => 'Success',
				'message' => 'New course added!',
			], 200);
		} catch (\Throwable $error) {
			DB::rollback();

			return response()->json([
				'title' => 'Error',
				'message' => 'An error occured while adding new course. Please try again later.',
				'error' => $error->getMessage(),
			], 500);
		}
	}
}