@extends('client.master')

@section('title')
	My Invoices
@stop

@section('content')
	
	<div class="panel panel-primary">
		<div class="panel-heading">Invoices</div>
		<div class="panel-body">
			<table class="table">
				<thead>
					<th>Invoice</th>
					<th>Due Date</th>
					<th>Created at</th>
				</head>
				<tbody>
					@foreach ($invoices as $invoice)
					<tr>
						<td>
							<?php 
								$label_map = array(
									'Draft' => 'label-default',
									'Unpaid' => 'label-danger',
									'Paid' => 'label-success',
								);
							?>
							<a href="/client/invoice/{{ $invoice->id }}">
								<span class="label {{ isset($label_map[$invoice->status]) ? $label_map[$invoice->status] : 'label-default' }}">{{ $invoice->status }}</span>&nbsp;
								Invoice #{{ $invoice->id }}
							</a>
						</td>
						<td>{{ $invoice->due_date }}</td>
						<td>{{ $invoice->created_at }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	
@stop