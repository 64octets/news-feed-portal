<?php

namespace Utils;

function getImageData($data)
{
    $data = str_replace('data:image/png;base64,', '', $data);
    $base64 = str_replace(' ', '+', $data);
    return base64_decode($base64);
}

function flattenArray(array $array)
{
    $flattenedArray = array();
    array_walk_recursive($array, function ($a) use (&$flattenedArray) {
        $flattenedArray[] = $a;
    });
    return $flattenedArray;
}

function uniqueArray(array $array)
{
    return array_map("unserialize", array_unique(array_map("serialize", $array)));
}

function buildCacheKey(array $multi, array $keys)
{
    $keyArr = [];
    foreach ($keys as $key) {
        if (isset($multi[$key])) {
            $keyArr[] = md5(implode('_', $multi[$key]));
            unset($multi[$key]);
        }
    }

    return implode('_', array_merge($keyArr, $multi));
}
