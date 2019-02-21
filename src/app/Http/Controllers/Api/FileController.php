<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class FileController extends Controller
{
    public function compress(Request $request, $type)
    {
        foreach ($request->all() as $key=>$value) {
            $uid = uniqid();
            $destination = storage_path("app/public/images/$uid");

            File::makeDirectory($destination);

            try {
                foreach ($request->files as $name => $file) {
                    $from = $file->getRealPath();
                    $to = "$destination/$name.$type";

                    if($type === 'pdf') {
                        $cmd = "gs -sDEVICE=pdfwrite -sOutputFile=$to $from";
                    }
                    else {
                        $cmd = "convert $from -quality 50 $to";
                    }
                    $this->runProcess($cmd);
                }

                $pathToDownload = $this->archive($uid);

                return response()->json([
                    'ok' => $pathToDownload,
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
    }
    public function convert(Request $request, $type)
    {
        $types = explode('-to-', $type);

        $uid = uniqid();
        $destination = storage_path("app/public/images/$uid");

        File::makeDirectory($destination);

        try {
            foreach ($request->files as $name => $file) {
                $from = $file->getRealPath();
                $to = "$destination/$name.$types[1]";

                $this->runProcess("convert $from $to");
            }

            $pathToDownload = $this->archive($uid);

            return response()->json([
                'ok' => $pathToDownload,
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
        $folder = storage_path("app/public/images/$uid/");

        if(!File::exists($folder)) {
            return response()->json([
                'ok' => false,
                'errors' => 'Destination folder not exists'
            ], 404);
        }

        try {
            $publicZip = "storage/images/$uid/$uid.zip";
            $zipPath = "$folder$uid.zip";
            $this->runProcess("cd $folder; zip -c $zipPath *");

            /*
            return response()
                ->download($public)
                ->deleteFileAfterSend(false);
            */
            return $publicZip;
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
            var_dump($process->getErrorOutput());
            //throw new ProcessFailedException($process);
        }
    }

    private function deviceByType($type) {
        switch ($type) {
            case 'jpg':
                return 'jpeg';
            case 'png':
                return 'png16m';
            case 'pdf':
                return 'pdfwrite';
            default:
                return '';
        }
    }
}
