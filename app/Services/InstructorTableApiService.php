<?php

namespace App\Services;

use App\Models\User;
use App\Models\Instructor;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;
use stdClass;

class InstructorTableApiService
{
	public function instructorDataTable(Request $request)
	{
		$length = $request->input('length');
		$sortBy = $request->input('column');
		$orderBy = $request->input('dir');
		$searchValue = $request->input('search');

		$query = User::eloquentQuery(
			$sortBy,
			$orderBy,
			$searchValue,
			[
				"roles"
			]
		);

		$query->where('roles.name', '=', 'Instructor');
		$data = $query->paginate($length);

		return new DataTableCollectionResource($data);
	}

	public function addNewInstructor($request)
	{
		$validator = Validator::make(
			$request->only(
				"username",
				"password",
				"email",
				"firstName",
				"middleName",
				"lastName",
				"subjects"
			),
			[
				"username" => "required",
				"password" => "required|min:4",
				"email" => "required",
				"firstName" => "required",
				"middleName" => "",
				"lastName" => "required",
				"subjects" => "required"
			]
		);

		if ($validator->fails()) {
			return response()->json([
				'title' => 'Error',
				'message' => 'An error occured while adding new instructor. Please try again later.',
				'error' => $validator->errors(),
			], 422);
		}

		DB::beginTransaction();

		try {
			$user = User::create([
				"username" => $request->username,
				"email"		 => $request->email,
				"password" => Hash::make($request->password),
			]);

			$instructor = Instructor::create([
				"user_id" => $user->id,
				"first_name"  => $request->firstName,
				"middle_name" => $request->middleName,
				"last_name"   => $request->lastName,
			]);

			$subjects = [];
			foreach ($request->subjects as $subject) {
				$subjects[] = $subject['subject_id'];
			}

			$instructor->subjects()->sync($subjects);
			$user->syncRoles('Instructor');

			DB::commit();

			return response()->json([
				'title' => 'Success',
				'message' => 'New instructor added!',
			], 200);
		} catch (\Throwable $error) {
			DB::rollback();

			return response()->json([
				'title' => 'Error',
				'message' => 'An error occured while adding new instructor. Please try again later.',
				'error' => $error->getMessage(),
			], 500);
		}
	}

	public function tagSubjects($instructor, $request)
	{
		$validator = Validator::make(
			$request->only(
				"subjects"
			),
			[
				"subjects" => "required"
			]
		);

		if ($validator->fails()) {
			return response()->json([
				'title' => 'Error',
				'message' => 'An error occured while adding new instructor. Please try again later.',
				'error' => $validator->errors(),
			], 422);
		}

		DB::beginTransaction();

		try {
			$subjects = [];
			foreach ($request->subjects as $subject) {
				$subjects[] = $subject['subject_id'];
			}

			$instructor->subjects()->sync($subjects);

			DB::commit();

			return response()->json([
				'title' => 'Success',
				'message' => 'Subjects tagged!',
			], 200);
		} catch (\Throwable $error) {
			DB::rollback();

			return response()->json([
				'title' => 'Error',
				'message' => 'An error occured while tagging subjects. Please try again later.',
				'error' => $error->getMessage(),
			], 500);
		}
	}

	public function getListOfInstructorsBy($request)
	{
		$instructorArr = [];

		$instructor = Subject::with(['instructors'])
			->where('id', $request->subject_id)
			->get();

		foreach ($instructor[0]->instructors as $instructor) {
			$instructorObj = new stdClass;

			$instructorObj->id = $instructor->id;
			$instructorObj->name = $instructor->last_name . ', ' . $instructor->first_name;

			$instructorArr[] = $instructorObj;
		};

		return response()->json($instructorArr, 200);
	}
}