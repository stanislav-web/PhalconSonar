<?php
    date_default_timezone_set('UTC');
    set_time_limit(0);

    if (PHP_SAPI !== 'cli') {
        echo 'Warning: Script should be invoked via the CLI version of PHP, not the '.PHP_SAPI.' SAPI'.PHP_EOL;
    }

    $paths = [
        getcwd().'/../vendor/autoload.php',
        getcwd().'/vendor/autoload.php',
        __DIR__ . '/../../autoload.php',
        __DIR__ . '/../vendor/autoload.php',
        __DIR__ . '/vendor/autoload.php',
        __DIR__ . 'vendor/autoload.php'
    ];
    foreach ($paths as $file) {
        if (file_exists($file)) {
            define('AUTOLOADER', $file);
            break;
        }
    }
    unset($file);

    if(file_exists(AUTOLOADER) === true) {
        include AUTOLOADER;
    }
    else {
        exit('Can not find autoloader');
    }