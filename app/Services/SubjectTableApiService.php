<?php

namespace App\Services;

use stdClass;
use App\Models\Subject;
use App\Models\SystemLog;
use App\Models\Curriculum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class SubjectTableApiService
{
	public function subjectsDataTable(Request $request)
	{
		$length = $request->input('length');
		$sortBy = $request->input('column');
		$orderBy = $request->input('dir');
		$searchValue = $request->input('search');

		$query = Subject::eloquentQuery($sortBy, $orderBy, $searchValue);

		$data = $query->paginate($length);

		return new DataTableCollectionResource($data);
	}

	public function getListOfSubjects()
	{
		return response()->json(Subject::select('id', 'name', 'code')->get(), 200);
	}

	public function getListOfSubjectsBy(Request $request)
	{
		$data = Curriculum::with(['subjects' => function ($query) use ($request) {
			$query->where('curriculum_subject.year_level', $request->yearLevel);
			$query->where('curriculum_subject.semester', $request->semester);
		}])
			->where('id', $request->curriculum)
			->get();

		$subjectArr = [];

		foreach ($data[0]->subjects as $subject) {
			$subjObj = new stdClass;

			$subjObj->id = $subject->id;
			$subjObj->code = $subject->code;
			$subjObj->name = $subject->name;
			$subjObj->units = $subject->units;
			$subjObj->pre_req = $subject->pre_req;

			array_push($subjectArr, $subjObj);
		}

		return response()->json(
			$subjectArr,
			200
		);
	}

	public function getAvailableSubjectsBy($request)
	{
		$subjects = Subject::query()
			->where('year_level', $request->year_level)
			->where('semester', $request->semester)
			->get();

		return response()->json($subjects, 200);
	}

	public function addNewSubject(Request $request)
	{
		$validator = Validator::make(
			$request->only(
				'preRequisite',
				'semester',
				'subjectCode',
				'subjectName',
				'units',
				'yearLevel'
			),
			[
				'preRequisite' => '',
				'semester' => 'required',
				'subjectCode' => 'required',
				'subjectName' => 'required',
				'units' => 'required',
				'yearLevel' => 'required'
			]
		);

		if ($validator->fails()) {
			return response()->json([
				'title' => 'Error',
				'message' => 'An error occured while adding new subject. Please try again later.',
				'error' => $validator->errors(),
			], 422);
		}

		DB::beginTransaction();

		try {
			$findSubject = Subject::query()
				->where(
					'name',
					$request->subjectName,

				)
				->where(
					'code',
					$request->subjectCode,
				)
				->get();

			if ($findSubject) {
				return response()->json([
					'title' => 'Alert',
					'message' => 'Subject already exists!',
				], 500);
			}

			$subject = Subject::create(
				[
					'name'  		 => $request->subjectName,
					'code' 			 => $request->subjectCode,
					'units' 		 => $request->units,
					'pre_req' 	 => ($request->preRequisite !== '') ? $request->preRequisite : 'N/A',
					'year_level' => $request->yearLevel,
					'semester'   => $request->semester
				]
			);

			SystemLog::create([
				'user_id' => auth()->user()->id,
				'log'			=> auth()->user()->registrar->first_name . ' ' . auth()->user()->registrar->last_name . ' added subject ' . $subject->name,
			]);

			DB::commit();

			return response()->json([
				'title' => 'Success',
				'message' => 'New subject added!',
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