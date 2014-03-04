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
class InvoicesTableSeeder extends Seeder {
	public function run()
	{
		Eloquent::unguard();

		DB::table('invoices')->truncate();
		DB::table('invoice_items')->truncate();

		$faker = Faker\Factory::create();

		for ($i = 0; $i < 30; $i++)
		{
			$invoice = Invoice::create(array(
				'user_id' => $faker->randomNumber(1,20),
				'due_date' => $faker->dateTimeThisYear,
				'status' => $faker->randomElement(array('Draft', 'Unpaid', 'Paid')),
			));

			InvoiceItem::create(array(
				'invoice_id' => $invoice->id,
				'description' => $faker->sentence,
				'unit_price' => $faker->randomNumber(1, 200),
				'quantity' => $faker->randomNumber(1,2),
			));
		}
	}
}