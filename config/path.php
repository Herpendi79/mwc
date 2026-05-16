<?php

return [
    // Misal struktur: /home/user/laravel_projek dan /home/user/public_html
    //path awal
    //'submissions' => base_path('assets/file/submissions/'),
    'submissions' => base_path('../public_html/uploads/file/submissions/'),
    'articles'    => base_path('../public_html/uploads/file/articles/'),
    'sertifikat'    => base_path('../public_html/uploads/file/sertifikat/'),
    'qrcode'    => base_path('../public_html/uploads/file/qrcode/'),
   // 'qrcode' => base_path('public/assets/file/qrcode/'),

    // Digunakan di BLADE untuk menampilkan/link file (URL)
    //url awal
    // 'submissions_url'  => asset('assets/file/submissions/'),
    'submissions_url'  => 'https://adaksi.org/uploads/file/submissions/',
     //'qrcode_url_local'  => 'https://adaksi.org/uploads/file/qrcode/',
    // 'qrcode_url_local'  => env('APP_URL', 'http://localhost') . '/assets/file/qrcode/',
     'qrcode_url'  => 'https://adaksi.org/uploads/file/qrcode/',
];
