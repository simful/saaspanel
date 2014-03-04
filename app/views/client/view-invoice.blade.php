@extends('client.master')

@section('title')
	Invoice #{{ $invoice->id }}
@stop

@section('content')
	<p>
		<a href="/client/invoices" class="btn btn-info"><i class="fa fa-arrow-left"></i> Back to Invoices</a>
	</p>
	<div class="panel panel-primary">
		<div class="panel-heading">Invoice #{{ $invoice->id }}</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-md-4">
					<p>Due Date <span class="pull-right">{{ $invoice->due_date }}</span></p>
					<?php 
						$label_map = array(
							'Draft' => 'label-default',
							'Unpaid' => 'label-danger',
							'Paid' => 'label-success',
						);
					?>
					<p>
						Status
						<span class="label {{ isset($label_map[$invoice->status]) ? $label_map[$invoice->status] : 'label-default' }} pull-right">
							{{ $invoice->status }}
						</span>
					</p>
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			Items
		</div>
		<div class="panel-body">
			<table class="table">
				<thead>
					<th>Name</th>
					<th>Qty</th>
					<th>Price</th>
				</thead>

				<?php $subtotal = 0; ?>

				<tbody>
					@foreach ($items as $item)
						<tr>
							<td>{{ $item->description }}</td>
							<td>{{ $item->quantity }}</td>
							<td class="monFor" style="text-align: right">{{ $item->unit_price }}</td>
							<?php $subtotal += $item->unit_price * $item->quantity; ?>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

	<div class="row">
		<div class="col-md-8">
			<p>
				<a href="#" class="btn btn-info">Make Payment</a>
				<a href="#" class="btn btn-danger">Request Cancellation</a>
			</p>
		</div>

		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-body">
					<p>Sub Total <span class="pull-right monFor">{{ $subtotal }}</span></p>
					<p>VAT <span class="pull-right monFor">{{ $subtotal * 0.1 }}</span></p>
					<p>Total <span class="pull-right monFor">{{ $subtotal + ($subtotal * 0.1) }}</span></p>
				</div>
			</div>
		</div>
	</div>
@stop