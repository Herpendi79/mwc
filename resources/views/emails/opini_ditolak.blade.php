<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Informasi Pengajuan Opini</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f6f9fc; padding: 20px; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; padding: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <h2 style="color: #ef4444; margin-top: 0;">Pengajuan Opini Belum Dapat Diproses</h2>
        <p>Halo, <strong>{{ $opini->penulis }}</strong>,</p>
        <p>Terima kasih telah mengirimkan naskah opini berjudul <strong>"{{ $opini->judul }}"</strong>. Mohon maaf, setelah melalui proses peninjauan, naskah Anda belum dapat kami Publikasikan.</p>

        <div style="background: #fef2f2; border-left: 4px solid #ef4444; padding: 15px; border-radius: 0 8px 8px 0; margin: 20px 0;">
            <p style="margin: 0 0 5px 0; font-size: 14px; font-weight: bold; color: #991b1b;">Alasan Penolakan:</p>
            <p style="margin: 0; font-size: 14px; color: #7f1d1d; font-style: italic;">"{{ $alasan }}"</p>
        </div>

        <p>Anda dapat melakukan perbaikan naskah sesuai catatan di atas dan mengirimkannya kembali di lain kesempatan.</p>
        <p style="margin-top: 30px;">Terima kasih atas pengertian Anda.<br><strong>Tim Redaksi</strong></p>
    </div>
</body>
</html>
