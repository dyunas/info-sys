<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class SystemLog extends Model
{
	use HasFactory, LaravelVueDatatableTrait;

	protected $guarded = [];

	protected $dataTableColumns = [
		'id' => [
			'searchable' => false,
		],
		'log' => [
			'searchable' => true,
		],
		'created_at' => [
			'searchable' => true,
		]
	];

	protected $dataTableRelationships = [
		"belongsTo" => [
			"users" => [
				"model" => \App\Models\User::class,
				"foreign_key" => "user_id",
				"columns" => [
					"id" => [
						"searchable" => true,
						"orderable" => true,
					]
				],
			],
		],
	];

	public function users()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
}