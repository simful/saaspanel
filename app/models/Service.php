<?php

/**
* 
*/
class Service extends Eloquent
{
	function options()
	{
		return $this->hasMany('ServiceOption');
	}
}