<?php

namespace Checkout;

class CheckoutUtils
{

    public static function replaceArrayKey(array $arr, string $oldKey, string $newKey) : array
    {
        if (array_key_exists($oldKey, $arr)) {
            $keys = array_keys($arr);
            $keys[array_search($oldKey, $keys)] = $newKey;
            return array_combine($keys, $arr);
        }
        return $arr;
    }
}
