<?php

namespace App;

class Reservation
{
	private $tickets;

	public function __construct(\Illuminate\Support\Collection $tickets)
	{
		$this->tickets = $tickets;
	}

	public function totalCost()
	{
		return $this->tickets->sum('price');
	}
}