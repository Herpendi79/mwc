<?php
$target = $_SERVER['DOCUMENT_ROOT'] . "/public/";
$link = $_SERVER['DOCUMENT_ROOT'] . "/storage/app/public";
if (symlink($target, $link)) {
    echo "OK.";
} else {
    echo "Gagal.";
}

//Pada bagian “$target = $_SERVER[‘DOCUMENT_ROOT’].”/../laravel/storage“;” Silahkan sesuaikan path target storage folder yang digunakan.
//Lalu, pada bagian “$link = $_SERVER[‘DOCUMENT_ROOT’].”/storage“;” . Silahkan sesuaikan ke path dimana folder storage akan di link kan.
