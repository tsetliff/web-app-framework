<?php
/**
 * @param $className
 */
function webAppFramework($className) {
    $parts = explode('\\', $className);
    $nameSpaceRoot = array_shift($parts);
    if ($nameSpaceRoot == 'TSetliff') {
        $fileToLoad = 'framework/' . implode('/', $parts) . '.php';
        require($fileToLoad);
    }

    // This auto loader should go after any other vendor auto loaders so this is the end of the line
    require("src/" . implode('/', $parts) . '.php');
}

spl_autoload_register('webAppFramework');