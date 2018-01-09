<?php
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Concert;
use App\Billing\FakePaymentGateway;
use App\Billing\PaymentGateway;

class PurchaseTicketsTest extends TestCase {

    use DatabaseMigrations;

    /** @test */
    function customer_can_purchase_concert_tickets()
    {
        $paymentGateway = new FakePaymentGateway;
        $this->app->instance(PaymentGateway::class, $paymentGateway);

        // Arrange
        // Create Concert
        $concert = factory(Concert::class)->create([
            'ticket_price' => 3250,
        ]);

        // Act
        // Purchase concert tickets
        $this->json('POST', "/concerts/{$concert->id}/orders", [
            'email' => 'john@example.com',
            'ticket_quantity' => 3,
            'payment_token' => $paymentGateway->getValidTestToken(),
        ]);

        // Assert
        $this->assertResponseStatus(201);

        // Make sure the customer was charged the correct amount.
        $this->assertEquals(9750, $paymentGateway->totalCharges());

        // Make sure that an order exists for this customer.
        $order = $concert->orders()->where('email', 'john@example.com')->first();
        $this->assertNotNull($order);
        $this->assertEquals(3, $order->tickets->count());
    }
}