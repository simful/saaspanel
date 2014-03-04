@extends('client.master')

@section('title')
	Payment Methods
@stop

@section('content')
	<div class="panel panel-primary">
		<div class="panel-heading">Payment Methods</div>
		<div class="panel-body">
			<table class="table">
				<thead>
					<th>Card #</th>
					<th>Expiry</th>
					<th>Default</th>
					<th>Status</th>
				</thead>

				<tbody>
					@foreach ($cards as $card)
						<tr>
							<td>{{ substr($card->number, 0, 3) }}X-XXXX-XXXX-XXXX</td>
							<td>{{ $card->expiryMonth }}/{{ $card->expiryYear }}</td>
							<td>{{ $card->is_default ? 'Yes' : '' }}</td>
							<td>{{ $card->status }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop