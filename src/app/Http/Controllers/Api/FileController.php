<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileRequest;

class FileController extends Controller
{
    public function compress(FileRequest $request, $type)
    {
        return $this->runHandler($request, $type, 'Compressor');
    }

    public function convert(FileRequest $request, $types)
    {
        return $this->runHandler($request, $types, 'Converter');
    }

    private function runHandler(FileRequest $request, $types, $FileHandler)
    {
        $files = $request->validated();

        try
        {
            $instance = "App\Helpers\Handler\Tools\\$FileHandler";
            $fileHandler = new $instance($files, $types);
        }
        catch (\Exception $e)
        {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'data' => $fileHandler->handle(),
            'errors' => false
        ], 200);
    }
}
