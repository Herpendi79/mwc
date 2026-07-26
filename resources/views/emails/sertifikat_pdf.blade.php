<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sertifikat Infaq Mangrove</title>
    @php
        $sertifikatFiles = glob(public_path('assets/images/sertifikat/Sertifikat.*'));
        $sertifikatPath = 'assets/images/sertifikat/SertifikatBU.png';

        if (!empty($sertifikatFiles)) {
            $sertifikatPath = 'assets/images/sertifikat/' . basename($sertifikatFiles[0]);
        }
    @endphp
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            -webkit-print-color-adjust: exact;
        }
        .sertifikat-card {
            width: 842pt;
            height: 595pt;
            background-image: url("{{ public_path($sertifikatPath) }}");
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .content2 {
            position: absolute;
            top: 175pt;
            left: 120pt;
            width: 100%;
            text-align: left;
            font-size: 12pt;
            font-family: monospace;
        }
        .content {
            position: absolute;
            top: 280pt;
            width: 100%;
            text-align: center;
        }
        .nama {
            font-size: 32pt;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="sertifikat-card">
        <div class="content2">No. {{ $mangrove->no_sertifikat }}</div>
        <div class="content">
            <div class="nama">{{ $mangrove->donatur }}</div>
        </div>
    </div>
</body>
</html>
