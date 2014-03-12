@extends('client.master')

@section('title')
	Confirm Cart
@stop

@section('content')
	@include('order.nav')

	<div class="panel panel-primary">
		<div class="panel-heading">Review Cart</div>
		<div class="panel-body">
			@if (count(Cart::contents()) > 0)
				@foreach (Cart::contents() as $key => $item)
					<div class="item">
						<p style="margin-top: 0"><b>{{ $item->name }}</b> <span class="pull-right monFor">{{ $item->price }}</span></p>
						<p><small>recurring every {{ $item->quantity }} month(s)</small></p>
						<p>
							<small><a class="removeFromCart" href="#" data-key="{{ $key }}">Remove</a></small>
						</p>
					</div>
				@endforeach

				<div class="item">
					<p style="margin-top: 0"><b>Cart Total</b> <span class="pull-right monFor">{{ Cart::total() }}</span></p>
				</div>
			@else
				<div class="item">
					<i>Your cart is still empty.</i>
				</div>
			@endif

			<form action="/order/checkout" method="post">
				<p class="pull-right">
					<a href="/order" class="btn btn-info">Continue Shopping</a>
					<button type="submit" class="btn btn-danger" {{ count(Cart::contents()) > 0 ? '' : 'disabled' }}><i class="fa fa-shopping-cart"></i> Confirm Checkout</button>
				</p>
			</form>
		</div>
	</div>
	<script src="/js/sp.js"></script>
@stop

