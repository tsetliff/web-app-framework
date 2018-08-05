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
        $template->setVariable('name', $this->request->get('name', ''));
        $template->render();
    }
}