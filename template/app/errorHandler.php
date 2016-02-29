<?php

function handleError($errno, $errstr, $errfile = '', $errline = '')
{
    echo("<br>" . PHP_EOL);
    handleErrorOutputLine("ERROR $errno $errstr $errfile, $errline");
    // Write a trace
    $e = new Exception($errstr, $errno);
    $step = 0;
    $trace = $e->getTrace();
    foreach ($trace as $entry) {
        $line = '#' . ++$step . ": {$entry['file']}({$entry['line']})";
        handleErrorOutputLine($line);
    }
}

/**
 * Later I will handle differently for dev/prod
 *
 * @param $line
 */
function handleErrorOutputLine($line)
{
    error_log($line);
    echo($line .  "<br>" . PHP_EOL);
}

set_error_handler('handleError', E_ALL|E_STRICT);