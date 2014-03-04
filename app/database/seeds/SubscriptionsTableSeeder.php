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
class SubscriptionsTableSeeder extends Seeder {
	public function run()
	{
		$faker = Faker\Factory::create();

		DB::table('subscriptions')->truncate();

		for ($i = 0; $i < 60; $i++)
		{
			Subscription::create(array(
				'user_id' => $faker->randomNumber(1,20),
				'service_id' => $faker->randomNumber(1,1),
				'option_id' => $faker->randomNumber(1,4),
				'billing_cycle_id' => $faker->randomNumber(1,4),
				'expire_date' => $faker->dateTimeThisYear,
				'status' => $faker->randomElement(array('Active', 'Stopped', 'Inactive', 'Cancelled'))
			));
		}
	}
}