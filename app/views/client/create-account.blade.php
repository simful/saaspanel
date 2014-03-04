@extends('client.master')

@section('title')
	Create Account
@stop

@section('content')
<div class="row">
	<div class="col-md-4 col-md-offset-4">
<div class="panel panel-primary">
	<div class="panel-heading">Create Account</div>
	<div class="panel-body">
		@if ( Session::get('error') )
			<div class="alert alert-error alert-danger">
				@if ( is_array(Session::get('error')) )
					{{ head(Session::get('error')) }}
				@endif
			</div>
		@endif

		@if ( Session::get('notice') )
			<div class="alert">{{ Session::get('notice') }}</div>
		@endif

		<form class="form form-horizontal" method="POST" action="/user" accept-charset="UTF-8">
			<fieldset>
				<div class="form-group">
					<label for="username" class="control-label sr-only">Username</label>
					<div class="col-md-12">
						<input class="form-control input-lg" placeholder="Username" type="text" name="username" id="username" value="{{ Input::old('username') }}">
					</div>
				</div>
				<div class="form-group">
					<label for="email" class="control-label sr-only">Email</label>
					<div class="col-md-12">
						<input class="form-control input-lg" placeholder="Email" type="text" name="email" id="email" value="{{ Input::old('email') }}">
					</div>
				</div>
				<div class="form-group">
					<label for="password" class="control-label sr-only">Password</label>
					<div class="col-md-12">
						<input class="form-control input-lg" placeholder="Password" type="password" name="password" id="password">
					</div>
				</div>
				<div class="form-group">
					<label for="password_confirmation" class="control-label sr-only">Confirm Password</label>
					<div class="col-md-12">
						<input class="form-control input-lg" placeholder="Confirm Password" type="password" name="password_confirmation" id="password_confirmation">
					</div>
				</div>

				<div class="form-group">
					<div class="form-actions col-md-4">
						<button type="submit" class="btn btn-primary">Create new account</button>
					</div>
				</div>

			</fieldset>
		</form>
	</div>
</div>

</div>
</div>
@stop