<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 2/28/2016
 * Time: 12:51 PM
 */

namespace TSetliff\WebAppFramework;


class Request
{
    public function get($name)
    {
        if (!isset($_REQUEST[$name])) {
            return null;
        }
        return $_REQUEST[$name];
    }
}