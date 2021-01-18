<?php

return array(
    'pdf' => array(
        'enabled' => true,
        'b inary'  => '/usr/local/bin/wkhtmltopdf-amd64',
        //'binary'  => '"C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf"',
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary'  => '/usr/local/bin/wkhtmltoimage-amd64',
        //'binary'  => '"C:\Program Files\wkhtmltopdf\bin\wkhtmltoimage"',
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),

);
