<?php

namespace App\Helpers\Handler;


class Compressor extends FileHandler
{
    public function __construct($files, $types)
    {
        $type = explode('-to-', $types);
        parent::__construct($files, $type);
    }

    public function command($to, $from) {
        if($this->type === 'pdf') {
            return "gs -sDEVICE=pdfwrite -sOutputFile=$to $from";
        }

        return "convert $from -quality 50 $to";
    }
}
