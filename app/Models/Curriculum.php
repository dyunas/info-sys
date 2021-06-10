<?php

namespace App\Models;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Curriculum extends Model
{
	use HasFactory, LaravelVueDatatableTrait;

	protected $guarded = [];

	protected $table = 'curriculums';

	protected $dataTableColumns = [
		"id" => [
			"searchable" => true,
		],
		"school_year" => [
			"searchable" => true,
		],
	];

	protected $dataTableRelationships = [
		"belongsTo" => [
			"course" => [
				"model" => \App\Models\Course::class,
				"foreign_key" => "course_id",
				"columns" => [
					"course_name" => [
						"searchable" => true,
						"orderable" => true,
					],
					"code" => [
						"searchable" => true,
						"orderable" => true,
					]
				],
			],
		],
	];

	public function course()
	{
		return $this->belongsTo(Course::class);
	}

	public function subjects()
	{
		return $this->belongsToMany(Subject::class)->withPivot('year_level', 'semester')->withTimestamps();
	}

	public function students()
	{
		return $this->hasMany(Student::class);
	}
}