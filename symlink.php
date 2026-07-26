<?php
$target = $_SERVER['DOCUMENT_ROOT'] . "/public/";
$link = $_SERVER['DOCUMENT_ROOT'] . "/storage/app/public";
if (symlink($target, $link)) {
    echo "OK.";
} else {
    echo "Gagal.";
}
