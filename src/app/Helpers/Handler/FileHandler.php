<?php

namespace App\Helpers\Handler;

use Mockery\Exception;
use Symfony\Component\Process\Process;

abstract class FileHandler
{
    private $files = null;
    private $directory = null;
    protected $type = null;

    public function __construct($files, $type)
    {
        $this->type = $type;
        $this->files = $files;
        $this->directory = new Directory();
    }

    abstract function command($to, $from);

    protected function archive() {
        if($this->directory->exists('public')) {
            throw new \Exception("Destination folder not exists", 400);
        }

        $public = $this->directory->paths["public"];
        $zip = $this->directory->paths["zip"];

        $this->runProcess("cd $public; zip -c $zip *");

        return $this->directory->paths["download"];
    }

    public function handle()
    {

        foreach ($this->files as $name => $file) {
            $from = $file->getRealPath();
            $to = $this->directory->file("$name.$this->type");

            $this->runProcess($this->command($to, $from));
        }

        $path = $this->archive();

        return $path;
    }

    protected function runProcess($command) {

        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \Exception("An error occurred during the file processing", 500);
        }
    }
}
