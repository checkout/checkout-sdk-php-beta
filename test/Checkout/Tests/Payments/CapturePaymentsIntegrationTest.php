<?php

namespace Checkout\Tests\Payments;

use Checkout\CheckoutApiException;
use Checkout\Payments\CaptureRequest;

class CapturePaymentsIntegrationTest extends AbstractPaymentsIntegrationTest
{

    /**
     * @test
     * @throws CheckoutApiException
     */
    public function shouldFullCaptureCardPayment(): void
    {
        $paymentResponse = $this->makeCardPayment();

        $captureRequest = new CaptureRequest();
        $captureRequest->reference = uniqid("shouldFullCaptureCardPayment");

        $response = $this->defaultApi->getPaymentsClient()->capturePayment($paymentResponse["id"], $captureRequest);
        $this->assertResponse($response, "reference", "action_id");

    }

    /**
     * @test
     * @throws CheckoutApiException
     */
    public function shouldPartiallyCaptureCardPayment(): void
    {
        $paymentResponse = $this->makeCardPayment();

        $captureRequest = new CaptureRequest();
        $captureRequest->reference = uniqid("shouldPartiallyCaptureCardPayment");
        $captureRequest->amount = 5;

        $response = $this->defaultApi->getPaymentsClient()->capturePayment($paymentResponse["id"], $captureRequest);
        $this->assertResponse($response, "reference", "action_id");
    }

    /**
     * @test
     * @throws CheckoutApiException
     */
    public function shouldCaptureCardPaymentIdempotent(): void
    {
        $this->markTestSkipped("unstable");
        $paymentResponse = $this->makeCardPayment();

        $captureRequest = new CaptureRequest();
        $captureRequest->reference = uniqid("shouldCaptureCardPaymentIdempotent");

        $capture1 = $this->defaultApi->getPaymentsClient()->capturePayment($paymentResponse["id"], $captureRequest, $this->idempotencyKey);
        self::assertNotNull($capture1);

        $capture2 = $this->defaultApi->getPaymentsClient()->capturePayment($paymentResponse["id"], $captureRequest, $this->idempotencyKey);
        self::assertNotNull($capture2);

        self::assertEquals($capture1["action_id"], $capture2["action_id"]);
    }
}
