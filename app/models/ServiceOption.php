<?php

/**
* 
*/
class ServiceOption extends Eloquent
{
	protected $table = 'service_options';

	function service()
	{
		return $this->belongsTo('Service');
	}
}