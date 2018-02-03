<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		factory(App\Models\User::class, 15)->create();

//		$user            = \App\Models\User::first();
//		$user->username  = 'admin';
//		$user->mobile    = 15766600392;
//		$user->parent_id = 0;
//		$user->password  = bcrypt('admin');
//		$user->save();
//		$user->assignRole('admin');
	}
}
