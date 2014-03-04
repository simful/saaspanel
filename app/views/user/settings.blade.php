@extends('client.master')

@section('title')
	Account Settings
@stop

@section('content')
	<div class="panel panel-primary">
		<div class="panel-heading">Account Settings</div>
		<div class="panel-body">

			<p><b>Change Password</b></p>
			<form action="/user/changepassword" method="POST" role="form">
				<div class="form-group">
					<label class="sr-only" for="oldpassword">Old Password</label>
					<input type="text" class="form-control" id="oldpassword" placeholder="Old Password">
				</div>

				<div class="form-group">
					<label class="sr-only" for="newpassword">New Password</label>
					<input type="text" class="form-control" id="newpassword" placeholder="New Password">
				</div>

				<div class="form-group">
					<label class="sr-only" for="verifynew">Verify New Password</label>
					<input type="text" class="form-control" id="verifynew" placeholder="Retype New Password">
				</div>

				<button type="submit" class="btn btn-primary">Change Password</button>
			</form>
		</div>
	</div>

	<div class="panel panel-primary">
		<div class="panel-heading">Newsletter Settings</div>
		<div class="panel-body">
			<div class="checkbox">
				<label>
					<input type="checkbox" value="send-email-notifications">
					Send me e-mail notifications
				</label>
			</div>

			<div class="checkbox">
				<label>
					<input type="checkbox" value="send-email-notifications">
					Important Announcements
				</label>
			</div>

			<div class="checkbox">
				<label>
					<input type="checkbox" value="send-email-notifications">
					Newsletter
				</label>
			</div>

			<button type="submit" class="btn btn-primary">Update Settings</button>
		</div>
	</div>

	<div class="panel panel-primary">
		<div class="panel-heading">Payment Settings</div>
		<div class="panel-body">

			<div class="checkbox">
				<label>
					<input type="checkbox" value="send-email-notifications">
					Automatically pay using my default payment method
				</label>
			</div>

			<div class="form-group">
				<label class="control-label">Default Payment Method</label>
				{{ Form::select('default_payment_method', array('Credit Card' => 'Credit Card', 'PayPal' => 'PayPal'), null, array('class' => 'form-control')) }}
			</div>

			<button type="submit" class="btn btn-primary">Update Settings</button>
		</div>
	</div>
@stop