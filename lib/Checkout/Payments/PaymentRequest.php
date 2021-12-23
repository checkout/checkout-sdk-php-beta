<?php

namespace Checkout\Payments;

use Checkout\Common\CustomerRequest;
use Checkout\Payments\Source\AbstractRequestSource;
use DateTime;
use JsonSerializable;

class PaymentRequest implements JsonSerializable
{
    public ?AbstractRequestSource $source = null;

    public ?int $amount = null;

    public string $currency;

    public ?string $payment_type = null;

    public ?bool $merchant_initiated = null;

    public ?string $reference = null;

    public ?string $description = null;

    public ?bool $capture;

    public ?DateTime $capture_on = null;

    public ?CustomerRequest $customer = null;

    public ?BillingDescriptor $billing_descriptor = null;

    public ?ShippingDetails $shipping = null;

    public ?string $previous_payment_id = null;

    public ?RiskRequest $risk = null;

    public ?string $success_url = null;

    public ?string $failure_url = null;

    public ?string $payment_ip = null;

    public ?ThreeDsRequest $three_ds = null;

    public ?PaymentRecipient $recipient = null;

    public ?array $metadata = null;

    public ?array $processing = null;

    public function jsonSerialize(): array
    {
        return [
            "source" => $this->source,
            "amount" => $this->amount,
            "currency" => $this->currency,
            "payment_type" => $this->payment_type,
            "merchant_initiated" => $this->merchant_initiated,
            "reference" => $this->reference,
            "description" => $this->description,
            "capture" => $this->capture,
            "capture_on" => $this->capture_on,
            "customer" => $this->customer,
            "billing" => $this->billing_descriptor,
            "shipping" => $this->shipping,
            "previous_payment_id" => $this->previous_payment_id,
            "risk" => $this->risk,
            "success_url" => $this->success_url,
            "failure_url" => $this->failure_url,
            "payment_ip" => $this->payment_ip,
            "3ds" => $this->three_ds,
            "recipient" => $this->recipient,
            "metadata" => $this->metadata,
            "processing" => $this->processing
        ];
    }
}
