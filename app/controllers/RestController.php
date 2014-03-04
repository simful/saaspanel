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

class RestController extends \BaseController {

	public $entity = null;
	public $view_dir = null;
	public $model = null;
	public $subject = null;
	public $rules = array();
	public $per_page = 15;
	public $children = array();

	protected $relations = array();

	/**
	 * Initializes RestController with assumed default values.
	 */
	protected function init() {
		if ( ! $this->entity )
			throw new Exception('Entity must be defined');

		if ( ! $this->view_dir)
			$this->view_dir = $this->entity;

		if ( ! $this->model )
			$this->model = DB::table($this->entity);

		if ( ! $this->subject )
			$this->subject = Str::singular($this->entity);

		$this->override();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->init();

		$query = $this->model;

		$columns = array();
		$columns[] = $this->entity . '.*';

		foreach ($this->relations as $field => $relation)
		{
			$query->leftJoin($relation->table, $this->entity . '.' . $field, '=', $relation->table . '.' . 'id');
			$columns[] = $relation->table . '.' . $relation->display . ' AS ' . str_replace('_id', '', $field);
		}

		if (Input::get('term'))
		{
			$query->where(Input::get('col'), 'LIKE', '%' . Input::get('term') . '%');
		}

		if (Input::get('limit'))
		{
			$query->take(Input::get('limit'));
		}

		if (Input::get('offset'))
		{
			$query->skip(Input::get('offset'));
		}

		// search parameter for valid field names...
		foreach (Input::get() as $name => $value)
		{
			if ( ! in_array(strtolower($name), ['term', 'limit', 'offset', 'dt', 'col', '_']))
			{
				$query->where($name, '=', $value);
			}
		}

		$data = $query->get($columns);

		if (Input::get('dt') == 1)
			return Response::json(array('aaData' => $data));

		return Response::json($data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$this->init();

		$input = Input::get();
		$v = $this->validate($input);

		if ($v->passes()) {
			unset($input['_token']);
			$id = $this->model->insertGetId($input);
			$data = $this->model->find($id);

			Event::fire('activity', array(
				'message' => 'created a new ' . Str::singular($this->subject) . '.'
			));

			return Response::json($data);
		}
		else
			return Response::json($v->messages()->toJson());
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$this->init();

		$query = $this->model;

		$columns = array();
		$columns[] = $this->entity . '.*';

		foreach ($this->relations as $field => $relation)
		{
			$query->leftJoin($relation->table, $this->entity . '.' . $field, '=', $relation->table . '.' . 'id');
			$columns[] = $relation->table . '.' . $relation->display . ' AS ' . str_replace('_id', '', $field);
		}

		$data = $query->where($this->entity . '.id', '=', $id)->first($columns);

		foreach ($this->relations as $field => $relation)
		{
			$query->leftJoin($relation->table, $this->entity . '.' . $field, '=', $relation->table . '.' . 'id');
			$columns[] = $relation->table . '.' . $relation->display . ' AS ' . str_replace('_id', '', $field);
		}

		foreach ($this->children as $table => $properties)
		{
			$data->$table = DB::table($table)
				->where($properties['key'], '=', $id)
				->lists('id');
				//->get();
		}

		return Response::json($data);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$this->init();

		$input = Input::get();
		$v = $this->validate($input);

		unset($input['_method']);
		unset($input['_token']);

		if ($v->passes()) {
			$this->model->whereId($id)->update($input);
			$data = $this->model->find($id);

			Event::fire('activity', array(
				'message' => 'edited ' . Str::singular($this->subject) . ' ' . $id . '.'
			));

			return Response::json($data);
		}
		else
			return Response::json($v->messages()->toJson());
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->init();

		$data = $this->model->find($id);
		$this->model->whereId($id)->delete();

		Event::fire('activity', array(
			'message' => 'deleted ' . Str::singular($this->subject) . ' ' . $id . '.'
		));

		return json_encode(array('success' => true, 'data' => $data));
	}

	/**
	 * Validator before insert and update.
	 */
	protected function validate($input)
	{
		return Validator::make($input, $this->rules);
	}

	public function override() {}

	public function set_relation($field_name, $related_table, $display_field)
	{
		$this->relations[$field_name] = new stdClass();
		$this->relations[$field_name]->table = $related_table;
		$this->relations[$field_name]->display = $display_field;
	}
}