<?php

namespace App\Services;

use App\Models\User;
use App\Models\Registrar;
use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class RegistrarTableApiService
{
	public function registrarDataTable(Request $request)
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

		$query->where('roles.name', '=', 'Registrar');
		$data = $query->paginate($length);

		return new DataTableCollectionResource($data);
	}

	public function addNewRegistrar(Request $request)
	{
		$validator = Validator::make(
			$request->only(
				"username",
				"password",
				"email",
				"firstName",
				"middleName",
				"lastName",
			),
			[
				"username" => 'required',
				"password" => 'required|min:4',
				"email" => 'required',
				"firstName" => 'required',
				"middleName" => '',
				"lastName" => 'required',
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

			$registrar = Registrar::create([
				"user_id" => $user->id,
				"first_name"  => $request->firstName,
				"middle_name" => $request->middleName,
				"last_name"   => $request->lastName,
			]);

			$user->syncRoles('Registrar');

			SystemLog::create([
				'user_id' => auth()->user()->id,
				'log'			=> auth()->user()->registrar->first_name . ' ' . auth()->user()->registrar->last_name . ' added registrar ' . $registrar->last_name . ', ' . $registrar->first_name . ' into record.',
			]);

			DB::commit();

			return response()->json([
				'title' => 'Success',
				'message' => 'New registrar added!',
			], 200);
		} catch (\Throwable $error) {
			DB::rollback();

			return response()->json([
				'title' => 'Error',
				'message' => 'An error occured while adding new registrar. Please try again later.',
				'error' => $error->getMessage(),
			], 500);
		}
	}
}