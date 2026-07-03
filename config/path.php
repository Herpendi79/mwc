<?php

return [
    // Misal struktur: /home/user/laravel_projek dan /home/user/public_html
    //path awal
    //'submissions' => base_path('assets/file/submissions/'),
    'submissions' => base_path('../public_html/uploads/file/submissions/'),
    'articles'    => base_path('../public_html/uploads/file/articles/'),
    'sertifikat'    => base_path('../public_html/uploads/file/sertifikat/'), //hosting
   // 'sertifikat'    => base_path('public/assets/file/sertifikat/'), // local
    'qrcode'    => base_path('../public_html/uploads/file/qrcode/'), //hosting
    //'qrcode' => base_path('public/assets/file/qrcode/'), // local

    // Digunakan di BLADE untuk menampilkan/link file (URL)
    //url awal
    // 'submissions_url'  => asset('assets/file/submissions/'), //local
    'submissions_url'  => 'https://adaksi.org/uploads/file/submissions/',
     // 'qrcode_url'  => env('APP_URL', 'http://localhost') . '/assets/file/qrcode/', //local
     'qrcode_url' => 'https://adaksi.org/uploads/file/qrcode/', // URL untuk hosting
     
];
