<?php

namespace App\Services;

use App\Models\Subject;
use App\Models\SystemLog;
use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Models\GradedSubject;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class InstructorSubjectTableApiService
{
	public function subjectsDataTable($id, Request $request)
	{
		$length = $request->input('length');
		$sortBy = $request->input('column');
		$orderBy = $request->input('dir');
		$searchValue = $request->input('search');

		$query = Subject::eloquentQuery(
			$sortBy,
			$orderBy,
			$searchValue,
			[
				'instructors'
			]
		);

		$query->where('instructors.id', $id);

		$data = $query->paginate($length);

		return new DataTableCollectionResource($data);
	}

	public function getStudentList(Request $request)
	{
		$list = GradedSubject::query()
			->where('instructor_id', $request->instructor)
			->where('subject_id', $request->subject)
			->with(['students:id,first_name,last_name,middle_name'])
			->get();

		return $list;
	}

	public function updateGrades(Request $request)
	{
		try {
			$graded = GradedSubject::where('id', $request->data['id'])
				->update(
					[
						'prelim' => $request->data['prelim'],
						'midterm' => $request->data['midterm'],
						'final' => $request->data['final'],
						'GPA' => $request->data['GPA'],
						'is_locked' => isset($request->data['locked']) ? $request->data['locked'] : 0,
					]
				);

			$student = Student::find($graded->student_id);

			SystemLog::create([
				'user_id' => auth()->user()->id,
				'log'			=> auth()->user()->instructor->first_name . ' ' . auth()->user()->instructor->last_name . ' updated grade of student ' . $student->last_name . ', ' . $student->first_name,
			]);

			return response()->json([
				'title' => 'Success',
				'message' => 'Saved!',
			], 200);
		} catch (\Throwable $error) {
			return response()->json([
				'title' => 'Error',
				'message' => 'An error occured while saving. Please try again later.',
				'error' => $error->getMessage(),
			], 500);
		}
	}
}