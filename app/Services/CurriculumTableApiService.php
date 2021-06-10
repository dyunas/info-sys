<?php

namespace App\Services;

use App\Models\Curriculum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class CurriculumTableApiService
{
	public function curriculumDataTable(Request $request)
	{
		$length = $request->input('length');
		$sortBy = $request->input('column');
		$orderBy = $request->input('dir');
		$searchValue = $request->input('search');

		$query = Curriculum::eloquentQuery(
			$sortBy,
			$orderBy,
			$searchValue,
			[
				"course"
			]
		);

		$data = $query->paginate($length);

		return new DataTableCollectionResource($data);
	}

	public function addNewCurriculum(Request $request)
	{
		$validator = Validator::make(
			$request->only(
				"course",
				"academicYear"
			),
			[
				"course" => "required",
				"academicYear" => "required"
			]
		);

		if ($validator->fails()) {
			return response()->json([
				'title' => 'Error',
				'message' => 'An error occured while adding new curriculum. Please try again later.',
				'error' => $validator->errors(),
			], 422);
		}

		DB::beginTransaction();

		try {
			Curriculum::create([
				"course_id" => $request->course,
				"school_year" => $request->academicYear
			]);

			DB::commit();

			return response()->json([
				'title' => 'Success',
				'message' => 'New curriculum added!',
			], 200);
		} catch (\Throwable $error) {
			DB::rollback();

			return response()->json([
				'title' => 'Error',
				'message' => 'An error occured while adding new curriculum. Please try again later.',
				'error' => $error->getMessage(),
			], 500);
		}
	}

	public function addSubjects(Request $request)
	{
		$validator = Validator::make(
			$request->only(
				"id",
				"subjects"
			),
			[
				"id" => "required",
				"subjects" => "required"
			]
		);

		if ($validator->fails()) {
			return response()->json([
				'title' => 'Error',
				'message' => 'An error occured while adding new curriculum. Please try again later.',
				'error' => $validator->errors(),
			], 422);
		}

		DB::beginTransaction();

		try {
			$curriculum = Curriculum::find($request->id);

			foreach ($request->subjects as $subject) {
				$curriculum->subjects()->attach($subject['subject']['id'], ['year_level' => $subject['year_level'], 'semester' => $subject['semester']]);
			}

			DB::commit();

			return response()->json([
				'title' => 'Success',
				'message' => 'Subjects added into curriculum!',
			], 200);
		} catch (\Throwable $error) {
			DB::rollback();

			return response()->json([
				'title' => 'Error',
				'message' => 'An error occured while adding subjects into curriculum. Please try again later.',
				'error' => $error->getMessage(),
			], 500);
		}
	}

	public function getCurriculumsByCourse(Request $request)
	{
		$curriculums = Curriculum::where('course_id', $request->id)->select('id', 'school_year')->get();
		return response()->json($curriculums, 200);
	}
}