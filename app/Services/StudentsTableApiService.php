<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Student;
use App\Models\SystemLog;
use Illuminate\Http\Request;
use App\Models\GradedSubject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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

	public function count()
	{
		$count = Student::count();

		return response()->json($count, 200);
	}

	public function store(Request $request)
	{
		$validator = Validator::make(
			$request->only(
				'username',
				'password',
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
				'acadYear',
				'subjects',
			),
			[
				'username'	 => 'required',
				'password'	 => 'required',
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
				'acadYear' => 'required',
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

			$user = User::create([
				'username' => $request->username,
				'password' => Hash::make($request->password),
				'email'    => $request->email,
			]);

			$user->assignRole(3);

			$student = Student::create([
				'user_id'					=> $user->id,
				'first_name' 			=> $request->firstName,
				'middle_name' 		=> $request->middleName,
				'last_name' 			=> $request->lastName,
				'gender' 					=> $request->gender,
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
				'acad_year' 	    => $request->acadYear,
			]);

			foreach ($request->subjects as $subject) {
				GradedSubject::create([
					'student_id'  	=> $student->id,
					'subject_id' 	 	=> $subject['subject_id'],
					'instructor_id' => $subject['instructor_id']['id'],
					'year_level' 		=> $request->yearLevel,
					'acad_year'			=> $request->acadYear,
					'semester' 			=> $request->semester,
				]);
			}

			SystemLog::create([
				'user_id' => auth()->user()->id,
				'log'			=> auth()->user()->registrar->first_name . ' ' . auth()->user()->registrar->last_name . ' has registered student ' . $student->first_name . ' ' . $student->last_name . ' into the record.',
			]);

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

	public function updateAcademics($id, $request)
	{
		$validator = Validator::make(
			$request->only(
				'data.yearLevel',
				'data.acadYear',
				'data.semester',
				'data.course',
				'data.curriculum'
			),
			[
				'data.yearLevel' => 'required',
				'data.acadYear' => 'required',
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
			$student = Student::find($id);
			$student->update([
				'year_level' => $request->data['yearLevel'],
				'semester' => $request->data['semester'],
				'course_id' => $request->data['course'],
				'curriculum_id' => $request->data['curriculum'],
				'acad_year' => $request->data['acadYear']
			]);

			SystemLog::create([
				'user_id' => auth()->user()->id,
				'log'			=> auth()->user()->registrar->first_name . ' ' . auth()->user()->registrar->last_name . ' has updated the academic records of student ' . $student->first_name . ' ' . $student->last_name,
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

	public function addSubjects($id, $request)
	{
		$validator = Validator::make(
			$request->only(
				'yearlevel',
				'semester',
				'acadYear',
				'subjects',
			),
			[
				'yearlevel' => 'required',
				'semester' => 'required',
				'acadYear' => 'required',
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
			$student = Student::find($id);

			foreach ($request->subjects as $subject) {
				GradedSubject::firstOrCreate([
					'student_id'  	=> $student->id,
					'subject_id' 	 	=> $subject['subject_id'],
					'instructor_id' => $subject['instructor_id']['id'],
					'year_level' 		=> $request->yearlevel,
					'acad_year' 		=> $request->acadYear,
					'semester' 			=> $request->semester
				]);
			}

			SystemLog::create([
				'user_id' => auth()->user()->id,
				'log'			=> auth()->user()->registrar->first_name . ' ' . auth()->user()->registrar->last_name . ' has added subjects to student ' . $student->first_name . ' ' . $student->last_name,
			]);

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

	public function show($id)
	{
		$student = User::query()
			->where('id', $id)
			->with('student', 'student.courses', 'student.curriculums', 'student.graded_subjects', 'student.graded_subjects.subjects')
			->get();

		return response()->json($student, 200);
	}

	public function update($id, $request)
	{
		DB::beginTransaction();

		try {
			$age = Carbon::parse($request->data['bdate'])->age;

			$student = Student::find($id);
			$student->update([
				'first_name' 			=> $request->data['firstName'],
				'middle_name' 		=> $request->data['middleName'],
				'last_name' 			=> $request->data['lastName'],
				'gender' 					=> $request->data['gender'],
				'bdate' 					=> $request->data['bdate'],
				'age' 						=> $age,
				'email' 					=> $request->data['email'],
				'contact_number'  => $request->data['contactNumber'],
				'address' 				=> $request->data['address'],
				'province' 				=> $request->data['province'],
				'municipal' 			=> $request->data['municipal'],
				'barangay' 				=> $request->data['barangay'],
			]);

			SystemLog::create([
				'user_id' => auth()->user()->id,
				'log'			=> auth()->user()->registrar->first_name . ' ' . auth()->user()->registrar->last_name . ' has updated information of student ' . $student->first_name . ' ' . $student->last_name,
			]);

			DB::commit();

			return response()->json([
				'title' => 'Success',
				'message' => 'Information updated!',
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
}