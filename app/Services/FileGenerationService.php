<?php 

namespace App\Services;

use App\Interfaces\GenerateFileInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileGenerationService implements GenerateFileInterface
{
    public function generate($data)
    {
        $pdf = Pdf::loadView('pdf.holiday-plan', ['data' => $data->toArray()]);
        
        $fileName = Str::of($data->title)->slug('-');

        Storage::put("public/pdf/{$fileName}.pdf", $pdf->output());

        return $pdf->download("holiday-plan-{$fileName}.pdf");
    }

}