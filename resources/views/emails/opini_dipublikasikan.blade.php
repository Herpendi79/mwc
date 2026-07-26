<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Opini Dipublikasikan</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f6f9fc; padding: 20px; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; padding: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <h2 style="color: #10b981; margin-top: 0;">Opini Anda Telah Tayang!</h2>
        <p>Halo, <strong>{{ $opini->penulis }}</strong>,</p>
        <p>Kabar baik! Opini Anda yang berjudul <strong>"{{ $opini->judul }}"</strong> telah selesai dimoderasi dan resmi dipublikasikan di platform kami.</p>

        <div style="background: #f3f4f6; padding: 15px; border-radius: 8px; margin: 20px 0;">
            <p style="margin: 0; font-size: 14px;"><strong>Kategori:</strong> {{ $opini->kategori }}</p>
        </div>

        <p>Terima kasih telah berkontribusi menyumbangkan ide dan tulisan yang bermanfaat.</p>
        <p style="margin-top: 30px;">Salam hangat,<br><strong>Tim Redaksi</strong></p>
    </div>
</body>
</html>
