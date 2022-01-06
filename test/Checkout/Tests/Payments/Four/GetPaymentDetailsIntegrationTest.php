<?php

namespace Checkout\Tests\Payments\Four;

use Checkout\CheckoutApiException;

class GetPaymentDetailsIntegrationTest extends AbstractPaymentsIntegrationTest
{

    /**
     * @test
     * @throws CheckoutApiException
     */
    public function shouldGetPaymentDetails(): void
    {
        $paymentResponse = $this->makeCardPayment(true);

        $this->nap();

        $payment = $this->fourApi->getPaymentsClient()->getPaymentDetails($paymentResponse["id"]);

        $this->assertResponse($payment,
            "id",
            "requested_on",
            "amount",
            "currency",
            "payment_type",
            "reference",
            "status",
            "approved",
            "scheme_id",
            "source.id",
            "source.type",
            "source.fingerprint",
            "source.card_type",
            "customer.id",
            "customer.name");
    }
}
