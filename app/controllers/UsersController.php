<?php
class UsersController extends RestController {
	public $entity = 'users';

	function override() {
		$this->rules['username'] = 'required';
		$this->rules['email'] = 'required';
		$this->rules['password'] = 'required';
		$this->rules['confirmed'] = 'required';
		$this->rules['role'] = 'required';
	}
}