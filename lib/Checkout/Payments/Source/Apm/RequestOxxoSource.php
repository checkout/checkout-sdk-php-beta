<?php

namespace Checkout\Payments\Source\Apm;

use Checkout\Common\Address;
use Checkout\Common\PaymentSourceType;
use Checkout\Payments\Source\AbstractRequestSource;

class RequestOxxoSource extends AbstractRequestSource
{
    public function __construct()
    {
        parent::__construct(PaymentSourceType::$oxxo);
    }

    public string $integration_type = "redirect";
    public string $country;
    public Payer $payer;
    public string $description;
}
