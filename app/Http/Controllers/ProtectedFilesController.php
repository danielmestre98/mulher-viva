<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProtectedFilesController extends Controller
{
    function showBeneficiariaFiles($beneficiariaId, $fileName)
    {
        $filePath = "uploads/" . $beneficiariaId . "/" . $fileName;

        if (!Storage::disk('public')->exists($filePath)) {
            abort(404);
        }

        return Storage::disk('public')->response($filePath);
    }
}
