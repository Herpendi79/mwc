<?php
$target = $_SERVER['DOCUMENT_ROOT'] . "../mwc/storage/";
$link = $_SERVER['DOCUMENT_ROOT'] . "/storage/";
if (symlink($target, $link)) {
    echo "OK.";
} else {
    echo "Gagal.";
}
