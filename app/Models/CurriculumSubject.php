<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurriculumSubject extends Model
{
	use HasFactory;

	protected $table = 'curriculum_subject';

	protected $guarded = [];
}