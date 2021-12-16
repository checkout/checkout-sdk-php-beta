<?php

namespace Checkout\Instruments;

use Checkout\Common\CustomerRequest;
use Checkout\Common\Phone;

final class InstrumentCustomerRequest extends CustomerRequest
{

    public bool $default;

    public Phone $phone;

}
