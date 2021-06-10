<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Reset cached roles and permissions
		app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

		DB::table('permissions')->delete();
		DB::table('roles')->delete();

		$permissions = [
			[
				'id'   => 1,
				'name' => 'Add students',
				'guard_name' => 'web'
			],
			[
				'id'    => 2,
				'name' => 'Edit students',
				'guard_name' => 'web'
			],
			[
				'id'    => 3,
				'name' => 'View students',
				'guard_name' => 'web'
			],
			[
				'id'    => 4,
				'name' => 'Add users',
				'guard_name' => 'web'
			],
			[
				'id'    => 5,
				'name' => 'Edit users',
				'guard_name' => 'web'
			],
			[
				'id'    => 6,
				'name' => 'View users',
				'guard_name' => 'web'
			],
			[
				'id'    => 7,
				'name' => 'Add academic year',
				'guard_name' => 'web'
			],
			[
				'id'    => 8,
				'name' => 'Add curriculum',
				'guard_name' => 'web'
			],
			[
				'id'    => 9,
				'name' => 'Edit curriculum',
				'guard_name' => 'web'
			],
			[
				'id'    => 10,
				'name' => 'Add subjects',
				'guard_name' => 'web'
			],
			[
				'id'    => 11,
				'name' => 'Edit subjects',
				'guard_name' => 'web'
			],
			[
				'id'    => 12,
				'name' => 'Add courses',
				'guard_name' => 'web'
			],
			[
				'id'    => 13,
				'name' => 'Edit courses',
				'guard_name' => 'web'
			],
			[
				'id'    => 14,
				'name' => 'View account',
				'guard_name' => 'web'
			],
			[
				'id'    => 15,
				'name' => 'Update account',
				'guard_name' => 'web'
			],
			[
				'id' => 16,
				'name' => 'View grades',
				'guard_name' => 'web'
			],
			[
				'id' => 17,
				'name' => 'Update grades',
				'guard_name' => 'web'
			],
			[
				'id' => 18,
				'name' => 'Generate transcript',
				'guard_name' => 'web'
			],
		];

		/** create role by reiterating through the roles array
		 * 
		 * @var = $roles
		 */
		foreach ($permissions as $permission) {
			Permission::create($permission);
		}

		Role::create([
			'name' => 'Admin',
			'guard_name' => 'web'
		])->givePermissionTo(Permission::all());

		Role::create([
			'name' => 'Instructor',
			'guard_name' => 'web'
		])->givePermissionTo(
			'View students',
			'View grades',
			'Update grades',
			'View account',
			'Update account',
		);

		Role::create([
			'name' => 'Student',
			'guard_name' => 'web'
		])->givePermissionTo(
			'View account',
			'Update account',
			'View grades'
		);
	}
}