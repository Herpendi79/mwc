<?php

return [
    // Misal struktur: /home/user/laravel_projek dan /home/user/public_html
    //path awal
    //'submissions' => base_path('assets/file/submissions/'),
    'submissions' => base_path('../public_html/uploads/file/submissions/'),
    'articles'    => base_path('../public_html/uploads/file/articles/'),
    'sertifikat'    => base_path('../public_html/uploads/file/sertifikat/'),

    // Digunakan di BLADE untuk menampilkan/link file (URL)
    //url awal
    // 'submissions_url'  => asset('assets/file/submissions/'),
    'submissions_url'  => 'https://adaksi.org/uploads/file/submissions/',
];
