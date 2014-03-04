<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	if (Auth::check())
	{
		if (Auth::user()->role == 'Admin')
			return View::make('home');
		else
			return Redirect::to('client/dashboard');
	}		
	else
		return View::make('client.portal');
});

Route::get('dashboard', 'HomeController@statistics');

Route::get('me', function() {
	if (Auth::check())
		return json_encode(array(
			'username' => Auth::user()->username,
			'email' => Auth::user()->email,
			'pic' => '//www.gravatar.com/avatar/' . md5(strtolower(trim(Auth::user()->email))) . '?s=64',
			'profile' => Auth::user()->profile->toArray(),
		));
	else
		return json_encode(null);
});

Route::get('t', function()
{
	$query = ServiceOption::find(2);
	return var_dump($query->service);
});

Route::get('templates/clone/{id}', function($id)
{

});

Route::get( 'user/create',                 'UserController@create');
Route::post('user',                        'UserController@store');
Route::get( 'user/login',                  'UserController@login');
Route::post('user/login',                  'UserController@do_login');
Route::get( 'user/confirm/{code}',         'UserController@confirm');
Route::get( 'user/forgot_password',        'UserController@forgot_password');
Route::post('user/forgot_password',        'UserController@do_forgot_password');
Route::get( 'user/reset_password/{token}', 'UserController@reset_password');
Route::post('user/reset_password',         'UserController@do_reset_password');
Route::get( 'user/logout',                 'UserController@logout');

Route::get('user/settings', 'UserController@settings');
Route::post('user/changepassword', 'UserController@doChangePassword');

Route::get('order', 'OrderController@step1');
Route::get('order/step2', 'OrderController@step2');
Route::post('order/addToCart', 'OrderController@addToCart');
Route::post('order/removeFromCart', 'OrderController@removeFromCart');
Route::get('order/step3', 'OrderController@step3');
Route::get('order/step4', 'OrderController@step4');
Route::post('order/checkout', 'OrderController@checkout');
Route::get('order/thankyou', 'OrderController@thankyou');

Route::group(array('before' => 'auth'), function()
{
	Route::resource('users', 'UsersController');
	Route::resource('services', 'ServicesController');
	Route::resource('service_options', 'ServiceOptionsController');
	Route::resource('subscriptions', 'SubscriptionsController');
	Route::resource('invoices', 'InvoicesController');
	Route::resource('tickets', 'TicketsController');
	Route::resource('departments', 'DepartmentsController');
	Route::resource('billing_cycles', 'BillingCyclesController');
	Route::resource('templates', 'TemplatesController');
	Route::resource('campaigns', 'CampaignsController');


	// client side
	Route::get('client/dashboard', 'ClientController@dashboard');
	Route::get('client/invoices', 'ClientController@invoices');
	Route::get('client/invoice/{id}', 'ClientController@viewInvoice');
	Route::get('client/subscriptions', 'ClientController@subscriptions');
	Route::get('client/ticket/new', 'ClientController@newTicket');
	Route::post('client/ticket/send', 'ClientController@sendTicket');
	Route::post('client/ticket/reply', 'ClientController@replyTicket');
	Route::post('client/ticket/close', 'ClientController@closeTicket');
	Route::post('client/ticket/reopen', 'ClientController@reopenTicket');
	Route::get('client/tickets', 'ClientController@tickets');
	Route::get('client/ticket/{id}', 'ClientController@viewTicket');
	Route::get('client/payments', 'ClientController@paymentMethods');
});

Event::listen('activity', 'Activity@log');
