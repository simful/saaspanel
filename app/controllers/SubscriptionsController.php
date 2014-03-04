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

class SubscriptionsController extends RestController {
	public $entity = 'subscriptions';

	function override() {
		$this->set_relation('user_id', 'users', 'username');
		$this->set_relation('service_id', 'services', 'name');
		$this->set_relation('option_id', 'service_options', 'option_name');
		$this->set_relation('billing_cycle_id', 'billing_cycles', 'cycle');
		$this->rules['user_id'] = 'required';
		$this->rules['service_id'] = 'required';
		$this->rules['option_id'] = 'required';
		$this->rules['billing_cycle_id'] = 'required';
		$this->rules['expire_date'] = 'required';
	}
}