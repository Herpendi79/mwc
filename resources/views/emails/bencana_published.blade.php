<!DOCTYPE html>
<html>

<body style="font-family: sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 30px auto; border: 1px solid #e0e0e0; border-radius: 12px; overflow: hidden;">
        <div style="background-color: #006633; padding: 25px; text-align: center; color: #ffffff;">
            <h2>Laporan Bencana Dipublikasikan</h2>
        </div>
        <div style="padding: 30px;">
            <p>Halo, <strong>{{ $name }}</strong>,</p>
            <p>Alhamdulillah, laporan bencana <strong>{{ $jenis_bencana }}</strong> yang Anda ajukan telah diverifikasi dan resmi dipublikasikan.</p>

            <div style="background-color: #f0f7f4; padding: 15px; border-left: 4px solid #006633; margin: 20px 0;">
                <p><strong>Detail Laporan:</strong><br>
                    Lokasi: {{ $lokasi }}<br>
                    Tanggal: {{ \Carbon\Carbon::parse($tgl)->format('d/m/Y') }}</p>
            </div>

            <p>Terima kasih atas kepedulian dan partisipasi Anda dalam memberikan informasi yang akurat. Jazakumullah Khairan Katsiran.</p>
        </div>
        <div style="text-align: center; font-size: 12px; color: #888; padding: 20px; background-color: #f4f4f4;">
            &copy; {{ date('Y') }} MWC NU Tugu.
        </div>
    </div>
</body>

</html>
