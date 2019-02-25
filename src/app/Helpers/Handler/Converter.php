<?php

namespace App\Helpers\Handler;


class Converter extends FileHandler
{
    public function __construct($files, $types)
    {
        $type = explode('-to-', $types);
        parent::__construct($files, $type[1]);
    }

    public function command($to, $from) {
        return "convert $from $to";
    }
}
