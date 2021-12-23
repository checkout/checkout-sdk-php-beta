<?php

namespace Checkout\Instruments;

final class CreateInstrumentRequest
{

    public string $type;

    public string $token;

    public InstrumentAccountHolder $account_holder;

    public InstrumentCustomerRequest $customer;

}
