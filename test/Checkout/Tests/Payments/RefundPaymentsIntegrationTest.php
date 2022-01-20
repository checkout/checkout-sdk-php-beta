<?php

namespace Checkout\Tests\Payments;

use Checkout\CheckoutApiException;
use Checkout\Payments\RefundRequest;

class RefundPaymentsIntegrationTest extends AbstractPaymentsIntegrationTest
{

    /**
     * @test
     * @throws CheckoutApiException
     */
    public function shouldRefundCardPayment(): void
    {
        $this->markTestSkipped("unstable");
        $paymentResponse = $this->makeCardPayment(true);

        $this->nap();

        $refundRequest = new RefundRequest();
        $refundRequest->reference = uniqid();

        $response = $this->defaultApi->getPaymentsClient()->refundPayment($paymentResponse["id"]);

        $this->assertResponse($response,
            "action_id",
            "reference");
    }

    /**
     * @test
     * @throws CheckoutApiException
     */
    public function shouldRefundCardPaymentIdempotent(): void
    {
        $this->markTestSkipped("unstable");
        $paymentResponse = $this->makeCardPayment(true);

        $this->nap();

        $refundRequest = new RefundRequest();
        $refundRequest->reference = uniqid("shouldRefundCardPayment_Idempotent");
        $refundRequest->amount = 2;

        $response1 = $this->defaultApi->getPaymentsClient()->refundPayment($paymentResponse["id"], $refundRequest, $this->idempotencyKey);

        $this->assertResponse($response1,
            "action_id",
            "reference");

        $refundRequest2 = new RefundRequest();
        $refundRequest2->reference = uniqid("shouldRefundCardPayment_Idempotent2");
        $refundRequest2->amount = 2;

        $response2 = $this->defaultApi->getPaymentsClient()->refundPayment($paymentResponse["id"], $refundRequest2, $this->idempotencyKey);

        self::assertEquals($response1["action_id"], $response2["action_id"]);
    }

}
