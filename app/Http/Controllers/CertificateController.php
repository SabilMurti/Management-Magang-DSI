<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Mpdf\Mpdf;

class CertificateController extends Controller
{
    /**
     * Generate internship certificate PDF using mPDF
     */
    public function generate(Intern $intern)
    {
        // Check if intern is eligible (e.g., completed)
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

        // Create mPDF instance with A4 Landscape
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L', // A4 Landscape
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0,
            'margin_header' => 0,
            'margin_footer' => 0,
            'dpi' => 80,
        ]);

        // Enable CSS better support
        $mpdf->showImageErrors = true;
        $mpdf->useSubstitutions = false;
        
        // Render the blade view to HTML
        $html = view('pdf.certificate', [
            'intern' => $intern,
            'title' => 'Sertifikat Magang'
        ])->render();

        // Write HTML to PDF
        $mpdf->WriteHTML($html);

        // Output PDF inline (display in browser)
        return response($mpdf->Output('', 'S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="Sertifikat-' . $intern->user->name . '.pdf"');
    }
}