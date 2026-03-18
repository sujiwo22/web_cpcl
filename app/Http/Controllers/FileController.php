<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class FileController extends Controller
{
    // public function viewPdf($filename)
    // {
    //     $path = storage_path('file_proposal/' . $filename); // Adjust the path as needed

    //     if (!Storage::exists('file_proposal/' . $filename)) {
    //         abort(404);
    //     }

    //     $fileContents = Storage::get('private_pdfs/' . $filename);

    //     return Response::make($fileContents, 200, [
    //         'Content-Type' => 'application/pdf',
    //         'Content-Disposition' => 'inline; filename="' . $filename . '"' // 'inline' displays in browser
    //     ]);
    // }

    public function viewFile($filename)
    {
        $filePath = storage_path("app/private/private_pdfs/{$filename}");

        if (!Storage::disk('local')->exists("private_pdfs/{$filename}")) {
            abort(404);
        }

        // You can add authorization checks here (e.g., check if the user owns the file)
        // if (auth()->user()->cannot('view', $file)) { abort(403); }

        return response()->file($filePath);
        // return response()->download($filePath, $filename); // Initiates a download
        // Or use response()->file($filePath) to display in the browser if it's an image/PDF
    }
    
    public function downloadFile($filename)
    {
        $filePath = storage_path("app/private/private_pdfs/{$filename}");

        if (!Storage::disk('local')->exists("private_pdfs/{$filename}")) {
            abort(404);
        }
        return response()->download($filePath, $filename); 
    }

    public function checkFile($filename)
    {
        $filePath = storage_path("app/private/private_pdfs/{$filename}");

        if (!Storage::disk('local')->exists("private_pdfs/{$filename}")) {
            return false;
        }else{
            return true;
        }
    }

}
