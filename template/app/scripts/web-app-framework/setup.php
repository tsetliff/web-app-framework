<?php
/**
 * Help setting everything up
 */
use Di\Di;

require_once('../../initConsole.php');

say("Setting up the " . ENVIRONMENT . ' environment.');

// Check the app location field
if (!defined('APP_LOCATION')) {
    say("You must edit the config.php file to set the app location!");
    exit();
}

$whereImAt = APP_LOCATION . '/scripts/web-app-framework/setup.php';
if ($whereImAt != __FILE__) {
    say("The web app location does not seem to be correct. Update your config.php file.");
    say("$whereImAt != " . __FILE__);
    exit();
}
say("The App Location in the config.php file seems to be correct.");

// Check the basic database connection works
try {
    $pdo = Di::getPdo();
    say("Database connection ok.");
} catch (PDOException $e) {
    say("It looks like your database is not set up correctly.");
    say("Verify your PDO connection information in the Config classes.");
    say($e->getMessage());
}

// Check that the migrations table exists
$pdo = Di::getPdo();
$result = $pdo->query("SHOW TABLES LIKE 'migrations'")->fetchAll(PDO::FETCH_ASSOC);
$found = count($result);

if (!$found) {
    say("Unable to find the migrations table in the database. Attempting to create it.");
    $sql = "CREATE TABLE migrations (name VARCHAR(200) DEFAULT '' PRIMARY KEY, applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";
    $pdo->query($sql);
    say("The migrations table has been created.");
} else {
    say("The migrations table already exists.");
}

// Run the migrations that come with this framework
require_once('applyMigrations.php');

$sql = "SELECT COUNT(*) cnt FROM users";
$usersFound = $pdo->query($sql)->fetchColumn();

if (!$usersFound) {
    $result = false;
    while ($result !== true) {
        say("No user found, creating your admin user.");
        $firstName = readline("First Name: ");
        $lastName = readline("Last Name: ");
        $email = readline("Email: ");
        $password = readline("Password: ");

        $result = Di::getAuth()->addUser($email, $password, $firstName, $lastName);
        if ($result !== true) {
            say("That didn't work:" . Di::getAuth()->getErrorAsString($result));
        }
    }

    say("User $firstName $lastName created with email $email");
} else {
    say("A user has already been found, not creating another.");
}