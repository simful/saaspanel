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
class ServiceTableSeeder extends Seeder {
	public function run()
	{
		Eloquent::unguard();

		DB::table('services')->truncate();
		DB::table('service_options')->truncate();
		DB::table('billing_cycles')->truncate();

		$faker = Faker\Factory::create();

		$service = Service::create(array(
			'name' => 'Simful Travel',
			'description' => 'Complete solution for travel agents'
		));

		ServiceOption::create(array(
			'service_id' => $service->id,
			'option_name' => 'Economy',
			'base_price' => '15',
			'description' => 'Designed for small, starter agents.'
		));

		ServiceOption::create(array(
			'service_id' => $service->id,
			'option_name' => 'Professional',
			'base_price' => '24',
			'description' => 'Great for small and mid-size agents.'
		));

		ServiceOption::create(array(
			'service_id' => $service->id,
			'option_name' => 'Super',
			'base_price' => '45',
			'description' => 'For mid-size to large agents.'
		));

		ServiceOption::create(array(
			'service_id' => $service->id,
			'option_name' => 'Ultima',
			'base_price' => '125',
			'description' => 'For the enterprise level.'
		));

		BillingCycle::create(array(
			'service_id' => $service->id,
			'cycle' => 3,
			'discount' => 5
		));

		BillingCycle::create(array(
			'service_id' => $service->id,
			'cycle' => 6,
			'discount' => 10
		));

		BillingCycle::create(array(
			'service_id' => $service->id,
			'cycle' => 12,
			'discount' => 20
		));

		BillingCycle::create(array(
			'service_id' => $service->id,
			'cycle' => 24,
			'discount' => 25
		));

		for ($i = 0; $i < 10; $i++)
		{
			$service = Service::create(array(
				'name' => studly_case($faker->domainWord),
				'description' => $faker->sentence,
			));

			ServiceOption::create(array(
				'service_id' => $service->id,
				'option_name' => 'Economy',
				'base_price' => $faker->randomNumber(1, 15),
				'description' => $faker->sentence
			));

			ServiceOption::create(array(
				'service_id' => $service->id,
				'option_name' => 'Professional',
				'base_price' => $faker->randomNumber(16, 35),
				'description' => $faker->sentence
			));

			ServiceOption::create(array(
				'service_id' => $service->id,
				'option_name' => 'Super',
				'base_price' => $faker->randomNumber(36, 100),
				'description' => $faker->sentence
			));

			ServiceOption::create(array(
				'service_id' => $service->id,
				'option_name' => 'Ultima',
				'base_price' => $faker->randomNumber(101, 200),
				'description' => $faker->sentence
			));

			BillingCycle::create(array(
				'service_id' => $service->id,
				'cycle' => 3,
				'discount' => 5
			));

			BillingCycle::create(array(
				'service_id' => $service->id,
				'cycle' => 6,
				'discount' => 10
			));

			BillingCycle::create(array(
				'service_id' => $service->id,
				'cycle' => 12,
				'discount' => 20
			));

			BillingCycle::create(array(
				'service_id' => $service->id,
				'cycle' => 24,
				'discount' => 25
			));
		}
	}
}