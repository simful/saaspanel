@extends('client.master')

@section('title')
	Account and Payment Methods
@stop

@section('content')
	@include('order.nav')

	<div class="row">
		<div class="col-md-8">
			<div class="panel panel-primary">
				<div class="panel-heading">Account &amp; Payment Method</div>
				<div class="panel-body">
					@if (Auth::guest())
					<p><b>Do you already have an account with us?</b></p>

					<div class="radio">
						<label>
							<input type="radio" name="createNew" id="input" value="0">
							I already have an account. <a href="/user/login">Login</a>.
						</label>
					</div>

					<div class="radio">
						<label>
							<input type="radio" name="createNew" id="input" value="1" checked="checked">
							I want to <a href="/user/create">create new account</a>.
						</label>
					</div>

					<hr>
					@endif

					<p><b>Choose your preferred payment method.</b></p>

					<div class="radio">
						<label>
							<input type="radio" name="paymentMethod" id="input" value="" checked="checked">
							Bank Transfer
						</label>
					</div>

					<div class="radio">
						<label>
							<input type="radio" name="paymentMethod" id="input" value="">
							Credit Card
						</label>
					</div>

					<div class="radio">
						<label>
							<input type="radio" name="paymentMethod" id="input" value="">
							PayPal
						</label>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			@include('order.cart')
		</div>
	</div>
@stop