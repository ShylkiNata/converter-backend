<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Handler\Compressor;
use App\Helpers\Handler\Converter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function compress(Request $request, $type)
    {
        $compressor = new Compressor($request->files, $type);

        return response()->json([
            'data' => $compressor->handle(),
            'errors' => false
        ], 200);
    }

    public function converter(Request $request, $types) {
        $converter = new Converter($request->files, $types);

        return response()->json([
            'data' => $converter->handle(),
            'errors' => false
        ], 200);
    }
}
