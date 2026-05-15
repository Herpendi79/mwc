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
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            margin: 0;
            padding: 0;
        }

        /* Kop Surat nempel tepi atas dan memenuhi lebar kertas */
        .header-kop {
            width: 100%;
            margin: 10;
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

        /* Meta Data: Tanggal di kanan, Our Ref di kiri */
        .meta-container {
            margin-top: 10px;
            position: relative;
            width: 100%;
            height: 30px;
            /* Memberi ruang agar tidak tumpang tindih dengan isi */
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
            margin-top: 20px;
        }

        .title-box {
            text-align: center;
            font-weight: bold;
            font-style: italic;
            margin: 25px 0;
            padding: 0 40px;
        }

        /* Signature diletakkan di sebelah kanan */
        .signature-container {
            margin-top: 40px;
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
        <div class="meta-container">
            <div class="meta-right">
                <p>{{ $tanggal }}</p>
            </div>
        </div>
        <div class="meta-container">
            <div class="meta-left">
                <p>Our Ref : {{ $no_surat }}<br>
                    Subject : Letter of Abstract Acceptance</p>
            </div>
        </div>

        <div class="content">
            <p>Dear <strong>{{ $nama }}</strong>,</p>

            <p>Warm greetings from Jakarta,</p>

            <p>We are very pleased to inform you that your abstract titled:</p>

            <div class="title-box">
                "{{ $judul }}"
            </div>

            <p>has been accepted to be presented at the <strong>1st International Conference on Policy, Innovation, and
                    Practice in Higher Education (ICPIP-HE)</strong>, which will be held at Science Techno Park
                Building, Universitas Indonesia, West Java, Indonesia on June 26, 2026.</p>

            <p>Please submit your full paper before <strong>July 3, 2026</strong>, through the conference website (<a
                    href="https://www.conference.adaksi.org">https://www.conference.adaksi.org</a>), where detailed
                information regarding registration fees is also available.</p>

            <p>Please do not hesitate to contact us if you have any inquiries, and we look forward to your participation
                in the 1st International Conference on Policy, Innovation, and Practice in Higher Education (ICPIP-HE).
            </p>
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
