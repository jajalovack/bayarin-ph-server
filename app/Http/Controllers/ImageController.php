<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image'=>'required|image|mimes:png,jpeg,jpg,webp'
        ]);
        $image_name=time().'.'.$request->image->extension();
        $request->image->move(storage_path('app/public/images'),$image_name);

        return response([
            'profile'=>$image_name
        ],201);
    }

    public function profile(string $filename)
    {
        $file = str_replace('%dot','.',storage_path('app/public/images/' . $filename));

        if (file_exists($file)) {
            $image = file_get_contents($file);
            $mime = mime_content_type($file);
            http_response_code(200);

            return response($image,http_response_code(200))->header('Content-Type', $mime);
        }

        return response([
            'message' => 'Image not found'
        ], 404);
    }
}
