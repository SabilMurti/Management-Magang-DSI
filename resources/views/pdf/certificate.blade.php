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

        /* Gold Border */
        .border-outer {
            position: absolute;
            top: 8mm;
            left: 8mm;
            right: 8mm;
            bottom: 8mm;
            border: 5px solid #b8860b;
        }

        .border-inner {
            position: absolute;
            top: 3mm;
            left: 3mm;
            right: 3mm;
            bottom: 3mm;
            border: 2px solid #d4a84b;
        }

        /* Corner Ornaments */
        .corner {
            position: absolute;
            width: 30px;
            height: 30px;
            border: 3px solid #b8860b;
        }
        .c-tl { top: 12mm; left: 12mm; border-right: none; border-bottom: none; }
        .c-tr { top: 12mm; right: 12mm; border-left: none; border-bottom: none; }
        .c-bl { bottom: 12mm; left: 12mm; border-right: none; border-top: none; }
        .c-br { bottom: 12mm; right: 12mm; border-left: none; border-top: none; }

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
            font-size: 20px;
            font-weight: bold;
            color: #1e3a8a;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 2mm;
        }

        .tagline {
            font-size: 10px;
            color: #666;
            letter-spacing: 2px;
            margin-bottom: 8mm;
        }

        .title {
            font-size: 48px;
            font-style: italic;
            color: #b8860b;
            margin-bottom: 2mm;
        }

        .subtitle {
            font-size: 16px;
            letter-spacing: 4px;
            color: #333;
            text-transform: uppercase;
            margin-bottom: 2mm;
        }

        .cert-no {
            font-size: 10px;
            color: #b8860b;
            margin-bottom: 8mm;
        }

        .intro {
            font-size: 12px;
            font-style: italic;
            color: #555;
            margin-bottom: 4mm;
        }

        .name {
            font-size: 36px;
            font-weight: bold;
            color: #1e3a8a;
            text-transform: uppercase;
            margin-bottom: 2mm;
        }

        .school {
            font-size: 12px;
            color: #444;
            margin-bottom: 6mm;
        }

        .desc {
            font-size: 11px;
            color: #333;
            line-height: 1.5;
            margin-bottom: 3mm;
        }

        .period {
            font-size: 11px;
            color: #b8860b;
            margin-bottom: 5mm;
        }

        .grade {
            font-size: 24px;
            font-weight: bold;
            color: #b8860b;
            letter-spacing: 2px;
            margin-bottom: 8mm;
        }

        /* Footer */
        .footer {
            position: absolute;
            bottom: 45mm;
            left: 25mm;
            right: 25mm;
        }

        .sig-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            width: 100%;
        }

        .sig-box {
            display: flex;
            flex-direction: column;
            text-align: center;
            width: 60mm;
            flex-shrink: 0;
        }

        .sig-line {
            border-bottom: 2px solid black;
            width: 70mm;
            margin: 10mm auto 2mm;
        }

        .sig-name {
            font-size: 12px;
            font-weight: bold;
            color: #1a202c;
            margin-bottom: 1mm;
        }

        .sig-title {
            font-size: 9px;
            color: #666;
            text-transform: uppercase;
        }

        .seal {
            width: 55px;
            height: 55px;
            border: 3px double #b8860b;
            border-radius: 50%;
            margin: 0 auto 2mm;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fffbf0;
        }

        .seal-text {
            font-size: 10px;
            font-weight: bold;
            color: #b8860b;
            text-align: center;
            line-height: 1.2;
        }

        .date {
            font-size: 10px;
            color: #555;
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
                Telah menyelesaikan program magang di PT. Duta Solusi Informatika dengan dedikasi dan profesionalisme yang tinggi.
            </div>
            <div class="period">
                Periode: {{ $intern->start_date->format('d F Y') }} s.d. {{ $intern->end_date->format('d F Y') }}
            </div>

            <div class="grade">
                {{ $intern->getOverallScore() >= 90 ? 'SANGAT BAIK' : ($intern->getOverallScore() >= 80 ? 'BAIK' : 'CUKUP') }}
            </div>
        </div>
    </div>

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
                </td>
            </tr>
        </table>
    </div>
</body>
</html>