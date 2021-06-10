<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class UserTableApiService
{
	public function userDataTable(Request $request)
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

		$data = $query->paginate($length);

		return new DataTableCollectionResource($data);
	}

	public function showUserInfo($user)
	{
		//
	}
}