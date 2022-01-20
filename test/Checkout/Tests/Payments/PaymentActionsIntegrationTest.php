<?php

namespace Checkout\Tests\Payments;

use Checkout\CheckoutApiException;

class PaymentActionsIntegrationTest extends AbstractPaymentsIntegrationTest
{

    /**
     * @test
     * @throws CheckoutApiException
     */
    public function shouldGetPaymentActions(): void
    {
        $this->markTestSkipped("unstable");
        $paymentResponse = $this->makeCardPayment(true);

        $this->nap();

        $actions = $this->defaultApi->getPaymentsClient()->getPaymentActions($paymentResponse["id"]);
        self::assertNotNull($actions);
        self::assertCount(2, $actions);
        foreach ($actions as $paymentAction) {
            $this->assertResponse($paymentAction,
                "amount",
                "approved",
                "processed_on",
                "reference",
                "response_code",
                "response_summary",
                "type");
        }
    }
}
