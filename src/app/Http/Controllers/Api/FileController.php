<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ActionHelper;
use App\Helpers\Converter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Imagick;
use Intervention\Image\Facades\Image;
use Mockery\Exception;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class FileController extends Controller
{
    public function compress(Request $request, $type)
    {
        foreach ($request->all() as $key=>$value) {
            /*$file = $request->file($key);
            $img = Image::make($file);
            var_dump($img->filesize());
            var_dump($img->encode($type, 85)->encoded);*/
        }
    }
    public function convert(Request $request, $type)
    {
        $types = explode('-to-', $type);

        $uid = uniqid();
        $destination = storage_path("images/$uid");

        File::makeDirectory($destination);

        try {
            foreach ($request->files as $name => $file) {
                $from = $file->getRealPath();
                $to = "$destination/$name.$types[1]";

                $this->runProcess("convert $from $to");
            }
            return response()->json([
                'ok' => $uid,
                'errors' => false
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'errors' => $e->getMessage()
            ], 500);
        }
    }
    public function archive($uid) {
        $folder = storage_path("images/$uid/");

        if(!File::exists($folder)) {
            return response()->json([
                'ok' => false,
                'errors' => 'Destination folder not exists'
            ], 404);
        }

        try {
            $zipPath = "$folder$uid.zip";
            $this->runProcess("cd $folder; zip -c $zipPath *");

            return response()
                ->download($zipPath)
                ->deleteFileAfterSend(false);
        }
        catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    private function runProcess($command) {
        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }
}
