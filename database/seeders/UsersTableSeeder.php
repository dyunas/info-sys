<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('users')->delete();

		$users = [
			[
				'username'       => 'juan.delacruz',
				'password'       => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
				'email'     		 => 'juan.delacruz@gmail.com',
			],
		];

		/** create user by reiterating through the users array
		 * 
		 * @var = $users
		 */
		foreach ($users as $user) {
			User::create($user);
		}
	}
}