<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Infaq Mangrove Berhasil</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f6f9fc; padding: 20px; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; padding: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <h2 style="color: #065f46; margin-top: 0;">Infaq Mangrove Anda Berhasil!</h2>
        <p>Halo, <strong>{{ $mangrove->donatur }}</strong>,</p>
        <p>Terima kasih banyak atas partisipasi Anda dalam program Infaq Mangrove MWC NU Tugu Semarang. Infaq sejumlah <strong>{{ $mangrove->jumlah_pohon }} pohon</strong> telah kami catat.</p>

        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; padding: 15px; border-radius: 8px; margin: 20px 0;">
            <p style="margin: 0 0 8px 0; font-size: 14px;"><strong>No. Sertifikat:</strong> {{ $mangrove->no_sertifikat }}</p>
            <p style="margin: 0; font-size: 14px;"><strong>Tanggal:</strong> {{ $mangrove->tanggal }}</p>
        </div>

        <p>Sertifikat digital Anda telah dilampirkan bersama email ini. Anda juga dapat mengunduhnya sewaktu-waktu.</p>
        <p>Semoga amal ibadah dan kontribusi Anda dalam pelestarian alam mendatangkan keberkahan.</p>
        <p style="margin-top: 30px;">Salam hangat,<br><strong>MWC NU Tugu Semarang</strong></p>
    </div>
</body>
</html>
