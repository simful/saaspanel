<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>@yield('title') - SaaSPanel</title>
	<link rel="stylesheet" type="text/css" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/bower_components/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="/css/style.css">
	<script type="text/javascript" src="/bower_components/jquery/dist/jquery.min.js"></script>
	<script type="text/javascript" src="/bower_components/accounting/accounting.min.js"></script>
</head>
<body>
	<nav class="navbar navbar-default" role="navigation">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">SaaSPanel</a>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				@if (Auth::check())
				<?php
					$invoices_count = DB::table('invoices')
						->whereUserId(Auth::user()->id)
						->count();
					$subscriptions_count = DB::table('subscriptions')
						->whereUserId(Auth::user()->id)
						->count();
					$tickets_count = DB::table('tickets')
						->whereUserId(Auth::user()->id)
						->count();
				?>
				<ul class="nav navbar-nav">
					<li>
						<a href="/client/invoices">
							<i class="fa fa-print"></i>
							Invoices
							<span class="label {{ $invoices_count > 0 ? 'label-danger' : 'label-default' }}">{{ $invoices_count }}</span>
						</a>
					</li>
					<li>
						<a href="/client/subscriptions">
							<i class="fa fa-calendar"></i>
							Subscriptions
							<span class="label {{ $subscriptions_count > 0 ? 'label-success' : 'label-default' }}">{{ $subscriptions_count }}</span>
						</a>
					</li>
					<li>
						<a href="/client/tickets">
							<i class="fa fa-tags"></i>
							Tickets
							<span class="label {{ $tickets_count > 0 ? 'label-info' : 'label-default' }}">{{ $tickets_count }}</span>
						</a>
					</li>
					<li>
						<a href="/client/payments">
							<i class="fa fa-credit-card"></i>
							Payments
						</a>
					</li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->profile->full_name }} <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="/user/settings">Account Settings</a></li>
							<li><a href="/user/logout">Logout</a></li>
						</ul>
					</li>
				</ul>
				@else
					<div class="pull-right">
						<a href="/order" class="btn btn-primary navbar-btn">Order</a>
						<a href="/user/login" class="btn btn-primary navbar-btn">Login</a>
						<a href="/user/create" class="btn btn-primary navbar-btn">Register</a>
					</div>
				@endif
			</div>
		</div>
	</nav>
	<div class="container">
		@yield('content')
	</div>
	<div id="footer" class="container" style="font-size: 10px">
		Powered by SaaSPanel
	</div>
	<script type="text/javascript" src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>