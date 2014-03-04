@extends('client.master')

@section('title')
	Ticket #{{ $ticket->id }}
@stop

@section('content')
	<div class="panel panel-primary">
		<div class="panel-heading">
			<span class="label {{ $ticket->status == 'Open' ? 'label-success' : 'label-danger' }}">{{ $ticket->status }}</span> Ticket #{{ $ticket->id }}
			<span class="pull-right" style="font-size: 0.8em">created at {{ $ticket->created_at }}</span>
		</div>
		<div class="panel-body">
			<h3 style="margin-top: 0">{{ $ticket->title }}</h3>
			{{ $ticket->message }}

			<p>{{ $ticket->username }}</p>

			@if ($ticket->status == 'Open')
				<form action="/client/ticket/close" method="post">
					<input type="hidden" name="ticket_id" value="{{ $ticket->id }}"/>
					<button type="submit" class="btn btn-danger pull-right">Close Ticket</button>
				</form>
			@else
				<form action="/client/ticket/reopen" method="post">
					<input type="hidden" name="ticket_id" value="{{ $ticket->id }}"/>
					<button type="submit" class="btn btn-primary pull-right">Reopen Ticket</button>
				</form>
			@endif
		</div>
	</div>

	<div class="row">
		<div class="col-md-11 col-md-offset-1">
			@foreach ($replies as $message)
				<div class="panel {{ $message->username == Auth::user()->username ? 'panel-primary' : 'panel-danger' }}">
					<div class="panel-heading">
						{{ $message->username }} <span class="pull-right" style="font-size: 0.8em">replied at {{ $message->stamp }}</span>
					</div>
					<div class="panel-body">
						{{ $message->message }}
					</div>
				</div>
			@endforeach
		</div>
	</div>

	@if ($ticket->status == 'Open')
	<div class="panel panel-primary">
		<div class="panel-heading">
			Post a new reply
		</div>
		<div class="panel-body">
			<form action="/client/ticket/reply" method="post">
				<input type="hidden" name="ticket_id" value="{{ $ticket->id }}"/>
				<textarea name="message" rows="10" class="form-control" placeholder="Type reply message here"></textarea>
				<br>
				<button type="submit" class="btn btn-primary">Send Reply</button>
			</form>
		</div>
	</div>
	@else
	<div class="alert alert-info">
		<i class="fa fa-check"></i> This ticket is already closed.
	</div>
	@endif
@stop