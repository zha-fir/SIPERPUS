<?php
$source = 'C:/Users/zhafir/.gemini/antigravity/brain/1a485231-fb16-4e19-8259-2852c2152b67/media__1776915950905.png';
$destination = 'd:/SIPERPUS/public/logo.png';
if (file_exists($source)) {
    copy($source, $destination);
    echo "Copied successfully!";
} else {
    echo "Source not found!";
}
