<?php

namespace App\Http\Controllers\API\AcademicYear;

use App\Http\Controllers\Controller;
use App\Services\AcademicYearTableApiService;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(AcademicYearTableApiService $acadYearService, Request $request)
	{
		if (count($request->all()) > 0) {
			return $acadYearService->academicYearDataTable($request);
		}

		return $acadYearService->getListOfAcademicYear();
	}

	public function current_academic_year(AcademicYearTableApiService $acadYearService)
	{
		return $acadYearService->currentAcademicYear();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(AcademicYearTableApiService $acadYearService, Request $request)
	{
		return $acadYearService->addAcademicYear($request);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
}