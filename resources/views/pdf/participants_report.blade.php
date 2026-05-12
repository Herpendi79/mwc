<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Participants Report</title>
    <style>
        body { font-family: sans-serif; font-size: 9px; line-height: 1.4; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; text-transform: uppercase; }
        .text-center { text-align: center; }
        .header-info { margin-bottom: 20px; }
        .footer { margin-top: 20px; font-style: italic; font-size: 8px; }
    </style>
</head>
<body>
    <div class="text-center header-info">
        <h2 style="margin: 0;">LIST OF REGISTERED PARTICIPANTS</h2>
        <h3 style="margin: 5px 0;">{{ $conference->nama_conf }}</h3>
        <p style="margin: 0;">Status: Payment Success (Confirmed)</p>
        <p style="margin: 0; font-size: 8px;">Export Date: {{ $date }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th>Participant Name</th>
                <th>WhatsApp</th>
                <th>Email</th>
                <th>Country</th>
                <th>Category</th>
                <th>Source</th>
                <th>Registration Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $p)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td><strong>{{ $p->nama_user }}</strong></td>
                    <td>{{ $p->whatsapp_final }}</td>
                    <td>{{ $p->email_user }}</td>
                    <td>{{ $p->negara_final }}</td>
                    <td>{{ $p->kategori->nama_ktg ?? '-' }}</td>
                    <td class="text-center">{{ $p->sumber }}</td>
                    <td>{{ date('d M Y, H:i', strtotime($p->created_at)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>* This report is generated automatically for {{ $conference->nama_conf }}.</p>
    </div>
</body>
</html>