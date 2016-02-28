<?php
/**
 * To keep the Config class clean, the main functionality that is extended is stored in this class.
 *
 * Do not declare any configuration here
 */
namespace TSetliff\WebAppFramework;

class ConfigBase
{
    public static $instance;

    /**
     * Protected so that this can function as a singleton
     */
    protected function __construct()
    {
    }

    /**
     * @return ConfigBase
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
}