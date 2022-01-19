<?php

namespace Checkout;

use DateTime;
use DateTimeInterface;

class CheckoutUtils
{

    public static function replaceArrayKey(array $arr, string $oldKey, string $newKey): array
    {
        if (array_key_exists($oldKey, $arr)) {
            $keys = array_keys($arr);
            $keys[array_search($oldKey, $keys)] = $newKey;
            return array_combine($keys, $arr);
        }
        return $arr;
    }

    /**
     * @throws CheckoutApiException
     * */
    public static function getVersion(): string
    {
        $search = "lib" . DIRECTORY_SEPARATOR . 'Checkout';
        $composerFile = str_replace($search, "composer.json", __DIR__);
        $contentComposer = json_decode(file_get_contents($composerFile), true);

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
