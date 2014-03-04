<?php
/**
*    Copyright (C) 2014 Ibrahim Yusuf <ibrahim7usuf@gmail.com>.
*
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU Affero General Public License, version 3,
*    as published by the Free Software Foundation.
*
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU Affero General Public License for more details.
*
*    You should have received a copy of the GNU Affero General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
*/
class UserTableSeeder extends Seeder {
	public function run()
	{
		DB::table('users')->truncate();
		DB::table('profiles')->truncate();

		$faker = Faker\Factory::create();

		$adminId = DB::table('users')->insertGetId(array(
			'username' => 'admin',
			'password' => Hash::make('admin'),
			'email' => 'admin@saaspanel.org',
			'confirmed' => true,
			'role' => 'Admin',
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		Profile::create(array(
				'id' => $adminId,
				'full_name' => $faker->name,
				'address' => $faker->address,
				'city' => $faker->city,
				'country' => $faker->country,
				'phone' => $faker->phoneNumber,
				'company' => $faker->company,
			));

		$clientId = DB::table('users')->insertGetId(array(
			'username' => 'client',
			'password' => Hash::make('client'),
			'email' => 'client@saaspanel.org',
			'confirmed' => true,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		Profile::create(array(
				'id' => $clientId,
				'full_name' => $faker->name,
				'address' => $faker->address,
				'city' => $faker->city,
				'country' => $faker->country,
				'phone' => $faker->phoneNumber,
				'company' => $faker->company,
			));

		for ($i = 1; $i <= 20; $i++)
		{
			$user = DB::table('users')->insertGetId(array(
				'username' => $faker->username,
				'password' => Hash::make('test'),
				'email' => $faker->email,
				'confirmed' => true,
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			));

			Profile::create(array(
				'id' => $user,
				'full_name' => $faker->name,
				'address' => $faker->address,
				'city' => $faker->city,
				'country' => $faker->country,
				'phone' => $faker->phoneNumber,
				'company' => $faker->company,
			));
		}
	}
}