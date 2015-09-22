<?php
    namespace Sonar\System;

    use \Phalcon\Script\Color;

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
        const MESSAGE   = "[%s] Client IP (%s) sending message \"%s\"";

        /**
         * @const CLOSE exit text wrapper
         */
        const CLOSE     = "[%s] Client IP (%s) has disconnected";

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

            return Color::colorize(sprintf(self::START, self::date()), Color::FG_BLACK, Color::AT_BOLD).PHP_EOL;
        }

        /**
         * Greeting message
         *
         * @param string $ip
         * @return string
         */
        public static function open($ip) {

            return Color::colorize(sprintf(self::OPEN, self::date(), $ip), Color::FG_GREEN, Color::AT_BOLD).PHP_EOL;
        }

        /**
         * Sending message
         *
         * @param string $ip
         * @param string $message
         * @return string
         */
        public static function message($ip, $message) {

            return Color::colorize(sprintf(self::MESSAGE, self::date(), $ip, $message), Color::FG_BROWN, Color::AT_NORMAL).PHP_EOL;
        }

        /**
         * Closing message
         *
         * @param string $ip
         * @return string
         */
        public static function close($ip) {

            return Color::colorize(sprintf(self::CLOSE, self::date(), $ip), Color::FG_DARK_GRAY, Color::AT_BOLD).PHP_EOL;
        }

        /**
         * Error message
         *
         * @param string $message
         * @return string
         */
        public static function error($message) {

            return Color::colorize(sprintf(self::ERROR, self::date(), $message), Color::FG_RED, Color::AT_BOLD).PHP_EOL;
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