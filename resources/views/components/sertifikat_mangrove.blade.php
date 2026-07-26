<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Cetak Sertifikat</title>
    @php
        // Mencari file template sertifikat dengan ekstensi dinamis
        $sertifikatFiles = glob(public_path('assets/images/sertifikat/Sertifikat.*'));
        $sertifikatPath = 'assets/images/sertifikat/SertifikatBU.png'; // Default fallback

        if (!empty($sertifikatFiles)) {
            $sertifikatPath = 'assets/images/sertifikat/' . basename($sertifikatFiles[0]);
        }
    @endphp
    <style>
        @media print {
            @page {
                size: A4 landscape;
                margin: 0;
            }

            body {
                -webkit-print-color-adjust: exact;
            }
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }

        .sertifikat-card {
            width: 842pt;
            /* Ukuran A4 Landscape */
            height: 595pt;
            background-image: url("{{ asset($sertifikatPath) }}");
            background-size: cover;
            background-position: center;
            position: relative;
        }

        /* Sesuaikan posisi ini dengan posisi teks di gambar Anda */
        .content2 {
            position: absolute;
            top: 175pt;
            left: 120pt;
            width: 100%;
            text-align: left;
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

        .info {
            font-size: 14pt;
            color: #555;
            margin-top: 10pt;
        }

        .no-sertifikat {
            font-size: 12pt;
            font-family: monospace;
            margin-top: 20pt;
        }
    </style>
</head>

<body>
    <div class="sertifikat-card">
        <div class="content2">No.
            {{ $mangrove->no_sertifikat }}
        </div>
        <div class="content">
            <div class="nama">{{ $mangrove->donatur }}</div>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>
