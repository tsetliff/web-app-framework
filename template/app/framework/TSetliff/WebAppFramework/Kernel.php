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
        // Set the defaults
        $controller = 'Default';
        $action = 'home';
        if (isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO']) {
            $parts = explode('/', $_SERVER['PATH_INFO']);

            $requestedAction = array_pop($parts);
            if ($requestedAction) {
                $action = $requestedAction;
            }

            if (count($parts)) {
                $requestedController = array_pop($parts);
                if ($requestedController) {
                    $controller = $requestedController;
                }
            }
        }

        $controllerClassName = PROJECT_NAMESPACE . '\\' . $controller . 'Controller';
        $controllerFileClassName = APP_LOCATION . "/src/" . PROJECT_NAMESPACE . "/Controller/{$controller}Controller.php";
        $actionMethodName = $action . 'Action';

        // echo("Using $controller $action and $controllerClassName $actionMethodName file $controllerFileClassName");

        if (file_exists($controllerFileClassName)) {
            $controllerClass = new $controllerClassName();
            if (method_exists($controllerClass, $actionMethodName)) {
                return $controllerClass->$actionMethodName();
            }
        }

        // This should probably turn into a logged error and a 404 page
        die('Unable to process route');
    }
}