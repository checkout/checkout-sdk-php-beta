<?php

namespace Checkout\Tests\Instruments\Four;

use Checkout\CheckoutApiException;
use Checkout\CheckoutAuthorizationException;
use Checkout\Common\Country;
use Checkout\Common\Currency;
use Checkout\Common\Four\AccountHolder;
use Checkout\Common\Four\AccountHolderType;
use Checkout\Customers\Four\CustomerRequest;
use Checkout\Instruments\Four\Create\CreateCustomerInstrumentRequest;
use Checkout\Instruments\Four\Create\CreateTokenInstrumentRequest;
use Checkout\Instruments\Four\Get\BankAccountFieldQuery;
use Checkout\Instruments\Four\Get\PaymentNetwork;
use Checkout\Instruments\Four\Update\UpdateCardInstrumentRequest;
use Checkout\Instruments\Four\Update\UpdateCustomerRequest;
use Checkout\Instruments\Four\Update\UpdateTokenInstrumentRequest;
use Checkout\PlatformType;
use Checkout\Tests\Payments\Four\AbstractPaymentsIntegrationTest;
use Checkout\Tests\SandboxTestFixture;
use Exception;

class BankAccountFieldFormattingIntegrationTest extends SandboxTestFixture
{

    /**
     * @before
     * @throws CheckoutAuthorizationException
     */
    public function before(): void
    {
        $this->init(PlatformType::$fourOAuth);
    }

    /**
    * @test
    * @throws CheckoutApiException
    */
    public function shouldFailGetBankAccountFieldFormattingWhenNoOAuthIsProvided() : void
    {
        $request = new BankAccountFieldQuery();
        $request->account_holder_type = AccountHolderType::$individual;
        $request->payment_network = PaymentNetwork::$local;

        $response = $this->fourApi->getInstrumentsClient()->getBankAccountFieldFormatting(Country::$GB, Currency::$GBP, $request);

        $this->assertResponse($response,"sections");

        foreach ($response["sections"] as $section)
        {
            self::assertResponse($section, "name", "fields");
            self::assertNotEmpty($section["fields"]);

            foreach ($section["fields"] as $field)
            {
                $this->assertResponse($field, "id", "display", "type");
            }
        }
    }
}
