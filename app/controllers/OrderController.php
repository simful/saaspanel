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


class OrderController extends BaseController
{
	function step1()
	{
		$services = Service::all();

		return View::make('order.step1', array('services' => $services, 'step' => 1));
	}

	function step2()
	{
		if ( ! Input::get('service') )
			return Redirect::to('order');

		$service = Service::find(Input::get('service'));

		if (! $service )
			return Redirect::to('order');

		$options = DB::table('service_options')
			->where('service_id', '=', $service->id)
			->get();

		$cycles = DB::table('billing_cycles')
			->where('service_id', '=', $service->id)
			->get();

		return View::make('order.step2', array(
			'service' => $service,
			'options' => $options,
			'step' => 2,
			'cycles' => $cycles
		));
	}

	function addToCart()
	{
		if ( ! Input::get('option') )
			return Redirect::to('order');

		if ( ! Input::get('cycle') )
			return Redirect::to('order');

		$option = ServiceOption::find(Input::get('option'));
		$service = Service::find($option->service_id);
		$cycle = BillingCycle::find(Input::get('cycle'));

		Cart::insert(array(
			'id' => $option->id,
			'name' => $service->name . ' ' . $option->option_name,
			'price' => $option->base_price,
			'quantity' => $cycle->cycle
		));

		return Redirect::to('order');
	}

	function removeFromCart()
	{
		if ( ! Input::get('id') )
			return json_encode(array('Success' => false));

		Cart::item(Input::get('id'))->remove();

		return json_encode(array('Success' => true));
	}

	function step3()
	{
		return View::make('order.step3', array('step' => 3));
	}

	function step4()
	{
		return View::make('order.step4', array('step' => 4));
	}

	function checkout()
	{
		// process cart items
		if (count(Cart::contents()) < 1)
			return Redirect::to('order');

		$items = Cart::contents();

		$invoice_id = DB::table('invoices')
			->insertGetId(array(
					'user_id' => Auth::user()->id,
					'due_date' => date('Y-m-d'),
					'status' => 'Unpaid'
				));

		foreach ($items as $item)
		{
			// to ensure the shopping cart was not manipulated, we use the option directly, not from the price
			$option = ServiceOption::find($item->id);

			// build description string
			$description = $option->service->name . ' ' . $option->name . ' recurring every ' . $item->quantity . ' month(s)';

			DB::table('invoice_items')
				->insert(array(
						'invoice_id' => $invoice_id,
						'description' => $description,
						'unit_price' => $item->price
					));
		}

		// push invoice to e-mail queue

		// empty the cart
		Cart::destroy();

		return Redirect::to('order/thankyou');
	}

	function thankyou()
	{
		return View::make('order.thankyou');
	}
}