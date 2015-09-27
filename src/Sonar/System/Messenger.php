<?php
namespace Sonar\System;

/**
 * Class Messenger. Message dictionary helper
 *
 * @package Sonar\System
 * @subpackage Sonar
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Sonar/System/Messenger.php
 */
class Messenger {

    /**
     * const START Start app message
     */
    const START     = "[%s] Server is running ...\n-----------------";

    /**
     * @const OPEN greeting text
     */
    const OPEN      = "[%s] Client IP : (%s) connected";

    /**
     * @const MESSAGE sending text wrapper
     */
    const MESSAGE   = "[%s] Sending message: \"%s\"";

    /**
     * @const CLOSE exit text wrapper
     */
     const CLOSE     = "[%s] Client IP : (%s) has left.";

    /**
     * @const ERROR error text
     */
    const ERROR     = "[%s] An error has occurred: %s";

    /**
     * Start message
     *
     * @return string
     */
    public static function start() {

        return (new Color())->getColoredString(sprintf(self::START, self::date()), 'blue', 'light-gray').PHP_EOL;
    }

    /**
     * Greeting message
     *
     * @param string $ip
     * @return string
     */
    public static function open($ip) {

        return (new Color())->getColoredString(sprintf(self::OPEN, self::date(), $ip), 'black', 'green').PHP_EOL;
    }

    /**
     * Sending message
     *
     * @param string $message
     * @return string
     */
    public static function message($message) {

        return (new Color())->getColoredString(sprintf(self::MESSAGE, self::date(), $message), 'black', 'light_gray').PHP_EOL;

    }

    /**
     * Closing message
     *
     * @param string $ip
     * @return string
     */
    public static function close($ip) {

        return (new Color())->getColoredString(sprintf(self::CLOSE, self::date(), $ip), 'white', 'black').PHP_EOL;

    }

    /**
     * Error message
     *
     * @param string $message
     * @return string
     */
    public static function error($message) {

        return (new Color())->getColoredString(sprintf(self::ERROR, self::date(), $message), 'red', 'white').PHP_EOL;
    }

    /**
     * Get current datetime
     *
     * @return string
     */
    private static function date() {
        return (new \DateTime())->format(\DateTime::RFC2822);
    }
}