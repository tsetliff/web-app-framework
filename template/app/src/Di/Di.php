<?php
namespace Di;

use Config\Config;
use PDO;
use WebAppFramework\Authentication;
use WebAppFramework\Db\Db;
use WebAppFramework\DiBase;
use WebAppFramework\Log;
use WebAppFramework\Request;
use WebAppFramework\Response;
use WebAppFramework\Session;

/**
 * Class Di
 *
 * Each object actually requires 2 methods, this was just to standardize on allowing Di to be called with static
 * methods and skip the instance call on Di::instance()->getRequest() that would otherwise be everywhere in the code.
 *
 * @package Di
 */
class Di extends DiBase
{
    /**
     * @return Request
     */
    public static function getRequest()
    {
        return self::instance()->initRequest();
    }

    public function initRequest()
    {
        return $this->getSingleton(__METHOD__, function() {
            return new Request();
        });
    }

    /**
     * @return Response
     */
    public static function getResponse()
    {
        return self::instance()->initResponse();
    }

    public function initResponse()
    {
        return $this->getSingleton(__METHOD__, function() {
            return new Response();
        });
    }

    /**
     * Get PHP's PDO database driver directly.
     *
     * You can use this if you don't want to use the Db class.
     *
     * @return PDO
     */
    public static function getPdo()
    {
        return self::instance()->initPdo();
    }

    public function initPdo()
    {
        return $this->getSingleton(__METHOD__, function() {
            $config = Config::instance();

            $user = $config->databaseUsername;
            $pass = $config->databasePassword;
            $host = $config->databaseHost;
            $name = $config->databaseName;
            $port = $config->databasePort;

            $dsn = "mysql:host=$host;dbname=$name;port=$port;charset=utf8mb4";

            $opt = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            return new PDO($dsn, $user, $pass, $opt);
        });
    }

    /**
     * Return the mechanism that you want to use for logging
     *
     * @return Log
     * @throws \Exception
     */
    public static function getLog()
    {
        return self::instance()->initLog();
    }

    public function initLog()
    {
        return $this->getSingleton(__METHOD__, function() {
            return new Log();
        });
    }

    /**
     * PDO wrapper to dumb int down and use fewer defines in code for simple associative arrays
     *
     * @return Db
     * @throws \Exception
     */
    public static function getDb()
    {
        return self::instance()->initDb();
    }

    public function initDb()
    {
        return $this->getSingleton(__METHOD__, function() {
            return new Db($this->initPdo());
        });
    }

    /**
     * Return the mechanism that you want to use for logging
     *
     * @return Authentication
     * @throws \Exception
     */
    public static function getAuth()
    {
        return self::instance()->initAuth();
    }

    public function initAuth()
    {
        return $this->getSingleton(__METHOD__, function() {
            return new Authentication();
        });
    }

    /**
     * Is a container around PHP's session stuff.
     * PHP session stuff has some locking issues and other things so if you want to replace it you can extend
     * the session class and do something else.
     *
     * @return Session
     * @throws \Exception
     */
    public static function getSession()
    {
        return self::instance()->initSession();
    }

    public function initSession()
    {
        return $this->getSingleton(__METHOD__, function() {
            return new Session();
        });
    }
}