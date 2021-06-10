<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Instructor extends Model
{
	use HasFactory, LaravelVueDatatableTrait;

	protected $guarded = [];

	protected $dataTableColumns = [
		"id" => [
			"searchable" => true,
		],
		"first_name" => [
			"searchable" => true,
		],
		"middle_name" => [
			"searchable" => true,
		],
		"last_name" => [
			"searchable" => true,
		]
	];

	protected $dataTableRelationships = [
		"belongsToMany" => [
			"subjects" => [
				"model" => \App\Models\Subject::class,
				"foreign_key" => "subject_id",
				"pivot" => [
					"table_name" => "instructor_subject",
					"primary_key" => "id",
					"foreign_key" => "subject_id",
					"local_key" => "instructor_id",
				],
				"order_by" => "name",
				"columns" => [
					"id" => [
						"searchable" => true,
						"orderable" => true,
					],
					"name" => [
						"searchable" => true,
						"orderable" => true,
					],
					"code" => [
						"searchable" => true,
						"orderable" => true,
					],
					"units" => [
						"searchable" => true,
						"orderable" => true,
					],
					"pre_req" => [
						"searchable" => true,
						"orderable" => true,
					],
					"year_level" => [
						"searchable" => true,
						"orderable" => true,
					],
					"semester" => [
						"searchable" => true,
						"orderable" => true,
					],
				],
			],
		]
	];

	/**
	 * All of the relationships to be touched.
	 *
	 * @var array
	 */
	protected $touches = ['user'];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function subjects()
	{
		return $this->belongsToMany(Subject::class);
	}
}