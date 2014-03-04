<ul class="nav nav-wizard">
	<li class="{{ $step > 0 ? 'past' : '' }} {{ $step == 1 ? 'active' : '' }}">
		
			<div class="pull-left step-icon">
				<i class="fa fa-shopping-cart fa-2x"></i>
			</div>
			<div class="step-nav">
				<span class="step">Step 1</span><span class="description">Select product</span>
			</div>
	</li>
	<li class="{{ $step > 1 ? 'past' : '' }} {{ $step == 2 ? 'active' : '' }}">
			<div class="pull-left step-icon">
				<i class="fa fa-wrench fa-2x"></i>
			</div>
			<div class="step-nav">
				<span class="step">Step 2</span><span class="description">Configure</span>
			</div>
	</li>
	<li class="{{ $step > 2 ? 'past' : '' }} {{ $step == 3 ? 'active' : '' }}">
			<div class="pull-left step-icon">
				<i class="fa fa-credit-card fa-2x"></i>
			</div>
			<div class="step-nav">
				<span class="step">Step 3</span><span class="description">Account &amp; Payment Method</span>
			</div>
	</li>
	<li class="{{ $step > 3 ? 'past' : '' }} {{ $step == 4 ? 'active' : '' }}">
			<div class="pull-left step-icon">
				<i class="fa fa-check fa-2x"></i>
			</div>
			<div class="step-nav">
				<span class="step">Step 4</span><span class="description">Checkout</span>
			</div>
	</li>
</ul>