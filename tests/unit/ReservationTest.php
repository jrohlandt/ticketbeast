<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Concert;
use App\Reservation;

class ReservationTest extends TestCase 
{
	/** @test */
	function calculating_the_total_cost()
	{
		$tickets = collect([
			(object) ['price' => 1200],
			(object) ['price' => 1200],
			(object) ['price' => 1200],
		]);
		
		$reservation = new Reservation($tickets);

		$this->assertEquals(3600, $reservation->totalCost());
	}
}