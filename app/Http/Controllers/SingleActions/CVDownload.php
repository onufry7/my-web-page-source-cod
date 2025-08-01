<?php

namespace App\Http\Controllers\SingleActions;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class CVDownload extends Controller
{
    public function __invoke(): RedirectResponse|StreamedResponse
    {
        $filePath = 'documents/cv/burnejko-cv.pdf';
        $fileName = 'Burnejko-CV.pdf';

        try {
            $mimeType = Storage::disk('public')->mimeType($filePath);

            return Storage::disk('public')->download($filePath, $fileName, ["Content-Type: $mimeType"]);
        } catch (Throwable $th) {
            return back()->withFragment('brand')->dangerBanner(__('Failed download CV file!'));
        }
    }
}
