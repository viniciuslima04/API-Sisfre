<?php

$binarypdf = '"C:\wkhtmltopdf\bin\wkhtmltopdf.exe"';
$binaryimg = '"C:\wkhtmltopdf\bin\wkhtmltoimage.exe"';

$app = config('app.env', 'production');

if($app == 'production'){
    $binarypdf = '/usr/local/bin/wkhtmltopdf-amd64';
    $binaryimg = '/usr/local/bin/wkhtmltoimage-amd64';
}

return array(

    'pdf' => array(
        'enabled' => true,
        'binary'  => $binarypdf,
    ),
    'image' => array(
        'enabled' => true,
        'binary'  => $binaryimg,
    ),

);
