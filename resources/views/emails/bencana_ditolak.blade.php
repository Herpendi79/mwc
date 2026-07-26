<!DOCTYPE html>
<html>

<body style="font-family: sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 30px auto; border: 1px solid #e0e0e0; border-radius: 12px; overflow: hidden;">
        <div style="background-color: #990000; padding: 25px; text-align: center; color: #ffffff;">
            <h2>Informasi Pengajuan Laporan</h2>
        </div>
        <div style="padding: 30px;">
            <p>Halo, <strong>{{ $name }}</strong>,</p>
            <p>Mohon maaf, pengajuan laporan bencana <strong>{{ $jenis_bencana }}</strong> di lokasi <strong>{{ $lokasi }}</strong> belum dapat kami proses lebih lanjut.</p>

            <div style="background-color: #fdf2f2; padding: 15px; border-left: 4px solid #990000; margin: 20px 0;">
                <p style="color: #990000; margin: 0;"><strong>Catatan Admin:</strong><br>
                Data yang dikirimkan tidak valid atau kurang jelas. Harap mengirimkan informasi yang jelas, lengkap, dan valid.</p>
            </div>

            <p>Silakan melakukan input ulang laporan dengan data yang valid melalui platform MWC NU Tugu. Terima kasih atas pengertian Anda.</p>
        </div>
        <div style="text-align: center; font-size: 12px; color: #888; padding: 20px; background-color: #f4f4f4;">
            &copy; {{ date('Y') }} MWC NU Tugu.
        </div>
    </div>
</body>

</html>
