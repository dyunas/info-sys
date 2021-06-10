<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Student extends Model
{
	use HasFactory, LaravelVueDatatableTrait;

	protected $guarded = [];

	protected $dataTableColumns = [
		'id' => [
			'searchable' => false,
		],
		'first_name' => [
			'searchable' => true,
		],
		'middle_name' => [
			'searchable' => true,
		],
		'last_name' => [
			'searchable' => true,
		],
		'year_level' => [
			'searchable' => true,
		],
		'semester' => [
			'searchable' => true,
		]
	];

	protected $dataTableRelationships = [
		"belongsTo" => [
			"courses" => [
				"model" => \App\Models\Course::class,
				"foreign_key" => "course_id",
				"columns" => [
					"school_year" => [
						"searchable" => true,
						"orderable" => true,
					]
				],
			],
			"curriculums" => [
				"model" => \App\Models\Curriculum::class,
				"foreign_key" => "curriculum_id",
				"columns" => [
					"school_year" => [
						"searchable" => true,
						"orderable" => true,
					]
				],
			],
		],
	];

	public function curriculums()
	{
		return $this->belongsTo(Curriculum::class, 'curriculum_id', 'id');
	}

	public function courses()
	{
		return $this->belongsTo(Course::class, 'course_id', 'id');
	}

	public function graded_subjects()
	{
		return $this->hasMany(GradedSubject::class);
	}
}