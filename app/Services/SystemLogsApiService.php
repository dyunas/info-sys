<?php

namespace App\Services;

use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class SystemLogsApiService
{
	public function getSystemLogsDataTable(Request $request)
	{
		$length = $request->input('length');
		$sortBy = $request->input('column');
		$orderBy = $request->input('dir');
		$searchValue = $request->input('search');

		$query = SystemLog::select('id', 'log', DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %h:%i %p") as log_date'))
			->orderBy($sortBy, $orderBy)
			->whereRaw('
					CASE
						WHEN id LIKE "%' . $searchValue . '%" THEN 1
						WHEN log LIKE "%' . $searchValue . '%" THEN 1
						WHEN created_at LIKE "%' . $searchValue . '%" THEN 1
						ELSE 0
					END
			');

		$data = $query->paginate($length);

		return new DataTableCollectionResource($data);

		$data = $query->paginate($length);

		return new DataTableCollectionResource($data);
	}
}