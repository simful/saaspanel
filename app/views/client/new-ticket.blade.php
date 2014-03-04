@extends('client.master')

@section('title')
	Create New Ticket
@stop

@section('content')
	<div class="panel panel-primary">
		<div class="panel-heading">Create New Ticket</div>
		<div class="panel-body">
			<form action="/client/ticket/send" method="POST" role="form">
				<div class="form-group">
					<label for="title">Department</label>
					{{ Form::select('department_id', DB::table('departments')->lists('name', 'id'), null, array('class' => 'form-control')) }}
				</div>

				<div class="form-group">
					<label for="title">Title</label>
					<input type="text" class="form-control" id="title" name="title">
				</div>

				<div class="form-group">
					<label for="message">Message</label>
					<textarea id="message" name="message" rows="8" class="form-control"></textarea>
				</div>

				<button type="submit" class="btn btn-primary">Send</button>
				<a href="/client/tickets" class="btn btn-default">Cancel</a>
			</form>
		</div>
	</div>
@stop