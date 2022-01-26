<?php

namespace Checkout\Instruments\Four\Get;

use Checkout\CheckoutUtils;
use Checkout\Common\AbstractQueryFilter;

final class BankAccountFieldQuery extends AbstractQueryFilter
{
    public string $account_holder_type;
    public string $payment_network;

    public function serializePropertiesName()
    {
        CheckoutUtils::replaceKey($this, "account_holder_type", "account-holder-type");
        CheckoutUtils::replaceKey($this, "payment_network", "payment-network");
    }
}
