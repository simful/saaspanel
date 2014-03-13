@extends('client.master')

@section('title')
	Portal
@stop

@section('content')
	<div class="panel panel-primary" style="margin-top: 10px">
		<div class="panel-heading">Welcome</div>
		<div class="panel-body">
		   
		   <p>This is your portal page. You can freely modify this page in staff area.</p>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">News &amp; Announcements</div>
				<div class="panel-body">
					@if (isset($news))
						@foreach ($news as $news_item)

						@endforeach
					@else
						<p><i>No news.</i></p>
					@endif
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">Client Login</div>
				<div class="panel-body">
					<p>To view and manage your account, you have to be logged in.</p>
					<a href="/user/login" class="btn btn-primary">Enter Client Area</a>
				</div>
			</div>
		</div>
	</div>
@endsection