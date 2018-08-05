<?php
/**
 * User: Tom2017 Date: 8/5/2018 Time: 4:03 AM
 */

namespace WebAppFramework;
use Di\Di;
use Model\User;
use PDO;

/**
 * Class Authentication
 *
 * Simple authentication mechanism that uses PHP's built in methods
 *
 * @package WebAppFramework
 */
class Authentication
{
    const ERROR_INVALID_EMAIL = 1;
    const ERROR_INVALID_CREDENTIALS = 2;
    const ERROR_EMAIL_NOT_FOUND = 3;

    const ERROR_PASSWORD_STRENGTH = 4;
    const ERROR_USER_ALREADY_EXISTS = 5;

    public function isLoggedIn()
    {
        $session = Di::getSession();
        $userId = $session->get('user_id');
        return (bool) $userId;
    }

    public function login($email, $password)
    {
        $email = trim($email);
        $password = trim($password);

        if (!$email) {
            return self::ERROR_INVALID_EMAIL;
        }

        if (!$password) {
            return self::ERROR_INVALID_CREDENTIALS;
        }

        $pdo = Di::getPdo();
        $stmt = $pdo->prepare("SELECT user_id, password FROM users WHERE email=?");
        $stmt->execute([$email]);
        $results = $stmt->fetchAll();
        if (count($results) > 1) {
            Di::getLog()->error("Somehow we have more then one user with the email $email!");
            return self::ERROR_INVALID_CREDENTIALS;
        }

        if (count($results) < 1) {
            return self::ERROR_EMAIL_NOT_FOUND;
        }

        $hash = $results[0]['password'];
        $userId = $results[0]['user_id'];
        if (password_verify($password, $hash)) {
            if (password_needs_rehash($hash, PASSWORD_DEFAULT)) {
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "UPDATE users SET password=? WHERE user_id=?";
                Di::getPdo()->query($sql)->execute([$newHash, $userId]);
            }

            Di::getSession()->set('user_id', $userId);

            return true;
        }

        return self::ERROR_INVALID_CREDENTIALS;
    }

    public function logout()
    {
        $session = Di::getSession();
        $session->destroy();
    }

    public function userExists($email)
    {
        $pdo = Di::getPdo();
        $stmt = $pdo->prepare("SELECT user_id, password FROM users WHERE email=?");
        $stmt->execute([$email]);
        $results = $stmt->fetchAll();
        return $results;
    }

    public function getLoggedInUserId()
    {
        return Di::getSession()->get('user_id');
    }

    /**
     * @return null|User
     */
    public function getLoggedInUser()
    {
        $loggedInUserId = $this->getLoggedInUserId();
        if (!$loggedInUserId) {
            return null;
        }
        return User::newFromId($loggedInUserId);
    }

    public function addUser($email, $password, $firstName, $lastName)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return self::ERROR_INVALID_EMAIL;
        }

        if (!$password) {
            return self::ERROR_PASSWORD_STRENGTH;
        }

        if (strlen($password) < 8) {
            return self::ERROR_PASSWORD_STRENGTH;
        }

        if ($this->userExists($email)) {
            return self::ERROR_USER_ALREADY_EXISTS;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users SET first_name=?, last_name=?, email=?, password=?";
        Di::getPdo()->prepare($sql)->execute([$firstName, $lastName, $email, $hashedPassword]);

        return true;
    }

    public function getErrorAsString($errorCode)
    {
        switch ($errorCode) {
            case self::ERROR_INVALID_CREDENTIALS:
                return "Unable to authenticate those credentials, please try again.";
            case self::ERROR_PASSWORD_STRENGTH:
                return "You did not create a strong enough password.";
            case self::ERROR_INVALID_EMAIL:
                return "You must provide a valid email address.";
            case self::ERROR_EMAIL_NOT_FOUND:
                return "Unable to find a user with that email address in our system.";
            case self::ERROR_USER_ALREADY_EXISTS:
                return "A user with that email address alraedy exists in our system.";
            default:
                return "Unknown error code $errorCode.";
        }
    }
}