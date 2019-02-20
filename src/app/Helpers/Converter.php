<?php

namespace App\Helpers;


use Imagick;

class Converter
{
    private $file = null;
    private $method = null;

    public function __construct($type)
    {
        $this->method = ActionHelper::getMethodByStr($type);
    }

    public function setFile($file)
    {
        $this->file = $file;
    }

    public function convert()
    {
        call_user_func($this->method);
    }

    private function JpgToPdf()
    {

    }
}
