@extends('client.master')

@section('title')
	Configure Service
@stop

@section('content')
	@include('order.nav')
	
	<div class="row">
		<div class="col-md-8">
			<form action="/order/addToCart" method="post">

			<div class="panel panel-primary">
				<div class="panel-heading">Configure</div>
				<div id="packageSelect" class="panel-body">
					<h3>{{ $service->name }}</h3>

					<p>Select an option.</p>
					@foreach ($options as $option)
						<div class="item">
							<label class="not-required" for="option-{{ $option->id }}" style="margin-top: 0">
								<input type="radio" name="option" id="option-{{ $option->id }}" value="{{ $option->id }}" checked="checked" class="service-option" data-base-price="{{ $option->base_price }}" data-fullname="{{ $service->name }} {{ $option->option_name }}">
								<span class="pull-right">
									<span class="monFor" style="font-weight: bold">{{ $option->base_price }}</span> / month
								</span>
								<b>{{ $option->option_name }}</b>
								<span class="description">{{ $option->description }}</span>
							</label>
						</div>
					@endforeach
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">

					<div class="panel panel-primary">
						<div class="panel-heading">Billing Cycle</div>
						<div id="billingCycle" class="panel-body">
							<p>Select your billing cycle.</p>

							@foreach($cycles as $cycle)

							<div class="radio">
								<label>
									<input type="radio" name="cycle" id="input" value="{{ $cycle->id }}" data-cycle="{{ $cycle->cycle }}" checked="checked" class="service-cycle">
									every {{ $cycle->cycle }} month(s)
									@if ($cycle->discount)
									<span class="label label-success">
										{{ $cycle->discount }}% off
									</span>
									@endif
								</label>
							</div>

							@endforeach
						</div>

					</div>
				</div>


				<div class="col-md-6">
					<div class="panel panel-primary">
						<div class="panel-heading">Item Total</div>
						<div class="panel-body">
							<p id="item" style="text-align: center"></p>
							<h1 id="total" style="text-align: center">0</h1>

							<p style="text-align: center">
								<button type="submit" id="addToCart" class="btn btn-primary" disabled>
									<i class="fa fa-check"></i>
									Add to Cart
								</button>

								<a href="/order" class="btn btn-default">Cancel</a>
							</p>
						</div>
					</div>
				</div>

				</form>

			</div>
		</div>

		<div class="col-md-4">
			@include('order.cart')
		</div>
	</div>

	<script>
		$(document).ready(function() { updateCart(); });
	</script>
@stop