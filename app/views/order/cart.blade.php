<div id="cart" class="panel panel-primary">
	<div class="panel-heading"><i class="fa fa-shopping-cart"></i> Your Cart</div>
	<div class="panel-body">
		
		@if (count(Cart::contents()) > 0)
			@foreach (Cart::contents() as $key => $item)
				<div class="item">
					<p style="margin-top: 0"><b>{{ $item->name }}</b> <span class="pull-right monFor">{{ $item->price * $item->quantity }}</span></p>
					<p><small>recurring every {{ $item->quantity }} month(s)</small></p>
					<p>
						<small><a class="removeFromCart" href="#" data-key="{{ $key }}">Remove</a></small>
					</p>
				</div>
			@endforeach

			<div class="item">
				<p style="margin-top: 0; font-weight: bold">Cart Total <span class="pull-right monFor">{{ Cart::total() }}</span></p>
			</div>
		@else
			<div class="item">
				<i>Your cart is still empty.</i>
			</div>
		@endif

		<p><a href="/order/step4" class="btn btn-danger pull-right" {{ count(Cart::contents()) > 0 ? '' : 'disabled' }}><i class="fa fa-shopping-cart"></i> Checkout</a></p>
	</div>
</div>
<script src="/js/sp.js"></script>