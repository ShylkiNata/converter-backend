<?php

namespace App\Helpers\Handler\Tools;


use App\Helpers\Handler\FileHandler;

class Compressor extends FileHandler
{
    public function __construct($files, $type)
    {
        parent::__construct($files, $type);
    }

    public function command($to, $from) {
        if($this->type === 'pdf') {
            return "gs -sDEVICE=pdfwrite -sOutputFile=$to $from";
        }

        return "convert $from -quality 50 $to";
    }
}
