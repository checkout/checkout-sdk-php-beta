<?php

namespace Checkout\Payments\Source\Apm;

use Checkout\Common\Address;
use Checkout\Common\PaymentSourceType;
use Checkout\Payments\Source\AbstractRequestSource;

class RequestRapiPagoSource extends AbstractRequestSource
{
    public function __construct()
    {
        parent::__construct(PaymentSourceType::$rapipago);
    }

    public string $integration_type = "redirect";
    public string $country;
    public Payer $payer;
    public string $description;
}
