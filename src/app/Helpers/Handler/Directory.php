<?php

namespace App\Helpers\Handler;

use Illuminate\Support\Facades\File;


class Directory
{
    private $uid = null;
    public $paths = null;

    public function __construct()
    {
        $this->uid = uniqid();
        $this->createDirectory();
    }

    private function createDirectory() {
        $path = storage_path("app/public/images/$this->uid");

        $this->paths = [
            "public" => $path,
            "zip" => "$path/$this->uid.zip",
            "download" => "storage/images/$this->uid/$this->uid.zip"
        ];

        File::makeDirectory($path);
    }

    public function getUid() {
        return $this->uid;
    }

    public function exists($entity) {
        return File::exists($this->paths[$entity]);
    }

    public function file($name) {
        return "$this->paths/$name";
    }
}
