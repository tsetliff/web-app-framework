<?php
namespace WebAppFramework;

class Request {
    protected $restParameters = 0;

    /**
     * Returns data from the request object
     *
     * @param $name
     * @param null $default What to return if the variable doesn't exist.
     * @return string
     */
    public function get($name, $default = null)
    {
        if (!isset($_REQUEST[$name])) {
            return $default;
        }
        return $_REQUEST[$name];
    }

    public function getRestParameter($index)
    {
        return $this->restParameters[$index];
    }

    /**
     * @return int
     */
    public function getRestParameters()
    {
        return $this->restParameters;
    }

    /**
     * @param int $restParameters
     */
    public function setRestParameters($restParameters)
    {
        $this->restParameters = $restParameters;
    }
}