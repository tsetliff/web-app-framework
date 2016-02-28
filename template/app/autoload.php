<?php
/**
 * @param $className
 */
function webAppFramework($className) {
    // This auto loader should go after any other vendor auto loaders so this is the end of the line
    $parts = explode('\\', $className);
    require("src/" . implode('/', $parts) . '.php');
}

spl_autoload_register('webAppFramework');