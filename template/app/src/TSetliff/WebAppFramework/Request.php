<?php
namespace TSetliff\WebAppFramework;

class Request {
    protected $restParameters = 0;

    /**
     * Returns data from the request object
     *
     * @param $name
     * @return string
     */
    public function get($name)
    {
        if (!isset($_REQUEST[$name])) {
            return null;
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