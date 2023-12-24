<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    public function show($filename)
    {
        $path = storage_path('app/public/' . $filename);

        if (!Storage::exists($filename)) {
            abort(404);
        }

        return response()->file($path);
    }
}
