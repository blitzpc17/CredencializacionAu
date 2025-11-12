<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class ToolsController extends Controller
{
    public function ObtenerImagen(Request $r){

        $path = $r->path;

         if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }
    
        $file = Storage::disk('public')->get($path);
        $type = Storage::disk('public')->mimeType($path);
    
        return Response::make($file, 200)
            ->header("Content-Type", $type);

    }
}
