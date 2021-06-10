<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('courses')->delete();

		$courses = [
			[
				'course_name' => 'Associate in Computer Technology',
				'code' => 'ACT',
				'year_levels' => 2
			],
			[
				'course_name' => 'Bachelor of Science in Information Technology',
				'code' => 'BSIT',
				'year_levels' => 4
			],
			[
				'course_name' => 'Bachelor of Science in Accountancy',
				'code' => 'BSA',
				'year_levels' => 4
			]
		];

		foreach ($courses as $course) {
			Course::create($course);
		}
	}
}