<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Magang - {{ $intern->user->name }}</title>
    <style>
        @page {
            margin: 0;
            size: A4 landscape;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            -webkit-print-color-adjust: exact;
        }
        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #fffdf5; /* Light cream parchment color */
            z-index: -1;
        }
        .border-outer {
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            bottom: 15px;
            border: 5px solid #b8860b; /* Dark GoldenRod */
            padding: 3px;
        }
        .border-inner {
            position: relative;
            height: 100%;
            border: 2px solid #daa520; /* GoldenRod */
            padding: 30px;
            box-sizing: border-box;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23b8860b' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .corner-decoration {
            position: absolute;
            width: 80px;
            height: 80px;
            border: 3px solid #b8860b;
            z-index: 10;
        }
        .top-left { top: -3px; left: -3px; border-right: none; border-bottom: none; }
        .top-right { top: -3px; right: -3px; border-left: none; border-bottom: none; }
        .bottom-left { bottom: -3px; left: -3px; border-right: none; border-top: none; }
        .bottom-right { bottom: -3px; right: -3px; border-left: none; border-top: none; }

        .content {
            text-align: center;
            position: relative;
            z-index: 20;
            padding-top: 20px;
        }
        
        .company-logo {
            font-size: 28px;
            font-weight: bold;
            color: #1a5f7a;
            letter-spacing: 2px;
            margin-bottom: 5px;
            text-transform: uppercase;
            font-family: Arial, sans-serif;
        }
        
        .company-subtitle {
            font-size: 12px;
            color: #555;
            letter-spacing: 4px;
            margin-bottom: 40px;
            text-transform: uppercase;
        }

        .certificate-title {
            font-family: 'Pinyon Script', 'Times New Roman', serif;
            font-size: 56px;
            font-weight: normal;
            color: #b8860b;
            margin: 0;
            line-height: 1;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }

        .certificate-subtitle {
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 4px;
            color: #333;
            margin-top: 10px;
            margin-bottom: 40px;
            border-bottom: 1px solid #b8860b;
            display: inline-block;
            padding-bottom: 10px;
        }

        .body-text {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
            font-style: italic;
        }

        .recipient-name {
            font-family: 'Times New Roman', serif;
            font-size: 42px;
            font-weight: bold;
            color: #1a202c;
            margin: 10px 0;
            text-transform: capitalize;
            border-bottom: 2px solid #ddd;
            display: inline-block;
            min-width: 400px;
            padding-bottom: 10px;
        }

        .recipient-school {
            font-size: 20px;
            color: #4a5568;
            margin-top: 10px;
            font-weight: 500;
        }

        .description {
            font-size: 16px;
            line-height: 1.8;
            color: #4a5568;
            margin: 30px auto;
            max-width: 800px;
        }

        .highlight {
            color: #1a5f7a;
            font-weight: bold;
        }

        .seal {
            width: 100px;
            height: 100px;
            border: 3px double #b8860b;
            border-radius: 50%;
            margin: 0 auto;
            align-items: center;
            justify-content: center;
            color: #b8860b;
            font-weight: bold;
            font-size: 14px;
            background-color: rgba(184, 134, 11, 0.05);
            position: relative;
            text-align: center;
            line-height: 100px;
        }
        
        .seal-inner {
            border: 1px dashed #b8860b;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            line-height: 80px;
            transform: rotate(-15deg);
            opacity: 0.8;
            position: absolute;
            top: -5px;
            left: 3px;
            font-size: 12px;
        }

        .footer {
            margin-top: 60px;
            width: 100%;
            display: table;
        }

        .signature-block {
            display: table-cell;
            width: 33%;
            text-align: center;
            vertical-align: top;
        }

        .seal {
            width: 120px;
            height: 120px;
            border: 3px double #b8860b;
            border-radius: 50%;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #b8860b;
            font-weight: bold;
            font-size: 14px;
            background-color: rgba(184, 134, 11, 0.05);
            position: relative;
        }
        
        .seal-inner {
            border: 1px dashed #b8860b;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin: 7px; /* approx centered */
            line-height: 100px;
            transform: rotate(-15deg);
            opacity: 0.8;
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            margin: auto;
        }

        .signature-line {
            width: 200px;
            border-bottom: 1px solid #333;
            margin: 60px auto 10px auto;
        }

        .signer-name {
            font-weight: bold;
            font-size: 16px;
            color: #000;
        }

        .signer-title {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .auto-date {
            font-size: 14px;
            color: #555;
            margin-top: 20px;
            text-align: center;
        }

        .header-with-seal {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }

        .header-left, .header-right {
            display: table-cell;
            width: 120px;
            vertical-align: middle;
        }

        .header-center {
            display: table-cell;
            text-align: center;
            vertical-align: middle;
        }

        .seal-top {
            width: 100px;
            height: 100px;
            border: 3px double #b8860b;
            border-radius: 50%;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #b8860b;
            font-weight: bold;
            font-size: 12px;
            background-color: rgba(184, 134, 11, 0.05);
            position: relative;
        }
        
        .seal-top-inner {
            border: 1px dashed #b8860b;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            line-height: 80px;
            transform: rotate(-15deg);
            opacity: 0.8;
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            margin: auto;
            font-size: 11px;
        }
        
        .ribbon {
            position: absolute;
            right: -5px; top: -5px;
            z-index: 1;
            overflow: hidden;
            width: 75px; height: 75px;
            text-align: right;
        }
        .ribbon span {
            font-size: 10px;
            font-weight: bold;
            color: #FFF;
            text-transform: uppercase;
            text-align: center;
            line-height: 20px;
            transform: rotate(45deg);
            -webkit-transform: rotate(45deg);
            width: 100px;
            display: block;
            background: #b8860b;
            box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
            position: absolute;
            top: 19px; right: -21px;
        }
    </style>
</head>
<body>
    <div class="background">
        <div class="border-outer">
            <div class="border-inner">
                <div class="corner-decoration top-left"></div>
                <div class="corner-decoration top-right"></div>
                <div class="corner-decoration bottom-left"></div>
                <div class="corner-decoration bottom-right"></div>
                
                <div class="ribbon"><span>OFFICIAL</span></div>

                <div class="content">
                    <div class="company-logo">PT. DUTA SOLUSI INFORMATIKA</div>
                    <div class="company-subtitle">Excellence in Technology Internship Program</div>

                    <h1 class="certificate-title">Sertifikat Kelulusan</h1>
                    <div class="certificate-subtitle">NOMOR: {{ $intern->certificate_number }}</div>

                    <div class="body-text">Dengan bangga diberikan kepada</div>

                    <div class="recipient-name">
                        {{ $intern->user->name }}
                    </div>
                    
                    <div class="recipient-school">
                        {{ $intern->school }}
                    </div>

                    <div class="description">
                        Atas keberhasilannya menyelesaikan program magang secara profesional<br>
                        pada divisi <span class="highlight">{{ $intern->department }}</span><br>
                        periode {{ $intern->start_date->format('d F Y') }} sampai dengan {{ $intern->end_date->format('d F Y') }}<br>
                        dengan predikat kinerja:
                        <br>
                        <span style="font-size: 24px; font-weight: bold; color: #b8860b; display: block; margin-top: 10px;">
                            {{ $intern->getOverallScore() >= 90 ? 'SANGAT MEMUASKAN' : ($intern->getOverallScore() >= 80 ? 'MEMUASKAN' : 'BAIK') }}
                        </span>
                    </div>

                    <!-- Seal Section -->
                    <div style="text-align: center; margin: 20px 0 30px 0;">
                        <div class="seal" style="display: inline-block;">
                            <div class="seal-inner">DSI</div>
                            VALID
                        </div>
                    </div>

                    <div class="footer">
                        <div class="signature-block">
                            <div class="signature-line"></div>
                            <div class="signer-name">{{ $intern->supervisor ? $intern->supervisor->name : 'Manager' }}</div>
                            <div class="signer-title">Pembimbing Lapangan</div>
                        </div>
                        
                        <div class="signature-block">
                            <div class="auto-date">
                                Semarang, {{ $intern->certificate_issued_at ? $intern->certificate_issued_at->format('d F Y') : date('d F Y') }}
                            </div>
                        </div>

                        <div class="signature-block">
                            <div class="signature-line"></div>
                            <div class="signer-name">Pimpinan Perusahaan</div>
                            <div class="signer-title">Direktur Utama</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
