<?php
/**
 * This is the general init file for all things within this framework.  It is for web/console/whatever so do not put
 * things related to the context in here.
 *
 * Place those things in initWeb.php and initConsole.php
 */

require_once('config.php');
require 'errorHandler.php';

// Uncomment if using the composer auto loader
// require 'vendor/autoload.php';

// Load internal auto loader
require 'autoload.php';

// Load the config system.
$configName = '\Config\Config' . ENVIRONMENT;
$configName::setInstanceForEnvironment();

// Setup dependency injection container based on environment
$diName = '\Di\Di' . ENVIRONMENT;
$diName::setInstanceForEnvironment();