<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function compress(Request $request, $type)
    {
        return $this->runHandler($request->files, $type, 'App\Helpers\Handler\Tools\Compressor');
    }

    public function convert(Request $request, $types)
    {
        return $this->runHandler($request->files, $types, 'App\Helpers\Handler\Tools\Converter');
    }

    private function runHandler($files, $types, $FileHandler)
    {
        try
        {
            $fileHandler = new $FileHandler($files, $types);
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
