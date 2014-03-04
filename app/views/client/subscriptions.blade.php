@extends('client.master')

@section('title')
	My Subscriptions
@stop

@section('content')
	<div class="panel panel-primary">
		<div class="panel-heading">Subscriptions</div>
		<div class="panel-body">
		   <table class="table">
		   		<thead>
		   			<th>Services</th>
		   			<th>Cycle</th>
		   			<th>Actions</th>
		   		</thead>
				<tbody>
					@foreach ($subscriptions as $subscription)
					<tr>
						<?php 
								$label_map = array(
									'Active' => 'label-success',
									'Inactive' => 'label-danger'
								);
							?>
						<td><span class="label {{ isset($label_map[$subscription->status]) ? $label_map[$subscription->status] : 'label-default' }}">{{ $subscription->status }}</span> {{ $subscription->service->name }}</td>
						<td>{{ $subscription->billing_cycle }} month(s)</td>
						<td>
							<a href="#" class="btn btn-danger btn-xs" disabled>Stop</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop