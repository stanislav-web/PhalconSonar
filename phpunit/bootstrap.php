<?php
date_default_timezone_set('UTC');
set_time_limit(0);

if (PHP_SAPI !== 'cli') {
    echo 'Warning: Script should be invoked via the CLI version of PHP, not the '.PHP_SAPI.' SAPI'.PHP_EOL;
}

// defined autoload paths
$paths = [
        getcwd().'/../../../vendor/autoload.php',
        getcwd().'/../../vendor/autoload.php',
        getcwd().'/../vendor/autoload.php',
        getcwd().'/vendor/autoload.php',
        __DIR__ . '/../../../autoload.php',
        __DIR__ . '/../autoload.php',
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

// check composer autoloader
if(!defined('AUTOLOADER')) {
    die(<<<EOT
You need to install the project dependencies using Composer:
$ wget http://getcomposer.org/composer.phar
OR
$ curl -s https://getcomposer.org/installer | php
$ php composer.phar install --dev
$ phpunit
EOT
    );
}

// require autoloader & add tests directory
$loader = include AUTOLOADER;

// add tests directory
$loader->addPsr4('Octopussy\Mockups\\', __DIR__.'/src/Mockups/');
$loader->addPsr4('Octopussy\Tests\\', __DIR__.'/src/Tests/');
