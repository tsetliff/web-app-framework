<?php
namespace TSetliff\WebAppFramework;

class Kernel {
    public function __construct()
    {
        // When using redirect in .htaccess instead of PATH_INFO the data is in REDIRECT_PATH_INFO
        if (isset($_SERVER['REDIRECT_PATH_INFO']) && $_SERVER['REDIRECT_PATH_INFO']) {
            $_SERVER['PATH_INFO'] = $_SERVER['REDIRECT_PATH_INFO'];
        }
    }

    public function route()
    {
        if (!isset($_SERVER['PATH_INFO']) || !$_SERVER['PATH_INFO']) {
            // Just call the default controller
            $controllerClassName = PROJECT_NAMESPACE . '\\Controller\\DefaultController';
            $controllerClass = new $controllerClassName(DiBase::instance()->getRequest(), DiBase::instance()->getResponse());
            $controllerClass->homeAction();
            return;
        }

        // Load Controller
        $parts = explode('/', $_SERVER['PATH_INFO']);
        // Get rid of empty stuff before first slash
        if (isset($parts[0]) && !$parts[0]) {
            array_shift($parts);
        }
        $controller = $parts[0];
        // Get the request object
        $request = DiBase::instance()->getRequest();

        // Return error if controller does not exist
        $nameSpaceAsDir = str_replace('\\', '/', PROJECT_NAMESPACE);
        $controllerFileName = PROJECT_APP_DIR . "/src/$nameSpaceAsDir/Controller/{$controller}Controller.php";
        if (!file_exists($controllerFileName)) {
            $this->return404PageNotFound();
        }
        $controllerClassName = PROJECT_NAMESPACE . '\\Controller\\' . $controller . 'Controller';

        /**
         * @var ControllerBase $controllerClass
         */
        $controllerClass = new $controllerClassName(DiBase::instance()->getRequest(), DiBase::instance()->getResponse());

        // Try non REST call
        $action = $parts[1];
        $actionName = $action . 'Action';
        if (method_exists($controllerClass, $actionName)) {
            return $controllerClass->$actionName();
        }

        // Try REST call
        $restVerb = strtolower($_SERVER('REQUEST_METHOD'));
        $actionName = $restVerb . 'Action';
        if (method_exists($controllerClass, $actionName)) {
            $restParameters = array_splice($parts, 2);
            $request->setRestParameters($restParameters);
            return $controller->$actionName();
        }

        //echo("Using $controller $action and $controllerClassName $actionName");
        $this->return404PageNotFound();
    }

    protected function return404PageNotFound()
    {
        header("HTTP/1.0 404 Not Found");
        die("404 Page not found");
    }
}