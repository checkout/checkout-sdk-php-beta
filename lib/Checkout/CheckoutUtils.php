<?php

namespace Checkout;

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
        $normalizeDir = str_replace(__DIR__, '\\', '//');
        $path = str_replace($normalizeDir, "\lib\checkout", "composer.json");
        $contentComposer = json_decode(file_get_contents($path), true);

        if (!array_key_exists("version", $contentComposer)) {
            throw new CheckoutApiException("the version doesn't exist in the file composer.json");
        }
        
        return $contentComposer["version"];
    }
}
