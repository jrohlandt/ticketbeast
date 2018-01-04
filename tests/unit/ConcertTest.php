<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;
use App\Concert;

class ConcertTest extends TestCase
{
    /** @test */
    function can_get_formatted_date()
    {
        // Arrange
        // create a concert with a known date
//        $concert = factory(Concert::class)->create([
        // use make instead of create, it creates a user in memory (not in db) it's like 'new Concert();'
        $concert = factory(Concert::class)->make([
           'date' => Carbon::parse('2018-01-13 9:00pm'),
        ]);

        // Act
        // Retrieve formatted date
        $date = $concert->formatted_date;

        // Assert
        // Verify that the date is formatted correctly
        $this->assertEquals('January 13, 2018', $date);
    }

    /** @test */
    function can_get_formatted_start_time()
    {
        $concert = factory(Concert::class)->make([
           'date' => Carbon::parse('2018-01-13 17:00:00'),
        ]);

        $this->assertEquals('5:00pm', $concert->formatted_start_time);
    }

    /** @test */
    function can_get_ticket_price_in_dollars()
    {
        $concert = factory(Concert::class)->make([
            'ticket_price' => 6750,
        ]);

        $this->assertEquals('67.50', $concert->ticket_price_in_dollars);
    }
}
