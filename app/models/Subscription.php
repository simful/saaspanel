<?php

/**
* 
*/
class Subscription extends Eloquent
{
	function service()
	{
		return $this->belongsTo('Service');
	}
}