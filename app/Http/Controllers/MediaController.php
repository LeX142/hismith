<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request): \Illuminate\Http\Response
    {
        $filename = config('app.image_path').DIRECTORY_SEPARATOR.
            $request->route('filepath').DIRECTORY_SEPARATOR.
            $request->route('filename');

        if (!Storage::exists($filename)) {
            abort(404);
        }

        $content = Storage::get($filename);
        $mimeType = Storage::mimeType($filename);

        return response(
            content: $content,
            status : 200,
            headers: [
                'Content-type' => $mimeType,
                'Content-Disposition' => 'attachment; filename="'.basename($filename).'"',
            ]
        );
    }
}
