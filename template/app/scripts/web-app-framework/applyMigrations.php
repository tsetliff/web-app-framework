<?php
/**
 * The purpose of this script is to run any migrations you may have
 */

use Config\Config;
use Di\Di;

require_once('../../initConsole.php');

// Get a list of migrations
$migrationFileNames = glob(APP_LOCATION . '/migrations/*');

// Get a list of applied migrations
$pdo = Di::getPdo();
$appliedMigrations = $pdo->query("SELECT name FROM migrations")->fetchAll(PDO::FETCH_COLUMN);

function applyFileThroughMysqlConsole($migrationFileName)
{
    say("Applying migration $migrationFileName");

    $config = Config::instance();

    $user = escapeshellarg($config->databaseUsername);
    $pass = $config->databasePassword;
    if ($pass) {
        $pass = escapeshellarg("-p" . $pass);
    }
    $host = escapeshellarg($config->databaseHost);
    $name = escapeshellarg($config->databaseName);
    $port = escapeshellarg($config->databasePort);
    $mysqlConsoleCommand = $config->databaseConsoleCommand;
    $escapedMigrationFileName = escapeshellarg($migrationFileName);

    $cmd = "cat $escapedMigrationFileName | $mysqlConsoleCommand -h $host -P $port -u $user $pass $name ";
    exec($cmd, $output, $return);
    if ($return) {
        say("Command failed with return value $return.");
        if ($output) {
            print_r($output);
        }
        exit();
    }
}

foreach ($migrationFileNames as $migrationFileName) {
    $migrationName = basename($migrationFileName);
    if (!in_array($migrationName, $appliedMigrations)) {
        $suffix = substr($migrationFileName, -4);
        switch ($suffix) {
            case '.sql':
                applyFileThroughMysqlConsole($migrationFileName);
                break;
            case '.php':
                require($migrationFileName);
                break;
            default:
                say("Skipping file $migrationFileName as it is not in the types I can apply.");
        }
        $pdo->prepare("INSERT INTO migrations SET name=?")->execute([$migrationName]);
    } else {
        say("Skipping $migrationName, it is already applied.");
    }
}