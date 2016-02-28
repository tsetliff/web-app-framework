<?php
/**
 * To keep the Di class clean, the main functionality that is extended is stored in this class.
 *
 * Do not declare any dependencies here.
 */
namespace TSetliff\WebAppFramework;

class DiBase
{
    private static $instance = null;
    private static $singletons = [];

    /**
     * Protected so that this can function as a singleton
     */
    protected function __construct()
    {
    }

    //
    // This is how to get the built in classes from the base object
    //

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->getSingleton('Request', function() {
            return new Request();
        });
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->getSingleton('Response', function() {
            return new Response();
        });
    }

    //
    // Continue with more DI framework code
    //

    /**
     * @return DiBase
     * @throws \Exception if no instance exists yet.
     */
    public static function instance()
    {
        if (is_null(self::$instance)) {
            throw new \Exception("Instance does not exist to get.");
        }
        return self::$instance;
    }

    /**
     * Called from the initialization of the project to set what di container to use for the
     * current environment.
     */
    public static function setInstanceForEnvironment()
    {
        self::$instance = new static();
    }

    protected function setSingleton($name, $value)
    {
        self::$singletons[$name] = $value;
    }

    /**
     * @param $name
     * @param $callback
     *
     * @return mixed
     */
    protected function getSingleton($name, $callback)
    {
        if (!self::hasSingleton($name)) {
            $singleton = $callback();
            self::$singletons[$name] = $singleton;
            return $singleton;
        }

        return self::$singletons[$name];
    }

    protected function hasSingleton($name)
    {
        return isset(self::$singletons[$name]);
    }
}