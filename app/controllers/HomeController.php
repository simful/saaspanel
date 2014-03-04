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

class HomeController extends BaseController {

	public function statistics()
	{
		$data['users_total'] = DB::table('users')->whereRole('Client')->count();
		$data['users_new'] = DB::table('users')->whereRole('Client')->where('created_at', '>=', date('Y-m-') . '01')->count();
		
		$data['users_active'] = DB::table('subscriptions')
			->whereStatus('Active')
			->groupBy('user_id')
			->count();

		if ($data['users_active'] == null)
			$data['users_active'] = 0;
		
		$data['users_inactive'] = $data['users_total'] - $data['users_active'];
		
		$data['invoices_total'] = DB::table('invoices')->count();
		$data['invoices_outstanding'] = DB::table('invoices')->where('status', '<>', 'Paid')->count();
		$data['invoices_paid'] = DB::table('invoices')->where('status', '=', 'Paid')->count();
		$data['invoices_new'] = DB::table('invoices')->where('created_at', '>=', date('Y-m-') . '01')->count();

		$data['tickets_total'] = DB::table('tickets')->count();
		$data['tickets_open'] = DB::table('tickets')->where('status', '=', 'Open')->count();
		$data['tickets_closed'] = DB::table('tickets')->where('status', '=', 'Closed')->count();
		
		// TODO tickets new replies
		$data['tickets_unread'] = DB::table('tickets')->count(); 

		$data['subscriptions'] = DB::table('subscriptions')->count();
		// TODO subscription details
		$data['subscription_types'] = array();
		// TODO estimated income in next month
		$data['estimated_income_next_month'] = 0;
		// TODO estimated income in next year
		$data['estimated_income_next_year'] = 0;
		// TODO avg monthly income
		$data['avg_monthly_income'] = 0;
		// TODO avg annual income
		$data['avg_annual_income'] = 0;

		// TODO this month's performance
		$data['month_performance'] = 0;
		$data['annual_performance'] = 0;

		$data['activities'] = DB::table('activities')
			->join('users', 'users.id', '=', 'activities.user_id')
			->orderBy('created_at', 'desc')
			->take(15)
			->get(array('activities.*', 'users.username as actor', DB::raw('if(users.role = \'Admin\', 1, null) as admin')));

		return json_encode($data);
	}

}