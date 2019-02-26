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

        switch($this->type) {
            case 'pdf':
                return "gs -sDEVICE=pdfwrite -sOutputFile=$to $from";
            case 'png':
                return "pngquant --quality=50-70 --output=$to $from";
            default:
                return "convert $from -quality 60 $to";
        }
    }
}
