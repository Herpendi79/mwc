<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        /* Menghilangkan margin default agar kop bisa nempel ke tepi atas */
        @page {
            margin: 0;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.3;
            color: #000;
            margin: 0;
            padding: 0;
        }

        /* Kop Surat nempel tepi atas dan memenuhi lebar kertas */
        .header-kop {
            width: 100%;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .kop-img {
            width: 100%;
            display: block;
        }

        /* Pembungkus konten utama dengan padding standar surat (1 inci) */
        .content-wrapper {
            padding: 0 1in 1in 1in;
        }

        .title-doc {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin: 15px 0;
            font-size: 14pt;
        }

        /* Meta Data: Tanggal di kanan, Our Ref di kiri */
        .meta-container {
            margin-top: 10px;
            position: relative;
            width: 100%;
            height: 35px;
        }

        .meta-left {
            position: absolute;
            left: 0;
            top: 0;
            text-align: left;
        }

        .meta-right {
            position: absolute;
            right: 0;
            top: 0;
            text-align: right;
        }

        .content {
            text-align: justify;
            margin-top: 15px;
        }

        .title-box {
            text-align: center;
            font-weight: bold;
            font-style: italic;
            margin: 15px 0;
            border: 1px solid #eee;
            padding: 10px;
        }

        /* Signature diletakkan di sebelah kanan */
        .signature-container {
            margin-top: 30px;
            float: right;
            width: 250px;
            text-align: center;
        }

        .signature-wrapper {
            position: relative;
            height: 100px;
            margin: 5px 0;
        }

        .ttd-img {
            width: 180px;
            display: block;
            margin: 0 auto;
        }

        .footer-name {
            margin-top: 5px;
            font-weight: bold;
            text-decoration: underline;
        }

        /* Clearfix untuk mengatasi float */
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
        <div class="title-doc">LETTER OF ACCEPTANCE</div>

        <div class="meta-container">
            <div class="meta-right">
                <p>{{ $tanggal }}</p>
            </div>
        </div>
        <div class="meta-container">
            <div class="meta-left">
                <p>Our Ref : {{ $no_surat }}<br>
                    Subject : Letter of Manuscript Acceptance</p>
            </div>
        </div>

        <div class="content">
            <p>Dear Author ({{ $nama }}),</p>

            <p>It is our pleasure to inform you that your manuscript entitled:</p>

            <div class="title-box">
                "{{ $judul }}"
            </div>

            <p>is accepted subject to revision for publication in <strong>{{ $nama_jurnal }}</strong>. Please see the reviews for further details.</p>

            <p>Indicate the revised portions of your manuscript based on reviewer comments. Please send the revised manuscript to <a
                    href="https://www.conference.adaksi.org/submission-information">https://www.conference.adaksi.org/submission-information</a> using your validated account before <strong>July 15<sup>th</sup> 2026</strong>. We presume that you withdraw the article if your submission is overdue.</p>

            <p>The revised manuscript should also be accompanied by a summary of your responses to the reviewers' comments. Please note that in some cases revised manuscripts will be re-reviewed and the final decision may be changed based on your revised paper.</p>

            <p>We look forward to receiving your revised paper.</p>
            
            <p style="margin-bottom: 0; margin-top: 15px;">Contact Person:</p>
            <p style="margin-top: 0; font-size: 10pt;">+62 857-3561-7107 (Rio) / +62 823-6575-6299 (Jon) / +62 813-2248-3370 (Antha)</p>
        </div>

        <div class="clearfix">
            <div class="signature-container">
                <p>Yours Sincerely,</p>

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