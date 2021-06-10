<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class AcademicYear extends Model
{
	use HasFactory, LaravelVueDatatableTrait;

	protected $guarded = [];
}