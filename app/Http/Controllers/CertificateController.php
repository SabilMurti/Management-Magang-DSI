<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CertificateController extends Controller
{
    /**
     * Generate internship certificate PDF
     */
    public function generate(Intern $intern)
    {
        // Check if intern is eligible (e.g., completed)
        // If not strictly enforced, we can just allow generation
        if ($intern->status !== 'completed') {
            return back()->with('error', 'Sertifikat hanya dapat dibuat untuk siswa magang yang sudah menyelesaikan masa magang.');
        }

        // Generate certificate number if not exists
        if (!$intern->certificate_number) {
            $year = Carbon::now()->format('Y');
            $id = str_pad($intern->id, 4, '0', STR_PAD_LEFT);
            $intern->update([
                'certificate_number' => "MG-DSI/{$year}/{$id}",
                'certificate_issued_at' => Carbon::now(),
            ]);
        }

        // Load PDF
        // Use A4 Landscape
        $pdf = Pdf::loadView('pdf.certificate', [
            'intern' => $intern,
            'title' => 'Sertifikat Magang'
        ])->setPaper('a4', 'landscape');

        return $pdf->stream("Sertifikat-{$intern->user->name}.pdf");
    }
}
