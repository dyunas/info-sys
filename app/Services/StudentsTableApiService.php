<?php

namespace App\Services;

use App\Models\GradedSubject;
use App\Models\Student;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class StudentsTableApiService
{
	public function studentsDataTable(Request $request)
	{
		$length = $request->input('length');
		$sortBy = $request->input('column');
		$searchValue = $request->input('search');

		$query = Student::eloquentQuery(
			$sortBy,
			'desc',
			$searchValue,
			[
				'courses',
				'curriculums'
			]
		);

		$data = $query->paginate($length);

		return new DataTableCollectionResource($data);
	}

	public function store(Request $request)
	{
		$validator = Validator::make(
			$request->only(
				'firstName',
				'middleName',
				'lastName',
				'gender',
				'bdate',
				'contactNumber',
				'email',
				'address',
				'province',
				'municipal',
				'barangay',
				'yearLevel',
				'semester',
				'course',
				'curriculum',
				'subjects',
			),
			[
				'firstName'  => 'required',
				'middleName' => '',
				'lastName'   => 'required',
				'gender' 		 => 'required',
				'bdate'      => 'required',
				'contactNumber' => 'required',
				'email' 		 => 'required',
				'address' 	 => 'required',
				'province' 	 => 'required',
				'municipal'  => 'required',
				'barangay' 	 => 'required',
				'yearLevel'  => 'required',
				'semester'   => 'required',
				'course' 		 => 'required',
				'curriculum' => 'required',
				'subjects' 	 => 'required',
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
			$age = Carbon::parse($request->bdate)->age;

			$student = Student::create([
				'first_name' 			=> $request->firstName,
				'middle_name' 		=> $request->middleName,
				'last_name' 			=> $request->lastName,
				'bdate' 					=> $request->bdate,
				'age' 						=> $age,
				'email' 					=> $request->email,
				'contact_number'  => $request->contactNumber,
				'address' 				=> $request->address,
				'province' 				=> $request->province,
				'municipal' 			=> $request->municipal,
				'barangay' 				=> $request->barangay,
				'year_level' 			=> $request->yearLevel,
				'semester' 				=> $request->semester,
				'course_id' 			=> $request->course,
				'curriculum_id' 	=> $request->curriculum,
			]);

			foreach ($request->subjects as $subject) {
				GradedSubject::create([
					'student_id'  	=> $student->id,
					'subject_id' 	 	=> $subject['subject_id'],
					'instructor_id' => $subject['instructor_id']['id'],
					'year_level' 		=> $request->yearLevel,
					'semester' 			=> $request->semester
				]);
			}

			DB::commit();

			return response()->json([
				'title' => 'Success',
				'message' => 'New Student added!',
			], 200);
		} catch (\Throwable $error) {
			DB::rollback();

			return response()->json([
				'title' => 'Error',
				'message' => 'An error occured while adding student. Please try again later.',
				'error' => $error->getMessage(),
			], 500);
		}
	}

	public function updateAcademics($student, $request)
	{
		$validator = Validator::make(
			$request->only(
				'data.yearLevel',
				'data.semester',
				'data.course',
				'data.curriculum'
			),
			[
				'data.yearLevel' => 'required',
				'data.semester' => 'required',
				'data.course' => 'required',
				'data.curriculum' => 'required'
			]
		);

		if ($validator->fails()) {
			return response()->json([
				'title' => 'Error',
				'message' => 'An error occured while updating academics. Please try again later.',
				'error' => $validator->errors(),
			], 422);
		}

		DB::beginTransaction();

		try {
			$student->update([
				'year_level' => $request->data['yearLevel'],
				'semester' => $request->data['semester'],
				'course_id' => $request->data['course'],
				'curriculum_id' => $request->data['curriculum']
			]);

			DB::commit();

			return response()->json([
				'title' => 'Success',
				'message' => 'Academics updated!',
			], 200);
		} catch (\Throwable $error) {
			DB::rollback();

			return response()->json([
				'title' => 'Error',
				'message' => 'An error occured while academics updated. Please try again later.',
				'error' => $error->getMessage(),
			], 500);
		}
	}

	public function addSubjects($student, $request)
	{
		$validator = Validator::make(
			$request->only(
				'yearlevel',
				'semester',
				'subjects',
			),
			[
				'yearlevel' => 'required',
				'semester' => 'required',
				'subjects' => 'required',
			]
		);

		if ($validator->fails()) {
			return response()->json([
				'title' => 'Error',
				'message' => 'An error occured while adding subjects. Please try again later.',
				'error' => $validator->errors(),
			], 422);
		}

		DB::beginTransaction();

		try {
			foreach ($request->subjects as $subject) {
				GradedSubject::firstOrCreate([
					'student_id'  	=> $student->id,
					'subject_id' 	 	=> $subject['subject_id'],
					'instructor_id' => $subject['instructor_id']['id'],
					'year_level' 		=> $request->yearlevel,
					'semester' 			=> $request->semester
				]);
			}

			DB::commit();

			return response()->json([
				'title' => 'Success',
				'message' => 'Subjects added!',
			], 200);
		} catch (\Throwable $error) {
			DB::rollback();

			return response()->json([
				'title' => 'Error',
				'message' => 'An error occured while adding subjects. Please try again later.',
				'error' => $error->getMessage(),
			], 500);
		}
	}
}