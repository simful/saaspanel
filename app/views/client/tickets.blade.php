@extends('client.master')

@section('title')
	My Tickets
@stop

@section('content')
	<div class="panel panel-primary">
		<div class="panel-heading">Tickets</div>
		<div class="panel-body">
			<a href="/client/ticket/new" class="btn btn-primary"><i class="fa fa-plus"></i> Open New Ticket</a>
			<table class="table">
				<thead>
					<th>Tickets</th>
				</thead>
				<tbody>
					@foreach ($tickets as $ticket)
					<tr>
						<td>
							<span class="label {{ $ticket->status == 'Open' ? 'label-success' : 'label-danger' }}">{{ $ticket->status }}</span>
							<a href="/client/ticket/{{ $ticket->id }}">#{{ $ticket->id }}: {{ $ticket->title }}</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop