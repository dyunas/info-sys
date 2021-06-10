<?php

namespace App\Http\Controllers\Curriculum;

use App\Models\Curriculum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CurriculumController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('curriculum.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('curriculum.create');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Curriculum  $curriculum
	 * @return \Illuminate\Http\Response
	 */
	public function show(Curriculum $curriculum)
	{
		return view('curriculum.show', compact('curriculum'));
	}

	public function addSubjects(Curriculum $curriculum)
	{
		return view('curriculum.subjects.create', compact('curriculum'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Curriculum  $curriculum
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Curriculum $curriculum)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Curriculum  $curriculum
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Curriculum $curriculum)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Curriculum  $curriculum
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Curriculum $curriculum)
	{
		//
	}
}