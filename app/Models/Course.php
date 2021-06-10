<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Course extends Model
{
	use HasFactory, LaravelVueDatatableTrait;

	protected $guarded = [];

	protected $dataTableColumns = [
		'id' => [
			'searchable' => false,
		],
		'course_name' => [
			'searchable' => true,
		],
		'code' => [
			'searchable' => true,
		],
		'year_levels' => [
			'searchable' => true,
		]
	];

	public function curriculum()
	{
		return $this->hasMany(Curriculum::class);
	}

	public function students()
	{
		return $this->hasMany(Student::class);
	}
}