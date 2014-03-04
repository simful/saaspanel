<?php

use Zizaco\Confide\ConfideUser;

class User extends ConfideUser {
	public function profile() {
		return $this->hasOne('Profile', 'id');
	}
}