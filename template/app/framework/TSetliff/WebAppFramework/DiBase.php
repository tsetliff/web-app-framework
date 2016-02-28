<?php
namespace TSetliff\WebAppFramework;

use Exception;

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

    public function getRequest()
    {
        return new Request();
    }

    public function getResponse()
    {
        return new Response();
    }

    /**
     * If you want to use twig or something you can override this and return that instead
     *
     * @return PhpTemplateWrapper
     */
    public function getTemplateWrapper()
    {
        return new PhpTemplateWrapper();
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
     * @return mixed
     * @throws Exception If unable to find singleton and no callback to create it.
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