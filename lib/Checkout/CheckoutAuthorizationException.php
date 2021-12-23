<?php

namespace Checkout;

class CheckoutAuthorizationException extends CheckoutException
{

    public function __construct(string $message)
    {
        parent::__construct($message);
    }

}
