<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Subject extends Model
{
	use HasFactory, LaravelVueDatatableTrait;

	protected $guarded = [];

	protected $dataTableColumns = [
		"id" => [
			"searchable" => true,
		],
		"name" => [
			"searchable" => true,
		],
		"code" => [
			"searchable" => true,
		],
		"units" => [
			"searchable" => true,
		],
		"pre_req" => [
			"searchable" => true,
		],
		"year_level" => [
			"searchable" => true,
		],
		"semester" => [
			"searchable" => true,
		]
	];

	protected $dataTableRelationships = [
		"belongsToMany" => [
			"instructors" => [
				"model" => \App\Models\Instructor::class,
				"foreign_key" => "instructor_id",
				"pivot" => [
					"table_name" => "instructor_subject",
					"primary_key" => "id",
					"foreign_key" => "instructor_id",
					"local_key" => "subject_id",
				],
				"order_by" => "id",
				"columns" => [
					"first_name" => [
						"searchable" => true,
						"orderable" => true,
					],
					"last_name" => [
						"searchable" => true,
						"orderable" => true,
					],
				],
			],
		]
	];

	public function curriculums()
	{
		return $this->belongsToMany(Curriculum::class)->withPivot('year_level', 'semester')->withTimestamps();
	}

	public function instructors()
	{
		return $this->belongsToMany(Instructor::class);
	}
}