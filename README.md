# Octopussy

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/stanislav-web/Octopussy/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/stanislav-web/Octopussy/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/stanislav-web/Octopussy/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/stanislav-web/Octopussy/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/stanislav-web/Octopussy/badges/build.png?b=master)](https://scrutinizer-ci.com/g/stanislav-web/Octopussy/build-status/master)

[![Latest Stable Version](https://poser.pugx.org/stanislav-web/octopussy/v/stable)](https://packagist.org/packages/stanislav-web/octopussy) [![Total Downloads](https://poser.pugx.org/stanislav-web/octopussy/downloads)](https://packagist.org/packages/stanislav-web/octopussy) [![Latest Unstable Version](https://poser.pugx.org/stanislav-web/octopussy/v/unstable)](https://packagist.org/packages/stanislav-web/octopussy) [![License](https://poser.pugx.org/stanislav-web/octopussy/license)](https://packagist.org/packages/stanislav-web/octopussy)

Octopussy is the site visitors monitor. Build in Phalcon & MongoDb.
Conducts monitoring of visitors, using the WebSockets connection. Great for sites built on REST technology.
You can easily integrate this package to track detailed information about your visitors.
Check the time on each page of the site, determine device, geo location.

## ChangeLog

#### [v1.1-alpha] 2015-09-21
    - implementing geo location detector
        
#### [v1.0-alpha] 2015-09-20
    - the first version of package
    - socket application named as "Sonar"
    - implemented:
        - tracking user's page position
        - tracking user's page timing activity
        - tracking user's device (phone, table, pc)
        - tracking the time of each page

## Compatible
- PSR-1, PSR-2, PSR-4 Standards

## System requirements

- PHP 5.5 or higher
- Phalcon PHP extension 1.3.4 (support 2.x)
- PHP MongoDb client extension
- Beanstalk queue server

## Installation

First update your dependencies through composer. Add to your composer.json:
```php
"require": {
    "stanislav-web/octopussy": "dev-master",
}
```
Then run to update dependency and autoloader
```python
php composer.phar update
php composer.phar install
```
or just
```
php composer.phar require stanislav-web/octopussy dev-master
```
_(Do not forget to include the composer autoloader)_

## Configuration
This package have a variety of settings, both mandatory and optional.

1. You can select them in the global app configuration file of your Phalcon project
if you will be making their to global application config. See example:

```php

    // CLI task's configuration (required)

    'cli' => [

        // "Sonar task"
        'sonar' =>  [

            // task event log
            'logfile'  =>   APP_PATH.'/../logs/octopussy-event.log',

            // queue server config
            'beanstalk'        =>  [
                'host'  =>  '127.0.0.1',
                'port'  =>  11300,
            ],

            // webscoket server config
            'socket'        =>  [
                'host'  =>  '127.0.0.1',
                'port'  =>  9001,
            ],

            // persistent storage (MongoDb only, MySQL in future...)
            'storage'       =>  [
                'host'      =>  '127.0.0.1',
                'port'      =>  27017,
                'user'      =>  'root',
                'password'  =>  'root',
                'dbname'    =>  'octopussy',
            ]
        ]
    ];
```

2. Register task in your Phalcon CLI autoloader:

```php

    $loader = new \Phalcon\Loader();
    $loader->registerDirs([
        ...
        DOCUMENT_ROOT.'vendor/stanislav-web/octopussy/src/Octopussy/System/Tasks'
        ...
    ]);
```

3. Running socket server using CLI from your project. And tracking user thought web interface:
```
php public/cli.php sonar
```
_(examples of client connect you can see [here](https://github.com/stanislav-web/Octopussy/tree/master/examples))_

## Unit Test
Also available in /phpunit directory. Run command to start
```php
phpunit --configuration phpunit.xml.dist --coverage-text
```

## In Future
- More examples

## Documents
+ [Phalcon Queueing](http://docs.phalconphp.com/ru/latest/index.html)
+ [PHP MongoDb client](http://php.net/manual/ru/mongo.core.php)
+ [Asynchronous WebSocket server](http://socketo.me/)
+ [Mobile Detect](http://mobiledetect.net/)

##[Issues](https://github.com/stanislav-web/octopussy/issues "Issues")