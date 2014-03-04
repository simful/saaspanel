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

class CampaignsController extends RestController {
	public $entity = 'campaigns';

	function override() {
		$this->set_relation('template_id', 'templates', 'name');
		$this->rules['title'] = 'required';
		$this->rules['description'] = 'required';
		$this->rules['template_id'] = 'required';
	}
}