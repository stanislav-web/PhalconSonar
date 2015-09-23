# Sonar

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/stanislav-web/PhalconSonar/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/stanislav-web/PhalconSonar/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/stanislav-web/PhalconSonar/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/stanislav-web/PhalconSonar/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/stanislav-web/PhalconSonar/badges/build.png?b=master)](https://scrutinizer-ci.com/g/stanislav-web/PhalconSonar/build-status/master)

[![Latest Stable Version](https://poser.pugx.org/stanislav-web/sonar/v/stable)](https://packagist.org/packages/stanislav-web/sonar) [![Total Downloads](https://poser.pugx.org/stanislav-web/sonar/downloads)](https://packagist.org/packages/stanislav-web/sonar) [![Latest Unstable Version](https://poser.pugx.org/stanislav-web/sonar/v/unstable)](https://packagist.org/packages/stanislav-web/sonar) [![License](https://poser.pugx.org/stanislav-web/sonar/license)](https://packagist.org/packages/stanislav-web/sonar)

Sonar is the site visitors monitor. Build in Phalcon & MongoDb.
Conducts monitoring of visitors, using the WebSockets connection. Great for sites built on REST technology.
You can easily integrate this package to track detailed information about your visitors.
Check the time on each page of the site, determine device, geo location.

## ChangeLog

#### [v1.2-alpha] 2015-09-22
    - configurable error log
    - add cache session (memcache)
    - silent error logger (warnings & noticies)

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
    "stanislav-web/sonar": "dev-master",
}
```
Then run to update dependency and autoloader
```python
php composer.phar update
php composer.phar install
```
or just
```
php composer.phar require stanislav-web/sonar dev-master
```
_(Do not forget to include the composer autoloader)_

## Configuration
This package have a variety of settings, both mandatory and optional.

1. You can select them in the global app configuration file of your Phalcon project
if you will be making their to global application config. See example:

```php

    // CLI task's configuration (required)

    'cli' => [

        // Sonar task configuration
        'sonar' =>  [
            'debug'     =>   true,  // verbose mode
            'errors'    =>   true,  // add errors to logfile
            'cache'     =>   true,  // enable cache
            'errorLog'  =>   APP_PATH.'/../logs/sonar-error.log',

            // queue client configurations
            'beanstalk'        =>  [
                'host'  =>  '127.0.0.1',
                'port'  =>  11300,
            ],

            // webscoket server configuration
            'socket'        =>  [
                'host'  =>  '127.0.0.1',
                'port'  =>  9003,
            ],

            // memcache server configuration
            'memcache'     =>  [
                'lifetime'      => 300,
                'prefix'        => 'sonar_',
                'host'          => '127.0.0.1',
                'port'          => 11211,
                'persistent'    => false,
            ],

            // db storage configuration (Mongo)
            'storage'       =>  [
                'host'      =>  '127.0.0.1',
                'port'      =>  27017,
                'user'      =>  'root',
                'password'  =>  'root',
                'dbname'    =>  'sonar',
            ]
        ]
    ];
```

2. Register task in your Phalcon CLI autoloader:

```php

    $loader = new \Phalcon\Loader();
    $loader->registerDirs([
        ...
        DOCUMENT_ROOT.'vendor/stanislav-web/sonar/src/Sonar/System/Tasks'
        ...
    ]);
```

3. Running socket server using CLI from your project. And tracking user thought web interface _(not yet implemented)_:
```
php public/cli.php sonar
```
_(examples of client connect you can see [here](https://github.com/stanislav-web/PhalconSonar/tree/master/examples))_

## Unit Test
Also available in /phpunit directory. Run command to start
```php
phpunit --configuration phpunit.xml.dist --coverage-text

or from your project root: 

phpunit --configuration ./vendor/stanislav-web/sonar/phpunit.xml.dist --coverage-text
```

## In Future
- More examples
- Output working

## Documents
+ [Phalcon Queueing](http://docs.phalconphp.com/ru/latest/index.html)
+ [PHP MongoDb client](http://php.net/manual/ru/mongo.core.php)
+ [Asynchronous WebSocket server](http://socketo.me/)
+ [Mobile Detect](http://mobiledetect.net/)

##[Issues](https://github.com/stanislav-web/PhalconSonar "Issues")