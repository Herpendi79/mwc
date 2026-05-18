<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .header-kop {
            width: 100%;
            margin: 0 0 15px 0;
            padding: 0;
        }

        .kop-img {
            width: 100%;
            display: block;
        }

        .content-wrapper {
            padding: 0 1in 1in 1in;
        }

        .invoice-title {
            text-align: center;
            font-size: 16pt;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 25px;
            text-transform: uppercase;
        }

        .info-table {
            width: 100%;
            margin-bottom: 25px;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 3px 0;
            vertical-align: top;
        }

        .info-table td.label {
            font-weight: bold;
            width: 25%;
        }

        .info-table td.colon {
            width: 3%;
            text-align: center;
        }

        .fee-break-title {
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 12pt;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid #000;
            padding: 8px 10px;
            text-align: left;
        }

        .invoice-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .text-center {
            text-align: center !important;
        }

        .text-right {
            text-align: right !important;
        }

        .signature-container {
            margin-top: 20px;
            float: right;
            width: 250px;
            text-align: center;
        }

        .signature-wrapper {
            position: relative;
            height: 90px;
            margin: 5px 0;
        }

        .ttd-img {
            width: 160px;
            display: block;
            margin: 0 auto;
        }

        .footer-name {
            margin-top: 5px;
            font-weight: bold;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>

<body>
    <div class="header-kop">
        <img src="{{ public_path('assets/images/kop_surat.png') }}" class="kop-img">
    </div>

    <div class="content-wrapper">
        <div class="invoice-title">INVOICE</div>

        <table class="info-table">
            <tr>
                <td class="label">Invoice No.</td>
                <td class="colon">:</td>
                <td><strong>{{ $no_invoice }}</strong></td>
            </tr>
            <tr>
                <td class="label">Name of Person Attending</td>
                <td class="colon">:</td>
                <td>{{ $nama }}</td>
            </tr>
            <tr>
                <td class="label">Email</td>
                <td class="colon">:</td>
                <td>{{ $email }}</td>
            </tr>
            <tr>
                <td class="label">Country</td>
                <td class="colon">:</td>
                <td>{{ $negara }}</td>
            </tr>
            <tr>
                <td class="label">Participant Category</td>
                <td class="colon">:</td>
                <td>{{ $kategori }}</td>
            </tr>
            <tr>
                <td class="label">Abstract Title</td>
                <td class="colon">:</td>
                <td>{{ $judul ?: '-' }}</td>
            </tr>
        </table>

        <div class="fee-break-title">Fee Break-Up:</div>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th style="width: 40%;">Category</th>
                    <th style="width: 25%;" class="text-right">Registration Fee</th>
                    <th style="width: 10%;" class="text-center">Qty.</th>
                    <th style="width: 25%;" class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $kategori }}</td>
                    <td class="text-right">IDR {{ number_format($nominal, 0, ',', '.') }}</td>
                    <td class="text-center">1</td>
                    <td class="text-right"><strong>IDR {{ number_format($nominal, 0, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>

        <div class="clearfix">
            <div class="signature-container">
                <p>Regards,</p>
                <div class="signature-wrapper">
                    <img src="{{ public_path('assets/images/ttd_stempel_herpendi.jpeg') }}" class="ttd-img">
                </div>
                <div class="footer-name">
                    Herpendi, M.Kom.
                </div>
                <div>Head of Committee</div>
            </div>
        </div>
    </div>
</body>

</html>
