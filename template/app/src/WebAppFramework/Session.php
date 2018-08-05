<?php
/**
 * User: Tom2017 Date: 8/5/2018 Time: 11:06 AM
 */

namespace WebAppFramework;


class Session
{
    private $destroyed = false;

    public function __construct()
    {
        $this->startSession();
    }

    public function startSession()
    {
        session_start();
    }

    public function get($name)
    {
        if ($this->destroyed) {
            throw new \Exception("Attempted to get a variable from a destroyed session.");
        }

        if (!isset($_SESSION[$name])) {
            return null;
        }

        return $_SESSION[$name];
    }

    public function has($name)
    {
        return isset($_SESSION[$name]);
    }

    public function set($name, $value)
    {
        if ($this->destroyed) {
            throw new \Exception("Attempted to set a variable on a destroyed session.");
        }
        $_SESSION[$name] = $value;
        return $this;
    }

    public function destroy()
    {
        session_destroy();
        $this->destroyed = true;
    }
}