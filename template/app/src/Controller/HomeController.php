<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 2/28/2016
 * Time: 1:14 PM
 */

namespace Controller;


use Di\Di;
use WebAppFramework\ControllerBase;
use WebAppFramework\Template;

class HomeController extends ControllerBase
{
    public function homeAction()
    {
        $template = new Template('home.php');
        $name = $this->request->get('name', '');

        if ($name) {
            $this->response->addMessage("Example of a basic message to $name");
            $this->response->addError("Example of an error");
        }

        $template->setVariable('name', $name);
        $template->render();
    }
}