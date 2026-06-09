<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Report</title>
    <style>
        body { font-family: sans-serif; font-size: 9px; line-height: 1.2; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="text-center">
        <h2>List of Registered Presenters</h2>
        <h3>{{ $conference->nama_conf }}</h3>
        <p>Date: {{ $date }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>WhatsApp</th>
                <th>Email</th>
                <th>Country</th>
                <th>Category</th>
                <th>Publication</th>
                <th>Scope</th>
                <th>Abstract</th>
                <th>Article</th>
                <th>Source</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $p->nama_user }}</td>
                    <td>{{ $p->whatsapp_final }}</td>
                    <td>{{ $p->email_user }}</td>
                    <td>{{ $p->negara_final }}</td>
                    <td>{{ $p->kategori->nama_ktg ?? '-' }}</td>
                    <td>{{ $p->nama_publikasi ?? '-' }}</td>
                    <td>{{ $p->scope->nama_sc ?? '-' }}</td>
                    <td>{{ $p->status_abstract ?? 'Pending' }}</td>
                    <td>{{ $p->status_artikel ?? 'Pending' }}</td>
                    <td>{{ $p->sumber }}</td>
                    <td>{{ date('d/m/Y', strtotime($p->created_at)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>