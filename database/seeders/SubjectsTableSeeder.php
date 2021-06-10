<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('subjects')->delete();

		$subjects = [
			[
				'name'  	   => 'Introduction to Computing',
				'code'			 => 'CIN 111',
				'units'   	 => 3,
				'pre_req' 	 => 'N/A',
				'year_level' => 1,
				'semester'   => 'First Semester'
			],
			[
				'name'  	   => 'Computer Programming 1',
				'code'			 => 'CCP 111',
				'units'   	 => 2,
				'pre_req' 	 => 'N/A',
				'year_level' => 1,
				'semester'   => 'First Semester'
			],
		];

		foreach ($subjects as $subject) {
			Subject::create($subject);
		}
	}
}