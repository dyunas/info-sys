<?php

namespace App\Services;

use App\Models\SystemLog;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class AcademicYearTableApiService
{
	public function academicYearDataTable(Request $request)
	{
		$length = $request->input('length');
		$sortBy = $request->input('column');
		$searchValue = $request->input('search');

		$query = AcademicYear::eloquentQuery($sortBy, 'desc', $searchValue);

		$data = $query->paginate($length);

		return new DataTableCollectionResource($data);
	}

	public function currentAcademicYear()
	{
		$academicYear = AcademicYear::latest('created_at')->first();

		return response()->json($academicYear, 200);
	}

	public function getListOfAcademicYear()
	{
		return response()->json(AcademicYear::select('id', 'from', 'to')->get(), 200);
	}

	public function addAcademicYear(Request $request)
	{
		$validator = Validator::make(
			$request->only(
				'from',
				'to'
			),
			[
				'from' => 'required',
				'to' => 'required',
			]
		);

		if ($validator->fails()) {
			return response()->json([
				'title' => 'Error',
				'message' => 'An error occured while adding academic year. Please try again later.',
				'error' => $validator->errors(),
			], 422);
		}

		DB::beginTransaction();

		try {
			$acad = AcademicYear::create([
				'from' => $request->from,
				'to' => $request->to
			]);

			SystemLog::create([
				'user_id' => auth()->user()->id,
				'log'			=> auth()->user()->registrar->first_name . ' ' . auth()->user()->registrar->last_name . ' created academic year ' . $acad->from . ' - ' . $acad->to,
			]);

			DB::commit();

			return response()->json([
				'title' => 'Success',
				'message' => 'New academic year added!',
			], 200);
		} catch (\Throwable $error) {
			DB::rollback();

			return response()->json([
				'title' => 'Error',
				'message' => 'An error occured while adding academic year. Please try again later.',
				'error' => $error->getMessage(),
			], 500);
		}
	}
}