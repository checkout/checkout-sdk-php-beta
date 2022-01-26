<?php

namespace Checkout;

use DateTime;
use DateTimeInterface;

class CheckoutUtils
{

    /**
     * @throws CheckoutApiException
     * */
    public static function getVersion(): string
    {
        $normalizeDir = str_replace(__DIR__, '\\', '//');
        $path = str_replace($normalizeDir, "\lib\checkout", "composer.json");
        $contentComposer = json_decode(file_get_contents($path), true);

        if (!array_key_exists("version", $contentComposer)) {
            throw new CheckoutApiException("the version doesn't exist in the file composer.json");
        }

        return $contentComposer["version"];
    }

    public static function formatDate(DateTime $date): string
    {
        return $date->format(DateTimeInterface::ISO8601);
    }

}
