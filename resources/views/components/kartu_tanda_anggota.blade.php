<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Cetak KTA</title>
    @php
        // Mencari file dengan awalan "Template." di dalam folder public/assets/images/template/
        $templateFiles = glob(public_path('assets/images/template/Template.*'));

        // Default path jika file tidak ditemukan
        $templatePath = 'assets/images/template/TemplateBU.png';

        if (!empty($templateFiles)) {
            $templatePath = 'assets/images/template/' . basename($templateFiles[0]);
        }
    @endphp
    <style>
        /* Agar saat cetak tidak ada margin tambahan */
        @media print {
            @page {
                size: A4;
                /* Menggunakan ukuran kertas standar cetak A4 */
                margin: 0;
            }

            body {
                display: flex;
                justify-content: center;
                /* Tengah horizontal */
                align-items: center;
                /* Tengah vertikal */
                height: 100vh;
                /* Tinggi penuh layar */
                margin: 0;
                -webkit-print-color-adjust: exact;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            /* Memastikan body memenuhi layar */
            background-color: #f0f0f0;
            /* Memberi warna latar agar kartu terlihat jelas di layar */
        }

        .card {
            width: 243.78pt;
            height: 153.07pt;
            background-image: url("{{ asset($templatePath) }}");
            background-size: cover;
            background-position: center;
            position: relative;
            box-sizing: border-box;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            /* Memberi efek bayangan di layar */
        }

        .foto-container {
            position: absolute;
            top: 45pt;
            right: 20pt;
            width: 80pt;
            height: 80pt;
            border-radius: 50%;
            border: 2pt solid #eab308;
            overflow: hidden;
            background: #fff;
        }

        .foto {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .info-container {
            position: absolute;
            top: 55pt;
            left: 10pt;
            width: 140pt;
            color: white;
        }

        .mwc {
            font-size: 8pt;
            font-weight: bold;
            text-transform: uppercase;
            color: #fde047;
        }

        .tg {
            font-size: 16pt;
            font-weight: 900;
            margin: 2pt 0;
        }

        .nama {
            font-size: 10pt;
            font-weight: bold;
        }

        .masa {
            font-size: 5pt;
            color: #ffffff;
            opacity: 0.8;
            margin-top: 4pt;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="foto-container">
            <img src="{{ $anggota->foto && Storage::disk('public')->exists('foto/' . $anggota->foto) ? asset('storage/foto/' . $anggota->foto) : asset('assets/images/default-avatar.png') }}"
                class="foto">
        </div>

        <div class="info-container">
            <div class="mwc">MWC TUGU</div>
            <div class="tg">TG{{ str_pad($anggota->id_anggota, 4, '0', STR_PAD_LEFT) }}</div>
            <div class="nama">{{ auth()->user()->name }}</div>
            <div class="masa">
                Masa Aktif: {{ $anggota->created_at->format('d M Y') }} -
                {{ $anggota->created_at->addYear()->format('d M Y') }}
            </div>
        </div>
    </div>

    <script>
        // Trigger dialog print otomatis saat halaman terbuka
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>
