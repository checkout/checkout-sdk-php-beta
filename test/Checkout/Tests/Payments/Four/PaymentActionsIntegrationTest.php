<?php

namespace Checkout\Tests\Payments\Four;

use Checkout\CheckoutApiException;

class PaymentActionsIntegrationTest extends AbstractPaymentsIntegrationTest
{

    /**
     * @test
     * @throws CheckoutApiException
     */
    public function shouldGetPaymentActions(): void
    {
        $paymentResponse = $this->makeCardPayment(true);

        $this->nap();

        $actions = $this->fourApi->getPaymentsClient()->getPaymentActions($paymentResponse["id"]);
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
