<?php
namespace Config;

use WebAppFramework\ConfigBase;

/**
 * Class Config
 *
 * @package Config
 */
class Config extends ConfigBase
{
    // Where is this website?
    public $websiteRoot = 'http://192.168.1.19';

    // Basic connection from PHP to a mysql database.
    public $databaseHost = 'localhost';
    public $databaseName = 'test';
    public $databasePort = 3306;
    public $databaseUsername = 'test';
    public $databasePassword = 'test';
    public $databaseConsoleCommand = 'mysql'; // Where to pipe mysql migration scripts to

    // Writable file store
    public $fileStore = APP_LOCATION . '/storage';
}