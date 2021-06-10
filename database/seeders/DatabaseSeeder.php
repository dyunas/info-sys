<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		// seed users table
		$this->call(UsersTableSeeder::class);
		$this->command->info('users seeding completed!');

		// seed roles and permissions table
		$this->call(RolesAndPermissionsTableSeeder::class);
		$this->command->info('users seeding completed!');

		// seed courses table
		$this->call(CoursesTableSeeder::class);
		$this->command->info('courses seeding completed!');

		// seed subjects table
		$this->call(SubjectsTableSeeder::class);
		$this->command->info('courses seeding completed!');
	}
}