<?php
namespace Sonar\System;

use Sonar\Services\StorageService;

/**
 * Class Profiler.
 *
 * @package Sonar\System
 * @subpackage Sonar
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Sonar/System/Profiler.php
 */
class Profiler
{

    /**
     * Verbose title
     *
     * @const VERBOSE_TITLE
     */
    const VERBOSE_TITLE = "-----------------\nShow profile data:\n-----------------";

    /**
     * const VERBOSE_ROW Format row
     */
    const VERBOSE_ROW     = "%s: %s";

    /**
     * const VERBOSE_STACK_ROW Format stack row
     */
    const VERBOSE_STACK_ROW     = "%s %s";

    /**
     * Profiler collection
     *
     * @var array $profiler
     */
    private static $profiler = [];

    /**
     * Start profiler
     *
     * @return null
     */
    public static function start() {

        self::$profiler = [
            'start'         =>  time()
        ];
    }

    /**
     * Finish collect profiling data
     */
    public static function finish() {

        if(empty(self::$profiler) === false) {

            self::$profiler = array_merge([
                'elapsed'   =>  self::getTime(time() - self::$profiler['start']),
                'memory'    =>  self::getMemoryUsage(),
                'cpu'       =>  self::getUsageCPU(),
                'stack'     =>  self::getStackCalls()
            ], self::$profiler);

            unset(self::$profiler['start']);
        }
    }

    /**
     * Get profiling metrics
     *
     * @return string
     */
    public static function getProfilingData() {

        echo self::pretty(self::$profiler);
    }

    /**
     * Get elapsled time
     *
     * @param int $seconds
     * @return string
     */
    public function getTime($seconds) {

        $dtF = new \DateTime("@0");
        $dtT = new \DateTime("@$seconds");
        return $dtF->diff($dtT)->format('%h hours, %i minutes %s sec.');

    }

    /**
     * Enable storage profiler
     *
     * @return array
     */
    public static function enableStorageProfiler(StorageService $storageService) {
        return $storageService->enableProfiler();
    }

    /**
     * Get stack calls
     *
     * @return array
     */
    private static function getStackCalls() {

        $i = 1;
        $result = [];
        foreach(xdebug_get_function_stack() as $node) {
            if(isset($node['line']) === true) {
                $result[] = "$i. ".basename($node['file']) .":" .$node['function'] ."(" .$node['line'].")";
            }
            $i++;
        }
        return $result;
    }

    /**
     * Get CPU usage
     *
     * @return string
     */
    private static function getUsageCPU() {
        return round(sys_getloadavg()[0], 1, PHP_ROUND_HALF_ODD).'%';
    }

    /**
     * Get stack of memory usage
     *
     * @return string
     */
    private static function getMemoryUsage() {

        $memory = memory_get_peak_usage();
        $floor = floor((strlen($memory) - 1) / 3);
        return sprintf("%.2f", $memory/pow(1024, $floor)).' '.@'BKMGTPEZY'[$floor].'B';
    }

    /**
     * Pretty print profile data
     *
     * @param array $data
     *
     * @return string
     */
    private static function pretty(array $data) {

        $color = new Color();
        $output = $color->getColoredString(self::VERBOSE_TITLE, 'blue', 'light-gray').PHP_EOL;

        foreach($data as $key => $value) {
            if(is_array($value) === false) {
                $output .= $color->getColoredString(sprintf(self::VERBOSE_ROW, $key, $value), 'dark_gray').PHP_EOL;
            }
            else {
                $output .= $color->getColoredString(sprintf(self::VERBOSE_ROW, $key, ''), 'dark_gray').PHP_EOL;
                foreach($value as $line => $string) {
                    $output .= $color->getColoredString(sprintf("\t".self::VERBOSE_ROW, '', $string), 'dark_gray').PHP_EOL;
                }
            }
        }
        $output .= $color->getColoredString('-----------------', 'blue', 'light-gray').PHP_EOL;

        return $output;
    }
}