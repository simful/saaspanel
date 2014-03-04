<?php

class Ticket extends Eloquent
{
	public function replies()
	{
		return $this->hasMany('TicketReply');
	}
}