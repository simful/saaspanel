@extends('client.master')

@section('title')
	Login
@stop

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				
			</div>

			<div class="col-md-4">
				<div class="panel panel-primary">
					<div class="panel-heading">
						Login
					</div>
					<div class="panel-body">
						<form class="form-signin" action="/user/login" method="post">
							<div class="form-group">
								<input type="text" class="form-control input-lg" placeholder="Username or Email" autofocus name="email">
							</div>
							<div class="form-group">
								<input type="password" class="form-control input-lg" placeholder="Password" name="password">
							</div>
							<label class="checkbox">
								<input type="checkbox" value="remember-me"> Remember me
								<span class="pull-right"> <a href="#"> Forgot Password?</a></span>
							</label>
							<button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
							
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop