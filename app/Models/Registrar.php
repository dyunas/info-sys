<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Registrar extends Model
{
	use HasFactory, LaravelVueDatatableTrait;

	protected $guarded = [];

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
}