<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 2/28/2016
 * Time: 1:14 PM
 */

namespace YourName\YourProject\Controller;


use TSetliff\WebAppFramework\ControllerBase;

class DefaultController extends ControllerBase
{
    public function homeAction()
    {
        // variables will continue on into the template
        $name = $this->request->get('name');
        require_once(APP_LOCATION . '/templates/helloWorld.php');
    }
}