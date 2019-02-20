<?php

namespace App\Helpers;


class ActionHelper
{
    public static function getMethodByStr($param) {
        $parts = explode('-', $param);

        foreach($parts as $index => $value) {
            $buffer = strtoupper($value[0]).substr($value, 1);
            $parts[$index] = $buffer;
        }

        return implode($parts, '');
    }
}
