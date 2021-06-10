<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class User extends Authenticatable
{
	use HasFactory, Notifiable, HasRoles, LaravelVueDatatableTrait;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'username',
		'email',
		'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	protected $dataTableColumns = [
		'id' => [
			'searchable' => false,
		],
		'username' => [
			'searchable' => true,
		],
		'email' => [
			'searchable' => true,
		]
	];

	protected $dataTableRelationships = [
		"belongsToMany" => [
			"roles" => [
				"model" => \Spatie\Permission\Models\Role::class,
				"foreign_key" => "role_id",
				"pivot" => [
					"table_name" => "model_has_roles",
					"primary_key" => "id",
					"foreign_key" => "role_id",
					"local_key" => "model_id",
				],
				"order_by" => "name",
				"columns" => [
					"name" => [
						"searchable" => true,
						"orderable" => true,
					]
				],
			]
		],
	];

	public function registrar()
	{
		return $this->hasOne(Registrar::class);
	}

	public function instructor()
	{
		return $this->hasOne(Instructor::class);
	}

	public function student()
	{
		return $this->hasOne(Student::class);
	}

	public function system_logs()
	{
		return $this->hasMany(SystemLog::class);
	}
}