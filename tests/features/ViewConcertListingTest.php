<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;
use App\Concert;

class ViewConcertListingTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function user_can_view_a_published_concert_listing()
    {
        // Arrange
        // Create a concert
        $concert = Concert::create([
            'title' => 'The Red Chord',
            'subtitle' => 'with Animosity and Lethargy',
            'date' => Carbon::parse('January 13, 2018 8:00pm'),
            'ticket_price' => 3250,
            'venue' => 'The Mosh Pit',
            'venue_address' => '123 Example Lane',
            'city' => 'Laraville',
            'state' => 'ON',
            'zip' => '17916',
            'additional_information' => 'For tickets, call (555) 555-5555.',
            'published_at' => Carbon::parse('-1 week'),
        ]);

        // Act
        // View the concert listing
        $this->visit('/concerts/'.$concert->id);

        // Assert
        // See the concert details
        $this->see('The Red Chord');
        $this->see('with Animosity and Lethargy');
        $this->see('January 13, 2018');
        $this->see('8:00');
        $this->see('32.50');
        $this->see('The Mosh Pit');
        $this->see('123 Example Lane');
        $this->see('Laraville, ON 17916');
        $this->see('For tickets, call (555) 555-5555.');

    }

    /** @test */
    function user_cannot_view_unpublished_concert_listings()
    {
        // Arrange
        // create a unpublished concert
        $concert = factory(Concert::class)->create([
           'published_at' => null,
        ]);

        // Act
        // attempt the view the unpublished concert listing
        $this->get('/concerts/'.$concert->id);

        // Assert
        // Verify that it could not be viewed.
        $this->assertResponseStatus(404);
    }
}
