<?php
require 'errorHandler.php';

require 'config.php';

// Uncomment if using the composer auto loader
// require 'vendor/autoload.php';

// Load internal auto loader
require 'autoload.php';

// Load the config system.
$configName = PROJECT_NAMESPACE . '\Config\Config' . ENVIRONMENT;
$configName::setInstanceForEnvironment();

// Setup dependency injection container based on environment
$diName = PROJECT_NAMESPACE . '\Di\Di' . ENVIRONMENT;
$diName::setInstanceForEnvironment();

session_start();