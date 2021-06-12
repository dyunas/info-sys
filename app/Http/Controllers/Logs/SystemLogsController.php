<?php

namespace App\Http\Controllers\Logs;

use App\Http\Controllers\Controller;
use App\Services\SystemLogsApiService;
use Illuminate\Http\Request;

class SystemLogsController extends Controller
{
	public function index()
	{
		return view('logs.system-logs.index');
	}
}