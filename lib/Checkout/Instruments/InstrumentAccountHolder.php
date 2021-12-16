<?php

namespace Checkout\Instruments;

use Checkout\Common\Address;
use Checkout\Common\Phone;

final class InstrumentAccountHolder
{
    public Address $billing_address;

    public Phone $phone;
}
