<?php

namespace App\Http\Controllers\API\Logs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SystemLogsApiService;

class SystemLogsController extends Controller
{
	public function index(SystemLogsApiService $systemLogService, Request $request)
	{
		return $systemLogService->getSystemLogsDataTable($request);
	}
}