<?php
class TicketsController extends RestController {
	public $entity = 'tickets';

	function override() {
		$this->set_relation('user_id', 'users', 'username');
		$this->set_relation('department_id', 'departments', 'name');
		$this->rules['user_id'] = 'required';
		$this->rules['department_id'] = 'required';
		$this->rules['title'] = 'required';
		$this->rules['message'] = 'required';
		$this->rules['status'] = 'required';
	}
}