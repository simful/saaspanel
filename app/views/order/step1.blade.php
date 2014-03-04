@extends('client.master')

@section('title')
	Order
@stop

@section('content')
	@include('order.nav')

	<div class="row">
		<div class="col-md-8">
			<div class="panel panel-primary">
				<div class="panel-heading">Choose Product or Service</div>
				<div class="panel-body">
					@foreach ($services as $service)
						<div class="item">
							<a class="btn btn-info pull-right" href="/order/step2?service={{ $service->id }}"><i class="fa fa-plus"></i> Select Product</a>
							<p style="margin-top: 0"><b>{{ $service->name }}</b></p>
							<p>{{ $service->description }}</p>
						</div>
					@endforeach
				</div>
			</div>
		</div>

		<div class="col-md-4">
			@include('order.cart')
		</div>
	</div>
@stop