<?php

namespace Checkout\Payments\Four\Request;

use Checkout\CheckoutUtils;
use Checkout\Common\CustomerRequest;
use Checkout\Common\MarketplaceData;
use Checkout\Payments\Four\Request\Source\AbstractRequestSource;
use Checkout\Payments\Four\Sender\PaymentSender;
use Checkout\Payments\PaymentRecipient;
use Checkout\Payments\ProcessingSettings;
use Checkout\Payments\RiskRequest;
use Checkout\Payments\ShippingDetails;
use Checkout\Payments\ThreeDsRequest;
use DateTime;
use JsonSerializable;

class PaymentRequest implements JsonSerializable
{
    public AbstractRequestSource $source;

    public int $amount;

    public string $currency;

    //AuthorizationType
    public string $payment_type;

    public bool $merchant_initiated;

    public string $reference;

    public string $description;

    public string $authorization_type;

    public bool $capture;

    public DateTime $capture_on;

    public CustomerRequest $customer;

    public ShippingDetails $shipping;

    public ThreeDsRequest $three_ds;

    public string $processing_channel_id;

    public string $previous_payment_id;

    public RiskRequest $risk;

    public string $success_url;

    public string $failure_url;

    public string $payment_ip;

    public PaymentSender $sender;

    public PaymentRecipient $recipient;

    public MarketplaceData $marketplace;

    public ProcessingSettings $processing;

    public array $metadata;

    public function jsonSerialize(): array
    {
        return CheckoutUtils::replaceArrayKey(get_object_vars($this), "three_ds", "3ds");
    }

}
