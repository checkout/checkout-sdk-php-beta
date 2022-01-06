<?php

namespace Checkout\Tests\Payments\Four;

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
        $paymentResponse = $this->makeCardPayment(true);

        $this->nap();

        $amount = $paymentResponse["amount"];
        $refundRequest = new RefundRequest();
        $refundRequest->reference = uniqid();
        $refundRequest->amount = $amount;

        $response = $this->fourApi->getPaymentsClient()->refundPayment($paymentResponse["id"], $refundRequest);

        $this->assertResponse($response, "reference", "action_id");

        $this->nap();

        $paymentDetails = $this->fourApi->getPaymentsClient()->getPaymentDetails($paymentResponse["id"]);
        $this->assertResponse($paymentDetails,
            "balances.total_authorized",
            "balances.total_captured",
            "balances.total_refunded");
        self::assertEquals($amount, $paymentDetails["balances"]["total_authorized"]);
        self::assertEquals($amount, $paymentDetails["balances"]["total_captured"]);
        self::assertEquals($amount, $paymentDetails["balances"]["total_refunded"]);
    }

    /**
     * @test
     * @throws CheckoutApiException
     */
    public function shouldRefundCardPaymentIdempotent(): void
    {
        $paymentResponse = $this->makeCardPayment(true);

        $this->nap();

        $refundRequest = new RefundRequest();
        $refundRequest->reference = uniqid("shouldRefundCardPayment_Idempotent");
        $refundRequest->amount = 2;

        $response1 = $this->fourApi->getPaymentsClient()->refundPayment($paymentResponse["id"], $refundRequest, $this->idempotencyKey);

        $this->assertResponse($response1,
            "action_id",
            "reference");

        $refundRequest2 = new RefundRequest();
        $refundRequest2->reference = uniqid("shouldRefundCardPayment_Idempotent2");
        $refundRequest2->amount = 2;

        $response2 = $this->fourApi->getPaymentsClient()->refundPayment($paymentResponse["id"], $refundRequest2, $this->idempotencyKey);

        self::assertEquals($response1["action_id"], $response2["action_id"]);
    }
}
