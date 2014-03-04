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
class TicketsTableSeeder extends Seeder {
	public function run()
	{
		$faker = Faker\Factory::create();

		DB::table('tickets')->truncate();
		DB::table('departments')->truncate();

		Department::create(array(
			'name' => 'Support'
		));

		Department::create(array(
			'name' => 'Sales'
		));

		for ($i = 0; $i < 60; $i++)
		{
			Ticket::create(array(
				'user_id' => $faker->randomNumber(1,20),
				'department_id' => $faker->randomNumber(1,2),
				'title' => $faker->sentence,
				'message' => $faker->paragraph,
				'status' => $faker->randomElement(array('Open', 'Closed'))
			));
		}
	}
}