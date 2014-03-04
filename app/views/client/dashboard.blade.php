@extends('client.master')

@section('title')
	Dashboard
@stop

@section('content')
	<div class="row">
		<div class="col-md-8">
			<div class="panel panel-primary">
				<div class="panel-heading">My Information</div>
				<div class="panel-body">
					<div class="profile-pic pull-left">
						<img class="img img-responsive img-polaroid" src="//www.gravatar.com/avatar/{{ md5(strtolower(trim(Auth::user()->email))) }}">
					</div>
					<h4>{{ Auth::user()->profile->full_name }} ({{ Auth::user()->username }})</h4>
					<p>Client #{{ Auth::user()->id }}</p>
					<p>{{ Auth::user()->profile->address }}</p>
					<p>{{ Auth::user()->profile->city }}, {{ Auth::user()->profile->country }}</p>
					<hr>
					<p>{{ Auth::user()->email }}</p>
					<p>{{ Auth::user()->profile->phone }}</p>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="panel panel-primary">
				<div class="panel-heading">Account Overview</div>
				<div class="panel-body">
					<div>
						<p>Deposit <span class="pull-right">$ 0.00</span></p>
						<p>Outstanding Balance <span class="pull-right">$ 0.00</span></p>
						<hr>
						<p>E-mail Notifications <span class="label label-success pull-right">On</span></p>
						<p>Annoucements <span class="label label-success pull-right">On</span></p>
						<p>Newsletter <span class="label label-success pull-right">On</span></p>
						<p>Automatic Payment <span class="label label-danger pull-right">Off</span></p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">My Subscriptions</div>
				<div class="panel-body">
					<table class="table">
						<thead>
							<th>Name</th>
							<th>Cycle</th>
							<th>Expire Date</th>
						</thead>
						<tbody>
							@foreach ($subscriptions as $subscription)
								<tr>
									<td>{{ $subscription->service->name }}</td>
									<td>{{ $subscription->billing_cycle }} month(s)</td>
									<td>{{ $subscription->expire_date }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">Open Tickets</div>
				<div class="panel-body">
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
		</div>
	</div>
@stop