<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadFileController extends Controller
{
    //
    public function showForm()
    {
        return view('upload-file.show-form');
    }

    public function handleUpload(Request $request)
    {
        $file = $request->file('fileToUpload');

        $folder = 'ahihi/kiki';

        $filePathAfterUpload = Storage::put($folder, $file);

        $filePathAfterUpload = 'storage/' . $filePathAfterUpload;

        return redirect()->route('upload-file.showForm');
    }
}
