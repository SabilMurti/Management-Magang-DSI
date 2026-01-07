<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Sertifikat Magang - {{ $intern->user->name }}</title>
    <style>
        @page {
            margin: 0;
            padding: 0;
            size: 297mm 210mm landscape;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            width: 297mm;
            height: 210mm;
            background: #fffbf0;
            position: relative;
        }

        /* Enhanced Gold Border */
        .border-outer {
            position: absolute;
            top: 8mm;
            left: 8mm;
            right: 8mm;
            bottom: 8mm;
            border: 6px double #b8860b;
            box-shadow: inset 0 0 0 2px #d4af37;
        }

        .border-inner {
            position: absolute;
            top: 12mm;
            left: 12mm;
            right: 12mm;
            bottom: 12mm;
            border: 3px double #d4a84b;
        }

        /* Enhanced Corner Ornaments */
        .corner {
            position: absolute;
            left: 12mm;
            border-right: none;
            border-top: none;
        }

        .c-br {
            bottom: 12mm;
            right: 12mm;
            border-left: none;
            border-top: none;
        }

        /* Main Content */
        .content {
            position: absolute;
            top: 20mm;
            left: 25mm;
            right: 25mm;
            bottom: 50mm;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .company {
            font-size: 24px;
            font-weight: bold;
            color: #1e3a8a;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-bottom: 3mm;
        }

        .tagline {
            font-size: 12px;
            color: #666;
            letter-spacing: 3px;
            margin-bottom: 10mm;
        }

        .title {
            font-size: 56px;
            font-style: italic;
            font-weight: bold;
            color: #b8860b;
            margin-bottom: 3mm;
        }

        .subtitle {
            font-size: 18px;
            letter-spacing: 5px;
            color: #333;
            text-transform: uppercase;
            margin-bottom: 3mm;
        }

        .cert-no {
            font-size: 11px;
            color: #b8860b;
            margin-bottom: 10mm;
        }

        .intro {
            font-size: 13px;
            font-style: italic;
            color: #555;
            margin-bottom: 5mm;
        }

        .name {
            font-size: 42px;
            font-weight: bold;
            color: #1e3a8a;
            text-transform: uppercase;
            margin-bottom: 3mm;
        }

        .school {
            font-size: 14px;
            color: #444;
            margin-bottom: 8mm;
        }

        .desc {
            font-size: 13px;
            color: #333;
            line-height: 1.6;
            margin-bottom: 4mm;
        }

        .period {
            font-size: 13px;
            color: #b8860b;
            font-weight: bold;
            margin-bottom: 6mm;
        }

        .grade {
            font-size: 28px;
            font-weight: bold;
            color: #b8860b;
            letter-spacing: 3px;
            margin-bottom: 10mm;
        }


        /* Enhanced Signature Section */
        .signature-section {
            position: absolute;
<<<<<<< HEAD
            bottom: 45mm;
            left: 25mm;
            right: 25mm;
        }

        .sig-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            width: 100%;
=======
            bottom: 20mm;
            left: 40mm;
            right: 40mm;
        }

        .signature-table {
            width: 100%;
            table-layout: fixed;
>>>>>>> 22f0b285df02c5f9ee885ae8d6fe20795200b298
        }

        .signature-table td {
            vertical-align: top;
            text-align: center;
        }

<<<<<<< HEAD
        .sig-line {
            border-bottom: 2px solid black;
            width: 70mm;
            margin: 10mm auto 2mm;
=======
        .sig-space {
            height: 18mm;
            border-bottom: 2px solid #333;
            width: 70mm;
            margin: 0 auto 3mm;
>>>>>>> 22f0b285df02c5f9ee885ae8d6fe20795200b298
        }

        .sig-name-new {
            font-size: 14px;
            font-weight: bold;
            color: #1a202c;
            margin-bottom: 1mm;
        }

        .sig-title-new {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
    </style>
</head>

<body>
    <div class="border-outer">
        <div class="border-inner"></div>
    </div>

    <div class="corner c-tl"></div>
    <div class="corner c-tr"></div>
    <div class="corner c-bl"></div>
    <div class="corner c-br"></div>

    <div class="content">
        <div>
            <div class="company">PT. Duta Solusi Informatika</div>
            <div class="tagline">Excellence in Technology</div>

            <div class="title">Sertifikat</div>
            <div class="subtitle">Kelulusan Magang</div>
            <div class="cert-no">Nomor: {{ $intern->certificate_number }}</div>

            <div class="intro">Dengan bangga diberikan kepada:</div>
            <div class="name">{{ $intern->user->name }}</div>
            <div class="school">{{ $intern->school }} - Divisi {{ $intern->department }}</div>

            <div class="desc">
                Telah menyelesaikan program magang di PT. Duta Solusi Informatika dengan dedikasi dan profesionalisme
                yang tinggi.
            </div>
            <div class="period">
                Periode: {{ $intern->start_date->format('d F Y') }} s.d. {{ $intern->end_date->format('d F Y') }}
            </div>

            <div class="grade">
                {{ $intern->getOverallScore() >= 90 ? 'SANGAT BAIK' : ($intern->getOverallScore() >= 80 ? 'BAIK' : 'CUKUP') }}
            </div>
        </div>
    </div>

<<<<<<< HEAD
    <div class="footer">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 50%; text-align: center; vertical-align: bottom;">
                    <div class="sig-box" style="margin: 0 auto;">
                        <div class="sig-line"></div>
                        <div class="sig-name">Manager DSI</div>
                        <div class="sig-title">Pembimbing Lapangan</div>
                    </div>
                </td>
                <td style="width: 50%; text-align: center; vertical-align: bottom;">
                    <div class="sig-box" style="margin: 0 auto;">
                        <div class="sig-line"></div>
                        <div class="sig-name">Kepala Direktur DSI</div>
                        <div class="sig-title">Pimpinan Perusahaan</div>
                    </div>
=======
    <!-- Enhanced Signature Section with Lines -->
    <div class="signature-section">
        <table class="signature-table">
            <tr>
                <td>
                    <div class="sig-space"></div>
                    <div class="sig-name-new">Manager DSI</div>
                    <div class="sig-title-new">Pembimbing Lapangan</div>
                </td>
                <td>
                    <div class="sig-space"></div>
                    <div class="sig-name-new">Direktur DSI</div>
                    <div class="sig-title-new">Pimpinan Perusahaan</div>
>>>>>>> 22f0b285df02c5f9ee885ae8d6fe20795200b298
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
