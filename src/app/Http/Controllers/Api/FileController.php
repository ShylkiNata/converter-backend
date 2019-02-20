<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ActionHelper;
use App\Helpers\Converter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Imagick;
use Intervention\Image\Facades\Image;

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
//        $converter = new Converter($type);
        $types = explode('-to-', $type);

        foreach ($request->all() as $key => $value) {
//            $converter->setFile($request->file($key));
//            $converter->convert();
            try {
                $imagick = new Imagick($request->file($key));
                $imagick->setImageFormat($types[1]);
                var_dump('test');
            } catch (\ImagickException $e) {
            }
        }
    }


}
