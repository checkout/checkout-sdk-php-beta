<?php

namespace Checkout\Payments\Source\Apm;

use Checkout\Common\PaymentSourceType;
use Checkout\Payments\Source\AbstractRequestSource;

class RequestBalotoSource extends AbstractRequestSource
{
    public function __construct()
    {
        parent::__construct(PaymentSourceType::$baloto);
    }

    public string $integration_type = "redirect";
    public string $country;
    public string $description;
    public BalotoPayer $payer;
}
