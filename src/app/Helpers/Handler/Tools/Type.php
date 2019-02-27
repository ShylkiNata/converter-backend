<?php

namespace App\Helpers\Handler\Tools;

use Illuminate\Http\Request;

class Type
{
    public static function fromRequest(Request $request, $index = 0) {
        $path = str_replace('api/', '', $request->path());

        $parts = explode('/', $path);
        $tool = array_pop($parts);

        return self::fromStr($tool, $index);
    }

    public static function fromStr($tool, $index) {
        $type = explode('-to-', $tool);
        return $type[$index];
    }

    public static function derivative($value) {
        if($value === 'jpg') {
            return $value.',jpeg';
        }
        return $value;
    }
}
