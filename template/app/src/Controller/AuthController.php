<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 2/28/2016
 * Time: 1:14 PM
 */

namespace Controller;


use Config\Config;
use Di\Di;
use WebAppFramework\ControllerBase;
use WebAppFramework\Template;

class AuthController extends ControllerBase
{
    public function loginAction()
    {
        $login = Di::getAuth()->login($this->request->get('email'), $this->request->get('password'));
        if ($login === true) {
            $websiteRoot = Config::instance()->websiteRoot;
            header("Location: $websiteRoot/");
            return;
        }

        // Failed :-(
        $template = new Template('users/loginFailed.php');
        $template->setVariable('error', Di::getAuth()->getErrorAsString($login));
        $template->render();
    }

    public function logoutAction()
    {
        Di::getAuth()->logout();

        $websiteRoot = Config::instance()->websiteRoot;
        header("Location: $websiteRoot/");
    }
}