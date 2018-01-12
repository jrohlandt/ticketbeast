<?php


use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Billing\FakePaymentGateway;
use App\Billing\PaymentFailedException;

class FakePaymentGatewayTest extends TestCase
{
    /** @test */
    function charges_with_a_valid_token_are_successful()
    {
        $paymentGateway = new FakePaymentGateway;

        $paymentGateway->charge(2500, $paymentGateway->getValidTestToken());

        $this->assertEquals(2500, $paymentGateway->totalCharges());
    }

    /** @test */
    function charges_with_an_invalid_payment_token_will_fail()
    {
        try {
            $paymentGateWay = new FakePaymentGateway;
            $paymentGateWay->charge(2500, 'invalid-payment-token');
        } catch(PaymentFailedException $e) {
            return;
        }

        $this->fail();
    }
}
