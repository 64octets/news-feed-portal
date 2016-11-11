<?php

namespace Service;

class Validator
{
    public static function validate($data, $livr)
    {

        \Validator\LIVR::registerDefaultRules([
            'latin_string' => function () {
                return function ($value) {
                    if (!isset($value) || $value === '') {
                        return;
                    }

                    if (!is_string($value)) {
                        return 'FORMAT_ERROR';
                    }

                    $validStringReg = '/^[a-zA-Z0-9\-\_\+\#№"\']+$/';

                    if (!preg_match($validStringReg, $value)) {
                        return 'WRONG_STRING';
                    }

                    return;
                };
            },
            'phone' => function () {
                return function ($value, $undev, &$out) {
                    if (!isset($value) || $value === '') {
                        return;
                    }

                    if (!is_string($value)) {
                        return 'FORMAT_ERROR';
                    }

                    $value = preg_replace('/[^+0-9]/', '', $value);

                    $reg = '/^[+0-9]{1,14}$/';

                    if (!preg_match($reg, $value)) {
                        return 'WRONG_FORMAT';
                    }
                    $out = $value;

                    return;
                };
            },
            'iso_datetime'  => function() {
                return function ($value) {
                    if (!isset($value) || $value === '') {
                        return;
                    }

                    if (!is_string($value)) {
                        return 'FORMAT_ERROR';
                    }

                    $isoDateTimeReg = '/(\d{4}-[01]\d-[0-3]\dT[0-2]\d:[0-5]\d:[0-5]\d\.\d+)|(\d{4}-[01]\d-[0-3]\dT[0-2]\d:[0-5]\d:[0-5]\d)|(\d{4}-[01]\d-[0-3]\dT[0-2]\d:[0-5]\d)/';

                    if (preg_match($isoDateTimeReg, $value)) {
                        return;
                    }

                    return "WRONG_DATE";
                };
            },
            'list_objects' => function () {
                return function ($value) {
                    if (!isset($value) || !$value) {
                        return;
                    }

                    if (!is_array($value) || !\Validator\LIVR\Util::isAssocArray($value)) {
                        return 'FORMAT_ERROR';
                    }

                    foreach ($value as $object) {
                        if (!is_array($value) || !\Validator\LIVR\Util::isAssocArray($object)) {
                            return 'FORMAT_ERROR';
                        }
                    }

                    return;
                };
            }
        ]);

        $validator = new \Validator\LIVR($livr);

        $validated = $validator->validate($data);
        $errors    = $validator->getErrors();

        if ($errors) {
            throw new X([ 'Type' => 'FORMAT_ERROR', 'Fields' => $errors ]);
        }

        return $validated;
    }
}
