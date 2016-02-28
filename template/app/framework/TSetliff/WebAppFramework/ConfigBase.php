<?php
namespace TSetliff\WebAppFramework;

/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 2/28/2016
 * Time: 2:36 AM
 */
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