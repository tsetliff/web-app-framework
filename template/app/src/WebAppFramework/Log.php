<?php
/**
 * User: Tom2017 Date: 8/5/2018 Time: 3:38 AM
 */

namespace WebAppFramework;

/**
 * Class Log
 *
 * Super simple logging system that you can override in your DI containers
 *
 * @package WebAppFramework
 */
class Log
{
    public function debug($msg)
    {
        $this->log($msg, 'DEBUG');
    }

    public function notice($msg)
    {
        $this->log($msg, 'NOTICE');
    }

    public function error($msg)
    {
        $this->log($msg, 'ERROR');
    }

    private function log($msg, $level)
    {
        if (is_array($msg)) {
            error_log("$level:" . json_encode($msg));
        }
    }
}