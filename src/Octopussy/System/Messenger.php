<?php
namespace Octopussy\System;

use \Phalcon\Script\Color;

/**
 * Class Messenger. Message dictionary helper
 *
 * @package Octopussy\System
 * @subpackage Octopussy
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/System/Messenger.php
 */
class Messenger {

    /**
     * const START Start app message
     */
    const START     = "Server is running ...\n-----------------";

    /**
     * @const OPEN greeting text
     */
    const OPEN      = "Client IP : (%s) connected";

    /**
     * @const MESSAGE sending text wrapper
     */
    const MESSAGE   = "Client IP %s sending message \"%s\"";

    /**
     * @const CLOSE exit text wrapper
     */
    const CLOSE     = "Client IP %s has disconnected";

    /**
     * @const ERROR error text
     */
    const ERROR     = "An error has occurred: %s";

    /**
     * Start message
     *
     * @return string
     */
    public static function start() {
        return Color::colorize(self::START, Color::FG_BLACK, Color::AT_BOLD).PHP_EOL;
    }

    /**
     * Greeting message
     *
     * @param string $ip
     * @return string
     */
    public static function open($ip) {
        return Color::colorize(sprintf(self::OPEN, $ip), Color::FG_GREEN, Color::AT_BOLD).PHP_EOL;
    }

    /**
     * Sending message
     *
     * @param string $ip
     * @param string $message
     * @return string
     */
    public static function message($ip, $message) {
        return Color::colorize(sprintf(self::MESSAGE, $ip, $message), Color::FG_BROWN, Color::AT_NORMAL).PHP_EOL;
    }

    /**
     * Closing
     *
     * @param string $ip
     * @return string
     */
    public static function close($ip) {
        return Color::colorize(sprintf(self::CLOSE, $ip), Color::FG_DARK_GRAY, Color::AT_BOLD).PHP_EOL;
    }

    /**
     * Error
     *
     * @param string $message
     * @return string
     */
    public static function error($message) {
        return Color::colorize(sprintf(self::ERROR, $message), Color::FG_RED, Color::AT_BOLD).PHP_EOL;
    }
}