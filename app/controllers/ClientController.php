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

class ClientController extends BaseController
{
	function dashboard()
	{
		$subscriptions = Subscription::whereUserId(Auth::user()->id)->get();
		$tickets = Ticket::whereUserId(Auth::user()->id)->get();

		return View::make('client.dashboard', array('subscriptions' => $subscriptions, 'tickets' => $tickets));
	}

	function invoices()
	{
		$invoices = DB::table('invoices')
			->whereUserId(Auth::user()->id)
			->where('status', '<>', 'Draft')
			->get();

		return View::make('client.invoices', array('invoices' => $invoices));
	}

	function viewInvoice($id)
	{
		$invoice = DB::table('invoices')
			->where('invoices.id', '=', $id)
			->whereUserId(Auth::user()->id)
			->join('users', 'users.id', '=', 'invoices.user_id')
			->select('invoices.*', 'users.username as username')
			->first();

		if ( ! $invoice )
		{
			return Response::error('404');
		}
		else
		{
			$items = DB::table('invoice_items')
				->whereInvoiceId($id)
				->get();
		}

		return View::make('client.view-invoice', array('invoice' => $invoice, 'items' => $items));
	}

	function tickets()
	{
		$tickets = DB::table('tickets')
			->whereUserId(Auth::user()->id)
			->get();

		return View::make('client.tickets', array('tickets' => $tickets));
	}

	function viewTicket($id)
	{
		$ticket = DB::table('tickets')
			->whereUserId(Auth::user()->id)
			->where('tickets.id', '=', $id)
			->join('users', 'users.id', '=', 'tickets.user_id')
			->select('tickets.*', 'users.username as username')
			->first();

		if ( ! $ticket )
		{
			return Response::error('404');
		}
		else
		{
			$replies = DB::table('ticket_replies')
				->whereTicketId($id)
				->join('users', 'users.id', '=', 'ticket_replies.user_id')
				->select('ticket_replies.*', 'users.username as username')
				->get();
		}

		return View::make('client.view-ticket', array('ticket' => $ticket, 'replies' => $replies));
	}

	function newTicket()
	{
		return View::make('client.new-ticket');
	}

	function sendTicket()
	{
		$input = Input::get();
		$rules = array('title' => 'required', 'message' => 'required');

		$v = Validator::make($input, $rules);

		if ($v->passes())
		{
			$id = DB::table('tickets')
				->insertGetId(array(
					'department_id' => $input['department_id'],
					'title' => $input['title'],
					'message' => $input['message'],
					'user_id' => Auth::user()->id
				));

			Event::fire('activity', array(
				'message' => 'created ticket ' . $id . '.'
			));

			return Redirect::back();
		}
		else
		{
			return Redirect::back();
		}
	}

	function replyTicket()
	{
		// TODO ensure the ticket is right

		$input = Input::get();
		$rules = array('message' => 'required');

		$v = Validator::make($input, $rules);

		if ($v->passes())
		{
			DB::table('ticket_replies')
				->insert(array(
						'ticket_id' => $input['ticket_id'],
						'user_id' => Auth::user()->id,
						'message' => $input['message']
					));

			Event::fire('activity', array(
				'message' => 'replied to ticket ' . $input['ticket_id'] . '.'
			));

			return Redirect::back();
		}
		else
		{
			return Redirect::back();
		}

	}

	function closeTicket()
	{
		$id = Input::get('ticket_id');

		if ( ! $id )
			return Redirect::back();

		DB::table('tickets')
			->where('id', $id)
			->update(array('status' => 'Closed'));

		Event::fire('activity', array(
			'message' => 'closed ticket ' . $id . '.'
		));

		return Redirect::back();
	}

	function reopenTicket()
	{
		$id = Input::get('ticket_id');

		if ( ! $id )
			return Redirect::back();

		DB::table('tickets')
			->where('id', $id)
			->update(array('status' => 'Open'));

		Event::fire('activity', array(
			'message' => 'reopened ticket ' . $id . '.'
		));

		return Redirect::back();
	}

	function subscriptions()
	{
		$subscriptions = Subscription::whereUserId(Auth::user()->id)->get();

		return View::make('client.subscriptions', array('subscriptions' => $subscriptions));
	}

	function viewSubscription($id)
	{
		$subscription = DB::table('subscriptions')
			->whereUserId(Auth::user()->id)
			->whereId($id);

		if ( ! $subscription )
		{
			return Response::error('404');
		}

		return View::make('client.view-subscription', array('subscription' => $subscription));
	}

	function paymentMethods()
	{
		$cards = DB::table('cards')->whereUserId(Auth::user()->id)->get();

		return View::make('client.payment-methods', array('cards' => $cards));
	}

}